<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

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
        'labour_loading_percentage'
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
} 