<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Reseller extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_name',
        'phone',
        'commission_rate',
        'fallback_discount_percentage',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'commission_rate' => 'decimal:2',
        'fallback_discount_percentage' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the accounts for this reseller.
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Get the commissions for this reseller.
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    /**
     * Get the total number of trials created.
     */
    public function getTrialsCreatedAttribute(): int
    {
        return $this->accounts()->whereNotNull('trial_started_at')->count();
    }

    /**
     * Get the number of converted trials.
     */
    public function getTrialsConvertedAttribute(): int
    {
        return $this->accounts()->where('status', 'active')->count();
    }

    /**
     * Get the total commission earned.
     */
    public function getTotalCommissionEarnedAttribute(): float
    {
        return (float) $this->commissions()->sum('amount');
    }

    /**
     * Get the total commission paid.
     */
    public function getTotalCommissionPaidAttribute(): float
    {
        return (float) $this->commissions()->where('status', 'paid')->sum('amount');
    }

    /**
     * Get the pending commission amount.
     */
    public function getPendingCommissionAttribute(): float
    {
        return (float) $this->commissions()->where('status', 'pending')->sum('amount');
    }

    /**
     * Get the custom plan prices for this reseller.
     */
    public function planPrices(): HasMany
    {
        return $this->hasMany(ResellerPlanPrice::class);
    }

    /**
     * Get the plans with custom pricing (many-to-many with pivot data).
     */
    public function plansWithPricing(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'reseller_plan_prices')
            ->withPivot('price')
            ->withTimestamps();
    }

    /**
     * Get the price a reseller pays for a specific plan (annual pricing).
     * Returns custom price if set, otherwise applies fallback discount.
     */
    public function getPriceForPlan(Plan $plan): float
    {
        // Check if custom price exists
        $customPrice = $this->planPrices()
            ->where('plan_id', $plan->id)
            ->first();

        if ($customPrice) {
            return (float) $customPrice->price;
        }

        // Fall back to percentage discount from Stripe yearly price
        $stripePrice = $plan->getStripeYearlyCost();
        $basePrice = $stripePrice ? $stripePrice['amount'] / 100 : ($plan->price * 12);

        if ($this->fallback_discount_percentage > 0) {
            $discount = $basePrice * ($this->fallback_discount_percentage / 100);
            return $basePrice - $discount;
        }

        return $basePrice;
    }

    /**
     * Calculate the margin for a reseller on a specific plan (annual).
     */
    public function getMarginForPlan(Plan $plan): float
    {
        $stripePrice = $plan->getStripeYearlyCost();
        $retailPrice = $stripePrice ? $stripePrice['amount'] / 100 : ($plan->price * 12);
        $resellerPrice = $this->getPriceForPlan($plan);

        return $retailPrice - $resellerPrice;
    }

    /**
     * Get the reseller's initials
     */
    public function initials(): string
    {
        return \Illuminate\Support\Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => \Illuminate\Support\Str::of($name)->substr(0, 1))
            ->implode('');
    }
}
