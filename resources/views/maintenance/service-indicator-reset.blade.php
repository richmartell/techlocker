@php
    $title = 'Service Indicator Reset - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
@endphp

<x-layouts.app :title="$title" :vehicle="$vehicle">
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 dark:hover:text-zinc-100">Dashboard</a>
                <flux:icon.chevron-right class="w-4 h-4" />
                <a href="{{ route('vehicle-details', $vehicle->registration) }}" class="hover:text-zinc-900 dark:hover:text-zinc-100">{{ $vehicle->registration }}</a>
                <flux:icon.chevron-right class="w-4 h-4" />
                <span class="text-zinc-900 dark:text-zinc-100">Service Indicator Reset</span>
            </nav>
            
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Service Indicator Reset</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-2">
                Reset procedures for service indicator light for {{ $vehicle->registration }}
            </p>
        </div>

        @if($error)
            <!-- Error Message -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                    <div>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            <strong>Error loading service indicator reset data:</strong> {{ $error }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($serviceResetData))
            <!-- Service Indicator Reset Procedures -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Service Indicator Reset</h2>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                        Step-by-step procedure to reset the service indicator
                    </p>
                </div>
                
                <div class="p-6">
                    @php
                        $steps = [];
                        
                        // Debug: Let's see what we actually have
                        $debugInfo = [
                            'data_type' => gettype($serviceResetData),
                            'data_keys' => is_array($serviceResetData) ? array_keys($serviceResetData) : 'not array'
                        ];
                        
                        // Handle story-based data structure
                        if (isset($serviceResetData['storyInfo']['storyLines']) && is_array($serviceResetData['storyInfo']['storyLines'])) {
                            $storyLines = $serviceResetData['storyInfo']['storyLines'];
                            $debugInfo['storyLines_count'] = count($storyLines);
                            
                            // Look for subStoryLines in the first storyLine (which contains the actual steps)
                            if (!empty($storyLines) && isset($storyLines[0]['subStoryLines']) && is_array($storyLines[0]['subStoryLines'])) {
                                $subStoryLines = $storyLines[0]['subStoryLines'];
                                $debugInfo['subStoryLines_count'] = count($subStoryLines);
                                
                                // Sort by order to ensure correct sequence
                                usort($subStoryLines, function($a, $b) {
                                    return ($a['order'] ?? 0) - ($b['order'] ?? 0);
                                });
                                
                                foreach ($subStoryLines as $line) {
                                    $stepText = trim($line['name'] ?? '');
                                    
                                    // Skip empty steps
                                    if (!empty($stepText) && strlen($stepText) > 1) {
                                        $steps[] = $stepText;
                                    }
                                }
                            }
                        }
                        
                        // Fallback: try to extract from any text content we can find
                        if (empty($steps) && is_array($serviceResetData)) {
                            $allText = '';
                            
                            // Recursively extract all text from the data structure
                            function extractText($data, &$text) {
                                if (is_array($data)) {
                                    foreach ($data as $key => $value) {
                                        if ($key === 'text' && is_string($value)) {
                                            $text .= $value . "\n";
                                        } elseif (is_array($value)) {
                                            extractText($value, $text);
                                        }
                                    }
                                }
                            }
                            
                            extractText($serviceResetData, $allText);
                            
                            if (!empty($allText)) {
                                $lines = preg_split('/[\r\n]+/', $allText);
                                foreach ($lines as $line) {
                                    $trimmed = trim($line);
                                    if (!empty($trimmed) && strlen($trimmed) > 3) {
                                        $cleaned = preg_replace('/^[-•*]\s*/', '', $trimmed);
                                        $cleaned = trim($cleaned);
                                        if (!empty($cleaned)) {
                                            $steps[] = $cleaned;
                                        }
                                    }
                                }
                            }
                        }
                        
                        // Remove duplicates and clean up
                        $steps = array_unique($steps);
                        $steps = array_filter($steps, function($step) {
                            $lower = strtolower(trim($step));
                            return !in_array($lower, [
                                'service indicator reset',
                                'procedure',
                                'steps',
                                'reset procedure',
                                'follow these steps',
                                ''
                            ]) && strlen($step) > 3;
                        });
                        
                        // Re-index array
                        $steps = array_values($steps);
                    @endphp
                    
                    @if(!empty($steps))
                        <!-- Step-by-step procedure -->
                        <div class="space-y-4">
                            @foreach($steps as $index => $step)
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 rounded-full flex items-center justify-center text-sm font-medium">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-zinc-900 dark:text-zinc-100">{{ $step }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Display debug info and raw API response -->
                        <div class="prose prose-zinc dark:prose-invert max-w-none space-y-4">
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                <h3 class="text-lg font-semibold mb-2 text-yellow-800 dark:text-yellow-200">Debug Information</h3>
                                <pre class="bg-white dark:bg-zinc-800 p-3 rounded text-sm">{{ json_encode($debugInfo, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                            
                            <div class="bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
                                <h3 class="text-lg font-semibold mb-2">Raw Story Data</h3>
                                <pre class="bg-white dark:bg-zinc-900 p-3 rounded text-xs overflow-x-auto">{{ json_encode($serviceResetData, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif

                    <!-- Important Notice -->
                    <div class="mt-6 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                        <div class="flex items-start gap-3">
                            <flux:icon.exclamation-triangle class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 flex-shrink-0" />
                            <div>
                                <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-200">Important Notes</h3>
                                <ul class="mt-2 space-y-1 text-sm text-amber-700 dark:text-amber-300">
                                    <li>• Ensure the vehicle is stationary and handbrake is applied</li>
                                    <li>• Follow the exact sequence as specified</li>
                                    <li>• If the procedure fails, consult the vehicle manual</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No Data Available -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="p-8 text-center">
                    <flux:icon.wrench-screwdriver class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Service Indicator Reset Data Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        Service indicator reset procedures are not available for this vehicle.
                    </p>
                </div>
            </div>
        @endif

        <!-- Debug Information (if available) -->
        @if(app()->environment('local') && $error)
            <div class="mt-8 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-200 mb-2">Debug Information</h3>
                <pre class="text-xs text-red-700 dark:text-red-300">{{ $error }}</pre>
            </div>
        @endif
    </div>
</x-layouts.app>
