<?php

namespace App\Livewire\Admin\Invoices;

use App\Models\Invoice;
use App\Models\Account;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Stripe\Stripe;
use Stripe\Invoice as StripeInvoice;
use Illuminate\Support\Collection;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $status = '';

    #[Url]
    public $sortBy = 'created_at';

    #[Url]
    public $sortDirection = 'desc';

    #[Url]
    public $source = ''; // 'reseller', 'stripe', or '' for all

    public $showInvoiceModal = false;
    public $selectedInvoice = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSource()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function getInvoicesProperty()
    {
        $invoices = collect();

        // Get reseller-managed invoices (from database)
        if ($this->source === '' || $this->source === 'reseller') {
            $resellerInvoices = Invoice::query()
                ->with(['account', 'plan'])
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('invoice_number', 'like', '%' . $this->search . '%')
                            ->orWhereHas('account', function ($accountQuery) {
                                $accountQuery->where('company_name', 'like', '%' . $this->search . '%');
                            });
                    });
                })
                ->when($this->status, function ($query) {
                    $query->where('status', $this->status);
                })
                ->get()
                ->map(function ($invoice) {
                    return [
                        'id' => 'db_' . $invoice->id,
                        'source' => 'reseller',
                        'invoice_number' => $invoice->invoice_number,
                        'account_name' => $invoice->account->company_name,
                        'account_id' => $invoice->account_id,
                        'plan_name' => $invoice->plan->name ?? null,
                        'amount' => $invoice->amount,
                        'currency' => 'gbp',
                        'status' => $invoice->status,
                        'issue_date' => $invoice->issue_date,
                        'due_date' => $invoice->due_date,
                        'paid_at' => $invoice->paid_at,
                        'stripe_invoice_url' => null,
                        'stripe_invoice_pdf' => null,
                        'created_at' => $invoice->created_at,
                    ];
                });

            $invoices = $invoices->merge($resellerInvoices);
        }

        // Get Stripe invoices
        if ($this->source === '' || $this->source === 'stripe') {
            $stripeInvoices = $this->fetchStripeInvoices();
            $invoices = $invoices->merge($stripeInvoices);
        }

        // Sort and filter
        $invoices = $invoices
            ->when($this->search, function ($collection) {
                return $collection->filter(function ($invoice) {
                    return stripos($invoice['invoice_number'], $this->search) !== false ||
                           stripos($invoice['account_name'], $this->search) !== false;
                });
            })
            ->when($this->status, function ($collection) {
                return $collection->filter(function ($invoice) {
                    return $invoice['status'] === $this->status;
                });
            })
            ->sortBy([
                [$this->sortBy, $this->sortDirection === 'desc' ? 'desc' : 'asc']
            ]);

        return $invoices;
    }

    protected function fetchStripeInvoices(): Collection
    {
        try {
            $secretKey = config('services.stripe.secret');
            
            if (empty($secretKey)) {
                return collect();
            }

            Stripe::setApiKey($secretKey);
            
            // Fetch invoices from Stripe
            $stripeInvoices = StripeInvoice::all([
                'limit' => 100,
                'expand' => ['data.customer', 'data.subscription'],
            ]);

            return collect($stripeInvoices->data)->map(function ($stripeInvoice) {
                // Try to find the account by Stripe customer ID
                $account = Account::where('stripe_id', $stripeInvoice->customer)->first();
                
                // Map Stripe status to our status
                $status = match($stripeInvoice->status) {
                    'paid' => 'paid',
                    'open' => 'pending',
                    'void' => 'cancelled',
                    'uncollectible' => 'failed',
                    default => 'pending',
                };

                return [
                    'id' => 'stripe_' . $stripeInvoice->id,
                    'source' => 'stripe',
                    'invoice_number' => $stripeInvoice->number ?? $stripeInvoice->id,
                    'account_name' => $account ? $account->company_name : ($stripeInvoice->customer_name ?? 'Unknown Customer'),
                    'account_id' => $account->id ?? null,
                    'plan_name' => null, // Could extract from subscription if needed
                    'amount' => $stripeInvoice->amount_due / 100,
                    'currency' => strtoupper($stripeInvoice->currency),
                    'status' => $status,
                    'issue_date' => \Carbon\Carbon::createFromTimestamp($stripeInvoice->created),
                    'due_date' => $stripeInvoice->due_date ? \Carbon\Carbon::createFromTimestamp($stripeInvoice->due_date) : null,
                    'paid_at' => $stripeInvoice->status_transitions->paid_at ? \Carbon\Carbon::createFromTimestamp($stripeInvoice->status_transitions->paid_at) : null,
                    'stripe_invoice_url' => $stripeInvoice->hosted_invoice_url,
                    'stripe_invoice_pdf' => $stripeInvoice->invoice_pdf,
                    'created_at' => \Carbon\Carbon::createFromTimestamp($stripeInvoice->created),
                ];
            });

        } catch (\Exception $e) {
            \Log::error('Failed to fetch Stripe invoices', [
                'error' => $e->getMessage()
            ]);
            return collect();
        }
    }

    public function getTotalRevenueProperty()
    {
        return Invoice::where('status', 'paid')->sum('amount');
    }

    public function getPendingRevenueProperty()
    {
        return Invoice::where('status', 'pending')->sum('amount');
    }

    public function getOverdueCountProperty()
    {
        return Invoice::where('status', 'pending')
            ->whereDate('due_date', '<', now())
            ->count();
    }

    public function viewInvoice($invoiceId)
    {
        // Extract actual ID from prefixed ID (e.g., "db_1" -> 1)
        if (str_starts_with($invoiceId, 'db_')) {
            $dbId = str_replace('db_', '', $invoiceId);
            $invoice = Invoice::with(['account', 'plan'])->find($dbId);
            
            if ($invoice) {
                $this->selectedInvoice = [
                    'id' => 'db_' . $invoice->id,
                    'source' => 'reseller',
                    'invoice_number' => $invoice->invoice_number,
                    'account_name' => $invoice->account->company_name,
                    'account_id' => $invoice->account_id,
                    'plan_name' => $invoice->plan->name ?? null,
                    'amount' => $invoice->amount,
                    'currency' => 'GBP',
                    'status' => $invoice->status,
                    'issue_date' => $invoice->issue_date,
                    'due_date' => $invoice->due_date,
                    'paid_at' => $invoice->paid_at,
                    'notes' => $invoice->notes,
                ];
                $this->showInvoiceModal = true;
            }
        }
    }

    public function closeInvoiceModal()
    {
        $this->showInvoiceModal = false;
        $this->selectedInvoice = null;
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.invoices.index');
    }
}
