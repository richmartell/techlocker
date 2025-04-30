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
    ];

    protected $dates = [
        'last_dvla_sync_at',
        'tax_due_date',
        'date_of_last_v5c_issued',
    ];

    protected $casts = [
        'last_dvla_sync_at' => 'datetime',
    ];

    public function make(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(VehicleMake::class, 'vehicle_make_id');
    }

    public function model(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }
} 