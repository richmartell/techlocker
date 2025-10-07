<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'registration',
        'name',
        'vehicle_make_id',
        'vehicle_model_id',
        'last_dvla_sync_at',
        'colour',
        'engine_capacity',
        'fuel_type',
        'year_of_manufacture',
        'co2_emissions',
        'marked_for_export',
        'month_of_first_registration',
        'mot_status',
        'revenue_weight',
        'tax_due_date',
        'tax_status',
        'type_approval',
        'wheelplan',
        'euro_status',
        'real_driving_emissions',
        'date_of_last_v5c_issued',
        'transmission',
        'forward_gears',
        'combined_vin',
        'haynes_model_variant_description',
        'last_haynespro_sync_at',
        'dvla_date_of_manufacture',
        'dvla_last_mileage',
        'dvla_last_mileage_date',
        'haynes_maximum_power_at_rpm',
        'tecdoc_ktype',
        'car_type_id',
        'available_subjects',
        'car_type_identified_at',
        'notes',
    ];

    protected $dates = [
        'last_dvla_sync_at',
        'tax_due_date',
        'date_of_last_v5c_issued',
        'last_haynespro_sync_at',
    ];

    protected $casts = [
        'last_dvla_sync_at' => 'datetime',
        'last_haynespro_sync_at' => 'datetime',
        'car_type_identified_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Global scope to filter by current user's account
        static::addGlobalScope('account', function ($builder) {
            if (auth()->check() && auth()->user()->account_id) {
                $builder->where('account_id', auth()->user()->account_id);
            }
        });

        static::creating(function ($vehicle) {
            // Automatically set account_id when creating
            if (auth()->check() && auth()->user()->account_id && !$vehicle->account_id) {
                $vehicle->account_id = auth()->user()->account_id;
            }
        });
    }

    /**
     * Get account relationship.
     */
    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Account::class);
    }

    public function make(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\VehicleMake::class, 'vehicle_make_id');
    }

    public function model(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\VehicleModel::class, 'vehicle_model_id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(VehicleJob::class, 'vehicle_id');
    }

    /**
     * Get the available subjects as an array
     */
    public function getAvailableSubjectsArrayAttribute()
    {
        if (empty($this->available_subjects)) {
            return [];
        }
        return array_filter(explode(',', $this->available_subjects));
    }

    /**
     * Set the available subjects from an array
     */
    public function setAvailableSubjectsFromArray(array $subjects)
    {
        $this->available_subjects = implode(',', array_filter($subjects));
    }

    /**
     * Check if the vehicle has a valid car type identification
     */
    public function hasCarTypeIdentification(): bool
    {
        return !empty($this->car_type_id) && !empty($this->car_type_identified_at);
    }

    /**
     * Check if the car type identification is recent (within 24 hours)
     */
    public function hasRecentCarTypeIdentification(): bool
    {
        return $this->hasCarTypeIdentification() && 
               $this->car_type_identified_at->diffInHours(now()) < 24;
    }

    /**
     * Get customers relationship.
     */
    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Customer::class, 'customer_vehicle')
            ->withPivot(['relationship', 'owned_from', 'owned_to'])
            ->withTimestamps()
            ->orderBy('customer_vehicle.created_at', 'desc');
    }

    /**
     * Get current customers (where owned_to is null).
     */
    public function currentCustomers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->customers()->wherePivotNull('owned_to');
    }

    /**
     * Get current owners.
     */
    public function currentOwners(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->currentCustomers()->wherePivot('relationship', 'owner');
    }

    /**
     * Get the primary owner (first current owner).
     */
    public function primaryOwner(): ?\App\Models\Customer
    {
        return $this->currentOwners()->first();
    }
} 