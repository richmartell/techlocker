<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Cashier\Billable;

class Account extends Model
{
    use HasFactory, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'registered_address',
        'town',
        'county',
        'post_code',
        'country',
        'vat_number',
        'company_phone',
        'company_email',
        'web_address',
        'is_active',
        'hourly_labour_rate',
        'labour_loading_percentage',
        'plan_id',
        'reseller_id',
        'trial_started_at',
        'trial_ends_at',
        'status',
        'subscribed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'hourly_labour_rate' => 'decimal:2',
        'labour_loading_percentage' => 'decimal:4',
        'trial_started_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'subscribed_at' => 'datetime',
    ];

    /**
     * Get the users for the account.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the customers for the account.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get the vehicles for the account.
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Get the invoices for the account.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the formatted hourly labour rate.
     */
    public function getFormattedHourlyRateAttribute(): string
    {
        return '£' . number_format($this->hourly_labour_rate, 2);
    }

    /**
     * Get the labour loading percentage as a formatted percentage.
     */
    public function getFormattedLabourLoadingAttribute(): string
    {
        return number_format($this->labour_loading_percentage * 100, 1) . '%';
    }

    /**
     * Apply labour loading to a given time estimate (in hours).
     */
    public function applyLabourLoading(float $estimatedHours): float
    {
        return $estimatedHours * (1 + $this->labour_loading_percentage);
    }

    /**
     * Get the plan that the account belongs to.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the reseller that the account belongs to.
     */
    public function reseller(): BelongsTo
    {
        return $this->belongsTo(Reseller::class);
    }

    /**
     * Check if the account is on an active trial.
     */
    public function isOnTrial(): bool
    {
        return $this->status === 'trial' 
            && $this->trial_ends_at 
            && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if the account's trial has expired.
     */
    public function hasExpiredTrial(): bool
    {
        return $this->status === 'trial_expired' 
            || ($this->trial_ends_at && $this->trial_ends_at->isPast() && $this->status === 'trial');
    }

    /**
     * Get the number of days remaining in the trial.
     */
    public function trialDaysRemaining(): ?int
    {
        if (!$this->trial_ends_at || !$this->isOnTrial()) {
            return null;
        }

        return (int) now()->diffInDays($this->trial_ends_at, false);
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'trial' => 'lime',
            'active' => 'green',
            'trial_expired' => 'orange',
            'churned' => 'red',
            default => 'zinc',
        };
    }

    /**
     * Get the formatted status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'trial' => 'Trial',
            'active' => 'Active',
            'trial_expired' => 'Trial Expired',
            'churned' => 'Churned',
            default => ucfirst($this->status ?? 'Unknown'),
        };
    }
} 