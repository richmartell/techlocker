<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosticsAiLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_message',
        'ai_response',
        'session_id',
        'vehicle_registration',
        'haynes_car_type_id',
        'vehicle_data',
        'haynes_data_available',
        'haynes_data_sections',
        'haynes_last_fetch',
        'ai_model',
        'system_message_length',
        'user_message_length',
        'ai_response_length',
        'response_time_ms',
        'temperature',
        'max_tokens',
        'status',
        'error_message',
        'fallback_reason',
        'ip_address',
        'user_agent',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'vehicle_data' => 'array',
        'haynes_data_sections' => 'array',
        'haynes_data_available' => 'boolean',
        'haynes_last_fetch' => 'datetime',
        'system_message_length' => 'integer',
        'user_message_length' => 'integer',
        'ai_response_length' => 'integer',
        'response_time_ms' => 'integer',
        'temperature' => 'float',
        'max_tokens' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Create a new log entry for a diagnostics AI interaction.
     */
    public static function logInteraction(array $data): self
    {
        // Calculate lengths
        $data['user_message_length'] = strlen($data['user_message'] ?? '');
        $data['ai_response_length'] = strlen($data['ai_response'] ?? '');
        $data['system_message_length'] = strlen($data['system_message'] ?? '');

        // Remove system_message from stored data (it can be very long)
        unset($data['system_message']);

        return static::create($data);
    }

    /**
     * Scope to get logs for a specific vehicle.
     */
    public function scopeForVehicle($query, string $registration)
    {
        return $query->where('vehicle_registration', $registration);
    }

    /**
     * Scope to get logs with Haynes Pro data.
     */
    public function scopeWithHaynesData($query)
    {
        return $query->where('haynes_data_available', true);
    }

    /**
     * Scope to get logs with errors.
     */
    public function scopeWithErrors($query)
    {
        return $query->where('status', 'error');
    }

    /**
     * Scope to get logs that used fallback responses.
     */
    public function scopeFallback($query)
    {
        return $query->where('status', 'fallback');
    }

    /**
     * Scope to get recent logs (last 24 hours).
     */
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDay());
    }

    /**
     * Get the average response time for a vehicle.
     */
    public static function averageResponseTimeForVehicle(string $registration): ?float
    {
        return static::forVehicle($registration)
            ->whereNotNull('response_time_ms')
            ->avg('response_time_ms');
    }

    /**
     * Get conversation history for a session.
     */
    public static function getConversationHistory(string $sessionId): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('session_id', $sessionId)
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Get most common user queries.
     */
    public static function getCommonQueries(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return static::selectRaw('user_message, COUNT(*) as count')
            ->groupBy('user_message')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();
    }

    /**
     * Get performance metrics.
     */
    public static function getPerformanceMetrics(): array
    {
        $logs = static::whereNotNull('response_time_ms');
        
        return [
            'total_interactions' => static::count(),
            'average_response_time' => $logs->avg('response_time_ms'),
            'min_response_time' => $logs->min('response_time_ms'),
            'max_response_time' => $logs->max('response_time_ms'),
            'success_rate' => static::where('status', 'success')->count() / static::count() * 100,
            'error_rate' => static::where('status', 'error')->count() / static::count() * 100,
            'fallback_rate' => static::where('status', 'fallback')->count() / static::count() * 100,
            'haynes_data_usage' => static::where('haynes_data_available', true)->count() / static::count() * 100,
        ];
    }

    /**
     * Clean up old logs (older than specified days).
     */
    public static function cleanup(int $daysToKeep = 90): int
    {
        return static::where('created_at', '<', now()->subDays($daysToKeep))->delete();
    }
}