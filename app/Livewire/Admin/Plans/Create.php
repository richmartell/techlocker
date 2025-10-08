<?php

namespace App\Livewire\Admin\Plans;

use App\Models\Plan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Stripe\Stripe;
use Stripe\Price;
use Stripe\Exception\ApiErrorException;

class Create extends Component
{

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('nullable|string')]
    public $description = '';

    public $monthly_price_display = '';
    public $yearly_price_display = '';

    #[Rule('nullable|integer|min:1')]
    public $max_users = '';

    #[Rule('nullable|integer|min:1')]
    public $max_customers = '';

    #[Rule('nullable|integer|min:1')]
    public $max_searches = '';

    #[Rule('boolean')]
    public $is_active = true;

    #[Rule('nullable|string|max:255')]
    public $stripe_monthly_price_id = '';

    #[Rule('nullable|string|max:255')]
    public $stripe_yearly_price_id = '';

    public $showStripePricesModal = false;
    public $stripePrices = [];
    public $stripePricesLoading = false;
    public $stripePricesError = null;
    public $selectingPriceFor = null; // 'monthly' or 'yearly'

    public function mount()
    {
        // Nothing to mount for create
    }

    public function save()
    {
        $validated = $this->validate();

        // Convert empty strings to null for nullable fields
        $validated['max_users'] = $validated['max_users'] ?: null;
        $validated['max_customers'] = $validated['max_customers'] ?: null;
        $validated['max_searches'] = $validated['max_searches'] ?: null;
        $validated['stripe_monthly_price_id'] = $validated['stripe_monthly_price_id'] ?: null;
        $validated['stripe_yearly_price_id'] = $validated['stripe_yearly_price_id'] ?: null;

        // Fetch and store price from Stripe as fallback
        if ($validated['stripe_monthly_price_id']) {
            try {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                $stripePrice = \Stripe\Price::retrieve($validated['stripe_monthly_price_id']);
                $validated['price'] = $stripePrice->unit_amount / 100;
            } catch (\Exception $e) {
                $validated['price'] = 0;
            }
        } else {
            $validated['price'] = 0;
        }

        Plan::create($validated);
        session()->flash('success', 'Plan created successfully.');

        return redirect()->route('admin.plans.index');
    }

    /**
     * Open modal to browse Stripe prices
     */
    public function openStripePricesModal($priceType = 'monthly')
    {
        $this->selectingPriceFor = $priceType;
        $this->showStripePricesModal = true;
        $this->stripePricesError = null;
        $this->fetchStripePrices();
    }

    /**
     * Fetch prices from Stripe
     */
    public function fetchStripePrices()
    {
        $this->stripePricesLoading = true;
        $this->stripePricesError = null;
        $this->stripePrices = [];

        try {
            $secretKey = config('services.stripe.secret');
            
            // Check if API key is configured
            if (empty($secretKey)) {
                $this->stripePricesError = 'Stripe API key is not configured. Please add STRIPE_SECRET to your .env file and run: php artisan config:clear';
                $this->stripePricesLoading = false;
                return;
            }
            
            Stripe::setApiKey($secretKey);
            
            // Fetch active prices with their associated products
            $prices = Price::all([
                'active' => true,
                'limit' => 100,
                'expand' => ['data.product'],
            ]);

            // Filter for active products and map the data
            $filteredPrices = collect($prices->data)
                ->filter(function($price) {
                    // Only include if product exists and is active
                    return isset($price->product) 
                        && !is_string($price->product) 
                        && ($price->product->active ?? false);
                })
                ->map(function ($price) {
                    return [
                        'id' => $price->id,
                        'product_name' => $price->product->name ?? 'Unknown Product',
                        'product_description' => $price->product->description ?? '',
                        'amount' => $price->unit_amount,
                        'currency' => strtoupper($price->currency),
                        'interval' => $price->recurring->interval ?? 'one_time',
                        'interval_count' => $price->recurring->interval_count ?? 1,
                        'type' => $price->type,
                    ];
                })
                ->sortBy('product_name')
                ->values();

            $this->stripePrices = $filteredPrices->toArray();

            // If no prices found, provide helpful message
            if (empty($this->stripePrices)) {
                $this->stripePricesError = 'No active prices found in your Stripe account. Please create products and prices in Stripe first.';
            }

        } catch (ApiErrorException $e) {
            $errorMsg = $e->getMessage();
            if (str_contains($errorMsg, 'Invalid API Key')) {
                $this->stripePricesError = 'Invalid Stripe API key. Please check your STRIPE_SECRET in .env';
            } else {
                $this->stripePricesError = 'Stripe API Error: ' . $errorMsg;
            }
        } catch (\Exception $e) {
            $this->stripePricesError = 'Error: ' . $e->getMessage();
        } finally {
            $this->stripePricesLoading = false;
        }
    }

    /**
     * Select a Stripe price
     */
    public function selectStripePrice($priceId)
    {
        if ($this->selectingPriceFor === 'monthly') {
            $this->stripe_monthly_price_id = $priceId;
        } else {
            $this->stripe_yearly_price_id = $priceId;
        }

        $this->updatePriceDisplays();
        $this->closeStripePricesModal();
    }

    /**
     * Update price displays from Stripe
     */
    protected function updatePriceDisplays()
    {
        // Update monthly price display
        if ($this->stripe_monthly_price_id) {
            $priceData = collect($this->stripePrices)->firstWhere('id', $this->stripe_monthly_price_id);
            if ($priceData) {
                $this->monthly_price_display = $priceData['currency'] . ' ' . number_format($priceData['amount'] / 100, 2);
            } else {
                // Fetch from Stripe if not in current list
                try {
                    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                    $price = \Stripe\Price::retrieve($this->stripe_monthly_price_id);
                    $this->monthly_price_display = strtoupper($price->currency) . ' ' . number_format($price->unit_amount / 100, 2);
                } catch (\Exception $e) {
                    $this->monthly_price_display = 'Unable to fetch';
                }
            }
        } else {
            $this->monthly_price_display = '';
        }

        // Update yearly price display
        if ($this->stripe_yearly_price_id) {
            $priceData = collect($this->stripePrices)->firstWhere('id', $this->stripe_yearly_price_id);
            if ($priceData) {
                $this->yearly_price_display = $priceData['currency'] . ' ' . number_format($priceData['amount'] / 100, 2);
            } else {
                // Fetch from Stripe if not in current list
                try {
                    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                    $price = \Stripe\Price::retrieve($this->stripe_yearly_price_id);
                    $this->yearly_price_display = strtoupper($price->currency) . ' ' . number_format($price->unit_amount / 100, 2);
                } catch (\Exception $e) {
                    $this->yearly_price_display = 'Unable to fetch';
                }
            }
        } else {
            $this->yearly_price_display = '';
        }
    }

    /**
     * Close the Stripe prices modal
     */
    public function closeStripePricesModal()
    {
        $this->showStripePricesModal = false;
        $this->stripePrices = [];
        $this->stripePricesError = null;
        $this->selectingPriceFor = null;
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.plans.create');
    }
}
