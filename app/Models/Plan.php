<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'max_users',
        'max_customers',
        'max_searches',
        'is_active',
        'stripe_monthly_price_id',
        'stripe_yearly_price_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the accounts for this plan.
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Get the price from Stripe for the monthly plan
     */
    public function getStripeMonthlyCost(): ?array
    {
        if (!$this->stripe_monthly_price_id) {
            return null;
        }

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $price = \Stripe\Price::retrieve($this->stripe_monthly_price_id);
            
            return [
                'amount' => $price->unit_amount,
                'currency' => strtoupper($price->currency),
                'formatted' => strtoupper($price->currency) . ' ' . number_format($price->unit_amount / 100, 2),
                'interval' => $price->recurring->interval ?? null,
            ];
        } catch (\Exception $e) {
            \Log::error('Failed to fetch Stripe price', [
                'plan_id' => $this->id,
                'stripe_price_id' => $this->stripe_monthly_price_id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get the price from Stripe for the yearly plan
     */
    public function getStripeYearlyCost(): ?array
    {
        if (!$this->stripe_yearly_price_id) {
            return null;
        }

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $price = \Stripe\Price::retrieve($this->stripe_yearly_price_id);
            
            return [
                'amount' => $price->unit_amount,
                'currency' => strtoupper($price->currency),
                'formatted' => strtoupper($price->currency) . ' ' . number_format($price->unit_amount / 100, 2),
                'interval' => $price->recurring->interval ?? null,
            ];
        } catch (\Exception $e) {
            \Log::error('Failed to fetch Stripe price', [
                'plan_id' => $this->id,
                'stripe_price_id' => $this->stripe_yearly_price_id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get the display price (from Stripe or fallback to database)
     */
    public function getDisplayPrice(): string
    {
        $stripePrice = $this->getStripeMonthlyCost();
        
        if ($stripePrice) {
            return $stripePrice['formatted'] . '/mo';
        }
        
        // Fallback to database price if Stripe unavailable
        return '£' . number_format($this->price, 2) . '/mo';
    }
}
