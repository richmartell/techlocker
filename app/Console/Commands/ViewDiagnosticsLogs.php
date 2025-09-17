<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DiagnosticsAiLog;

class ViewDiagnosticsLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnostics:logs
                            {--vehicle= : Filter by vehicle registration}
                            {--session= : Filter by session ID}
                            {--status= : Filter by status (success, error, fallback)}
                            {--recent : Show only recent logs (last 24 hours)}
                            {--stats : Show performance statistics}
                            {--errors : Show only error logs}
                            {--limit=10 : Number of logs to display}
                            {--export= : Export logs to CSV file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View and analyze Diagnostics AI interaction logs for debugging';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('stats')) {
            $this->showStatistics();
            return;
        }

        if ($this->option('export')) {
            $this->exportLogs();
            return;
        }

        $this->showLogs();
    }

    /**
     * Display the logs based on filters.
     */
    private function showLogs()
    {
        $query = DiagnosticsAiLog::query()->orderBy('created_at', 'desc');

        // Apply filters
        if ($vehicle = $this->option('vehicle')) {
            $query->forVehicle($vehicle);
        }

        if ($session = $this->option('session')) {
            $query->where('session_id', $session);
        }

        if ($status = $this->option('status')) {
            $query->where('status', $status);
        }

        if ($this->option('recent')) {
            $query->recent();
        }

        if ($this->option('errors')) {
            $query->withErrors();
        }

        $limit = (int) $this->option('limit');
        $logs = $query->limit($limit)->get();

        if ($logs->isEmpty()) {
            $this->info('No logs found matching the criteria.');
            return;
        }

        $this->info("Showing {$logs->count()} diagnostic AI interactions:");
        $this->line('');

        foreach ($logs as $log) {
            $this->displayLog($log);
            $this->line('');
        }
    }

    /**
     * Display a single log entry.
     */
    private function displayLog(DiagnosticsAiLog $log)
    {
        // Header with basic info
        $statusColor = match($log->status) {
            'success' => 'green',
            'error' => 'red',
            'fallback' => 'yellow',
            default => 'white'
        };

        $this->line("<fg={$statusColor}>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</>");
        
        $header = sprintf(
            "<fg={$statusColor}>[%s]</> %s | %s | Session: %s",
            strtoupper($log->status),
            $log->created_at->format('Y-m-d H:i:s'),
            $log->vehicle_registration,
            substr($log->session_id ?? 'unknown', 0, 8)
        );
        $this->line($header);

        // Vehicle information
        if ($log->vehicle_data) {
            $vehicle = $log->vehicle_data;
            $this->line("Vehicle: {$vehicle['year']} {$vehicle['make']} {$vehicle['model']} ({$vehicle['engine']})");
        }

        // Haynes Pro information
        if ($log->haynes_data_available) {
            $sectionsCount = count($log->haynes_data_sections ?? []);
            $this->line("<fg=cyan>Haynes Pro:</> Car Type ID {$log->haynes_car_type_id} | {$sectionsCount} data sections");
        } else {
            $this->line("<fg=yellow>Haynes Pro:</> No data available");
        }

        // AI model and performance
        if ($log->ai_model) {
            $performance = sprintf(
                "Model: %s | Response: %dms | Tokens: %d | Temp: %.1f",
                $log->ai_model,
                $log->response_time_ms ?? 0,
                $log->max_tokens ?? 0,
                $log->temperature ?? 0
            );
            $this->line($performance);
        }

        // User message
        $this->line('');
        $this->line('<fg=blue>User:</> ' . $this->truncateText($log->user_message, 100));

        // AI response
        $this->line('<fg=green>AI:</> ' . $this->truncateText($log->ai_response, 200));

        // Error information if present
        if ($log->error_message) {
            $this->line("<fg=red>Error:</> {$log->error_message}");
        }

        if ($log->fallback_reason) {
            $this->line("<fg=yellow>Fallback Reason:</> {$log->fallback_reason}");
        }
    }

    /**
     * Show performance statistics.
     */
    private function showStatistics()
    {
        $metrics = DiagnosticsAiLog::getPerformanceMetrics();

        $this->info('Diagnostics AI Performance Statistics');
        $this->line('');

        $headers = ['Metric', 'Value'];
        $rows = [
            ['Total Interactions', number_format($metrics['total_interactions'])],
            ['Average Response Time', round($metrics['average_response_time'], 2) . 'ms'],
            ['Min Response Time', $metrics['min_response_time'] . 'ms'],
            ['Max Response Time', $metrics['max_response_time'] . 'ms'],
            ['Success Rate', round($metrics['success_rate'], 2) . '%'],
            ['Error Rate', round($metrics['error_rate'], 2) . '%'],
            ['Fallback Rate', round($metrics['fallback_rate'], 2) . '%'],
            ['Haynes Data Usage', round($metrics['haynes_data_usage'], 2) . '%'],
        ];

        $this->table($headers, $rows);

        // Recent activity
        $recentCount = DiagnosticsAiLog::recent()->count();
        $this->line('');
        $this->info("Recent Activity (24h): {$recentCount} interactions");

        // Top error reasons
        $errors = DiagnosticsAiLog::withErrors()
            ->selectRaw('error_message, COUNT(*) as count')
            ->groupBy('error_message')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        if ($errors->isNotEmpty()) {
            $this->line('');
            $this->warn('Top Error Messages:');
            foreach ($errors as $error) {
                $this->line("• {$error->error_message} ({$error->count}x)");
            }
        }

        // Top vehicles
        $topVehicles = DiagnosticsAiLog::selectRaw('vehicle_registration, COUNT(*) as count')
            ->groupBy('vehicle_registration')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        if ($topVehicles->isNotEmpty()) {
            $this->line('');
            $this->info('Most Active Vehicles:');
            foreach ($topVehicles as $vehicle) {
                $this->line("• {$vehicle->vehicle_registration} ({$vehicle->count} interactions)");
            }
        }
    }

    /**
     * Export logs to CSV.
     */
    private function exportLogs()
    {
        $filename = $this->option('export');
        $query = DiagnosticsAiLog::query()->orderBy('created_at', 'desc');

        // Apply same filters as showLogs
        if ($vehicle = $this->option('vehicle')) {
            $query->forVehicle($vehicle);
        }
        if ($session = $this->option('session')) {
            $query->where('session_id', $session);
        }
        if ($status = $this->option('status')) {
            $query->where('status', $status);
        }
        if ($this->option('recent')) {
            $query->recent();
        }
        if ($this->option('errors')) {
            $query->withErrors();
        }

        $logs = $query->get();

        if ($logs->isEmpty()) {
            $this->error('No logs found to export.');
            return;
        }

        $file = fopen($filename, 'w');
        
        // Write CSV header
        fputcsv($file, [
            'Created At',
            'Status',
            'Vehicle Registration',
            'Session ID',
            'User Message',
            'AI Response',
            'Haynes Car Type ID',
            'Haynes Data Available',
            'AI Model',
            'Response Time (ms)',
            'Error Message',
            'Fallback Reason'
        ]);

        // Write data
        foreach ($logs as $log) {
            fputcsv($file, [
                $log->created_at->format('Y-m-d H:i:s'),
                $log->status,
                $log->vehicle_registration,
                $log->session_id,
                $log->user_message,
                $log->ai_response,
                $log->haynes_car_type_id,
                $log->haynes_data_available ? 'Yes' : 'No',
                $log->ai_model,
                $log->response_time_ms,
                $log->error_message,
                $log->fallback_reason
            ]);
        }

        fclose($file);

        $this->info("Exported {$logs->count()} logs to {$filename}");
    }

    /**
     * Truncate text for display.
     */
    private function truncateText(?string $text, int $length): string
    {
        if (!$text) {
            return 'N/A';
        }

        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length) . '...';
    }
}