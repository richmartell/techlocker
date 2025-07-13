<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
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
    ];

    public function make(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\VehicleMake::class, 'vehicle_make_id');
    }

    public function model(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\VehicleModel::class, 'vehicle_model_id');
    }
} 