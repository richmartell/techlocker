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
        'vehicle_identification_data',
        'adjustments',
        'maintenance_systems',
        'maintenance_tasks',
        'maintenance_stories',
        'maintenance_service_reset',
        'repair_time_infos',
        'technical_drawings',
        'wiring_diagrams',
        'fuse_locations',
        'technical_bulletins',
        'recalls',
        'management_systems',
        'story_overview',
        'warning_lights',
        'engine_location',
        'lubricants',
        'pids',
        'test_procedures',
        'structure',
        'maintenance_forms',
        'maintenance_system_overview',
        'maintenance_intervals',
        'timing_belt_maintenance',
        'timing_belt_intervals',
        'wear_parts_intervals',
        'available_subjects',
        'last_comprehensive_fetch',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'vehicle_identification_data' => 'array',
        'adjustments' => 'array',
        'maintenance_systems' => 'array',
        'maintenance_tasks' => 'array',
        'maintenance_stories' => 'array',
        'maintenance_service_reset' => 'array',
        'repair_time_infos' => 'array',
        'technical_drawings' => 'array',
        'wiring_diagrams' => 'array',
        'fuse_locations' => 'array',
        'technical_bulletins' => 'array',
        'recalls' => 'array',
        'management_systems' => 'array',
        'story_overview' => 'array',
        'warning_lights' => 'array',
        'engine_location' => 'array',
        'lubricants' => 'array',
        'pids' => 'array',
        'test_procedures' => 'array',
        'structure' => 'array',
        'maintenance_forms' => 'array',
        'maintenance_system_overview' => 'array',
        'maintenance_intervals' => 'array',
        'timing_belt_maintenance' => 'array',
        'timing_belt_intervals' => 'array',
        'wear_parts_intervals' => 'array',
        'available_subjects' => 'array',
        'last_comprehensive_fetch' => 'datetime',
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
                'vehicle_identification_data' => null,
                'adjustments' => null,
                'maintenance_systems' => null,
                'maintenance_tasks' => null,
                'maintenance_stories' => null,
                'maintenance_service_reset' => null,
                'repair_time_infos' => null,
                'technical_drawings' => null,
                'wiring_diagrams' => null,
                'fuse_locations' => null,
                'technical_bulletins' => null,
                'recalls' => null,
                'management_systems' => null,
                'story_overview' => null,
                'warning_lights' => null,
                'engine_location' => null,
                'lubricants' => null,
                'pids' => null,
                'test_procedures' => null,
                'structure' => null,
                'maintenance_forms' => null,
                'maintenance_system_overview' => null,
                'maintenance_intervals' => null,
                'timing_belt_maintenance' => null,
                'timing_belt_intervals' => null,
                'wear_parts_intervals' => null,
                'available_subjects' => null,
                'last_comprehensive_fetch' => null,
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

    /**
     * Check if comprehensive data needs to be fetched (either never fetched or older than 24 hours).
     */
    public function needsComprehensiveFetch(): bool
    {
        return $this->last_comprehensive_fetch === null || 
               $this->last_comprehensive_fetch->lt(Carbon::now()->subHours(24));
    }

    /**
     * Mark that comprehensive data has been fetched.
     */
    public function markComprehensiveFetchComplete(): void
    {
        $this->update(['last_comprehensive_fetch' => now()]);
    }

    /**
     * Get all diagnostic data as a formatted string for AI consumption.
     */
    public function getFormattedDataForAI(): string
    {
        $sections = [];

        // Vehicle identification
        if ($this->vehicle_identification_data) {
            $sections[] = "VEHICLE IDENTIFICATION:\n" . $this->formatArrayForAI($this->vehicle_identification_data);
        }

        // Warning lights and DTCs
        if ($this->warning_lights) {
            $sections[] = "WARNING LIGHTS:\n" . $this->formatArrayForAI($this->warning_lights);
        }

        // Technical bulletins and recalls
        if ($this->technical_bulletins) {
            $sections[] = "TECHNICAL SERVICE BULLETINS:\n" . $this->formatArrayForAI($this->technical_bulletins);
        }

        if ($this->recalls) {
            $sections[] = "RECALLS:\n" . $this->formatArrayForAI($this->recalls);
        }

        // Maintenance information
        if ($this->maintenance_systems) {
            $sections[] = "MAINTENANCE SYSTEMS:\n" . $this->formatArrayForAI($this->maintenance_systems);
        }

        if ($this->maintenance_intervals) {
            $sections[] = "MAINTENANCE INTERVALS:\n" . $this->formatArrayForAI($this->maintenance_intervals);
        }

        // Engine and component locations
        if ($this->engine_location) {
            $sections[] = "ENGINE LOCATION:\n" . $this->formatArrayForAI($this->engine_location);
        }

        if ($this->fuse_locations) {
            $sections[] = "FUSE LOCATIONS:\n" . $this->formatArrayForAI($this->fuse_locations);
        }

        // Diagnostic procedures
        if ($this->test_procedures) {
            $sections[] = "TEST PROCEDURES:\n" . $this->formatArrayForAI($this->test_procedures);
        }

        if ($this->pids) {
            $sections[] = "DIAGNOSTIC PIDS:\n" . $this->formatArrayForAI($this->pids);
        }

        // Lubricants and specifications
        if ($this->lubricants) {
            $sections[] = "LUBRICANTS & SPECIFICATIONS:\n" . $this->formatArrayForAI($this->lubricants);
        }

        // Timing belt and wear parts
        if ($this->timing_belt_intervals) {
            $sections[] = "TIMING BELT INTERVALS:\n" . $this->formatArrayForAI($this->timing_belt_intervals);
        }

        if ($this->wear_parts_intervals) {
            $sections[] = "WEAR PARTS INTERVALS:\n" . $this->formatArrayForAI($this->wear_parts_intervals);
        }

        // Available subjects/systems
        if ($this->available_subjects) {
            $sections[] = "AVAILABLE SYSTEMS: " . implode(', ', $this->available_subjects);
        }

        return implode("\n\n", $sections);
    }

    /**
     * Format array data for AI consumption.
     */
    private function formatArrayForAI(array $data): string
    {
        if (empty($data)) {
            return "No data available";
        }

        $formatted = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (isset($value['name']) || isset($value['description'])) {
                    $name = $value['name'] ?? $value['description'] ?? 'Item';
                    $desc = $value['description'] ?? $value['details'] ?? '';
                    $formatted[] = "- {$name}" . ($desc ? ": {$desc}" : "");
                } else {
                    $formatted[] = "- " . json_encode($value);
                }
            } else {
                $formatted[] = "- {$key}: {$value}";
            }
        }
        
        return implode("\n", array_slice($formatted, 0, 20)); // Limit to 20 items to avoid overwhelming the AI
    }

    /**
     * Update multiple data fields at once.
     */
    public function updateMultipleData(array $dataFields): void
    {
        $updateData = [];
        foreach ($dataFields as $field => $data) {
            $updateData[$field] = $data;
        }
        $updateData['updated_at'] = now();
        
        $this->update($updateData);
    }
}
