<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HaynesProVehicle extends Model
{
    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'car_type_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     */
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'car_type_id',
        'adjustments',
        'maintenance_systems',
        'maintenance_tasks',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'adjustments' => 'array',
        'maintenance_systems' => 'array',
        'maintenance_tasks' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Check if the cached data is still fresh (within 24 hours).
     */
    public function isFresh(): bool
    {
        return $this->created_at->gt(Carbon::now()->subHours(24));
    }

    /**
     * Get or create a cache record for the given car type ID.
     */
    public static function getOrCreate(int $carTypeId): self
    {
        return static::firstOrCreate(
            ['car_type_id' => $carTypeId],
            [
                'adjustments' => null,
                'maintenance_systems' => null,
                'maintenance_tasks' => null,
            ]
        );
    }

    /**
     * Update a specific data type for this vehicle.
     */
    public function updateData(string $type, array $data): void
    {
        $this->update([
            $type => $data,
            'updated_at' => now(),
        ]);
    }

    /**
     * Scope to get records older than 24 hours.
     */
    public function scopeExpired($query)
    {
        return $query->where('created_at', '<', Carbon::now()->subHours(24));
    }

    /**
     * Purge expired records from the database.
     */
    public static function purgeExpired(): int
    {
        return static::expired()->delete();
    }
}
