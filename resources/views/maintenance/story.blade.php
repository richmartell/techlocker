@php
    $storyName = $storyMetadata['name'] ?? 'Maintenance Story';
    $title = $storyName . ' - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
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
                <span class="text-zinc-900 dark:text-zinc-100">{{ $storyName }}</span>
            </nav>
            
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $storyName }}</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-2">
                Maintenance procedure for {{ $vehicle->registration }}
            </p>
        </div>

        @if($error)
            <!-- Error Message -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                    <div>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            <strong>Error loading maintenance story:</strong> {{ $error }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($storyData))
            <!-- Maintenance Story Procedures -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $storyName }}</h2>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                        Step-by-step procedure
                    </p>
                </div>
                
                <div class="p-6">
                    @php
                        $contentSections = [];
                        
                        // Enhanced parsing logic to capture hierarchical content structure
                        function parseStoryContent($data, $level = 0) {
                            $sections = [];
                            
                            if (is_array($data)) {
                                foreach ($data as $key => $item) {
                                    if (is_array($item)) {
                                        // Look for section headers and content
                                        $sectionName = $item['name'] ?? $item['title'] ?? $item['text'] ?? '';
                                        $sectionText = $item['text'] ?? $item['content'] ?? $item['description'] ?? '';
                                        $order = $item['order'] ?? 0;
                                        
                                        if (!empty($sectionName)) {
                                            $section = [
                                                'type' => 'section',
                                                'name' => trim($sectionName),
                                                'text' => trim($sectionText),
                                                'order' => $order,
                                                'level' => $level,
                                                'subsections' => []
                                            ];
                                            
                                            // Look for subsections
                                            if (isset($item['subStoryLines']) && is_array($item['subStoryLines'])) {
                                                $section['subsections'] = parseStoryContent($item['subStoryLines'], $level + 1);
                                            } elseif (isset($item['children']) && is_array($item['children'])) {
                                                $section['subsections'] = parseStoryContent($item['children'], $level + 1);
                                            }
                                            
                                            $sections[] = $section;
                                        } else {
                                            // Recursively parse nested structures
                                            $nested = parseStoryContent($item, $level);
                                            $sections = array_merge($sections, $nested);
                                        }
                                    }
                                }
                            }
                            
                            // Sort by order
                            usort($sections, function($a, $b) {
                                return ($a['order'] ?? 0) - ($b['order'] ?? 0);
                            });
                            
                            return $sections;
                        }
                        
                        // Parse the main story data
                        if (isset($storyData['storyLines']) && is_array($storyData['storyLines'])) {
                            $contentSections = parseStoryContent($storyData['storyLines']);
                        }
                        
                        // Fallback: if we still don't have good content, extract all text content
                        if (empty($contentSections)) {
                            $allText = '';
                            
                            function extractAllText($data, &$text, $path = '') {
                                if (is_array($data)) {
                                    foreach ($data as $key => $value) {
                                        if (is_string($value) && !empty(trim($value))) {
                                            if (in_array($key, ['name', 'text', 'content', 'description', 'title'])) {
                                                $text .= trim($value) . "\n";
                                            }
                                        } elseif (is_array($value)) {
                                            extractAllText($value, $text, $path . '.' . $key);
                                        }
                                    }
                                }
                            }
                            
                            extractAllText($storyData, $allText);
                            
                            if (!empty($allText)) {
                                $lines = array_filter(array_map('trim', explode("\n", $allText)));
                                $lines = array_unique($lines);
                                
                                foreach ($lines as $line) {
                                    if (strlen($line) > 3) {
                                        $contentSections[] = [
                                            'type' => 'step',
                                            'name' => $line,
                                            'text' => '',
                                            'level' => 0,
                                            'subsections' => []
                                        ];
                                    }
                                }
                            }
                        }
                    @endphp
                    
                    @if(!empty($contentSections))
                        <!-- Structured procedure content -->
                        <div class="space-y-6">
                            @php $stepCounter = 0; @endphp
                            @foreach($contentSections as $section)
                                @if($section['type'] === 'section' && $section['level'] === 0)
                                    <!-- Main section -->
                                    <div class="mb-6">
                                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3">
                                            {{ $section['name'] }}
                                        </h3>
                                        
                                        @if(!empty($section['text']))
                                            <p class="text-zinc-700 dark:text-zinc-300 mb-4">{{ $section['text'] }}</p>
                                        @endif
                                        
                                        @if(!empty($section['subsections']))
                                            <div class="space-y-3">
                                                @foreach($section['subsections'] as $subsection)
                                                    @php $stepCounter++; @endphp
                                                    @if($subsection['level'] === 1)
                                                        <!-- Subsection header -->
                                                        <h4 class="font-medium text-zinc-800 dark:text-zinc-200 mt-4 mb-2">
                                                            {{ $subsection['name'] }}
                                                        </h4>
                                                        @if(!empty($subsection['text']))
                                                            <p class="text-zinc-600 dark:text-zinc-400 mb-3">{{ $subsection['text'] }}</p>
                                                        @endif
                                                        
                                                        @if(!empty($subsection['subsections']))
                                                            <div class="space-y-2 ml-4">
                                                                @foreach($subsection['subsections'] as $step)
                                                                    @php $stepCounter++; @endphp
                                                                    <div class="flex items-start gap-3">
                                                                        <div class="flex-shrink-0 w-7 h-7 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 rounded-full flex items-center justify-center text-xs font-medium">
                                                                            {{ $stepCounter }}
                                                                        </div>
                                                                        <div class="flex-1">
                                                                            <p class="text-zinc-900 dark:text-zinc-100">{{ $step['name'] }}</p>
                                                                            @if(!empty($step['text']))
                                                                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $step['text'] }}</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @else
                                                        <!-- Direct step -->
                                                        <div class="flex items-start gap-3">
                                                            <div class="flex-shrink-0 w-7 h-7 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 rounded-full flex items-center justify-center text-xs font-medium">
                                                                {{ $stepCounter }}
                                                            </div>
                                                            <div class="flex-1">
                                                                <p class="text-zinc-900 dark:text-zinc-100">{{ $subsection['name'] }}</p>
                                                                @if(!empty($subsection['text']))
                                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $subsection['text'] }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <!-- Simple step -->
                                    @php $stepCounter++; @endphp
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-7 h-7 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 rounded-full flex items-center justify-center text-xs font-medium">
                                            {{ $stepCounter }}
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-zinc-900 dark:text-zinc-100">{{ $section['name'] }}</p>
                                            @if(!empty($section['text']))
                                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $section['text'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <!-- Display debug info and raw API response -->
                        <div class="prose prose-zinc dark:prose-invert max-w-none space-y-4">
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                <h3 class="text-lg font-semibold mb-2 text-yellow-800 dark:text-yellow-200">Debug Information</h3>
                                <pre class="bg-white dark:bg-zinc-800 p-3 rounded text-sm">Story ID: {{ $storyId }}
Story Name: {{ $storyName }}
Data Type: {{ gettype($storyData) }}
Data Keys: {{ is_array($storyData) ? implode(', ', array_keys($storyData)) : 'not array' }}</pre>
                            </div>
                            
                            <div class="bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
                                <h3 class="text-lg font-semibold mb-2">Raw Story Data</h3>
                                <pre class="bg-white dark:bg-zinc-900 p-3 rounded text-xs overflow-x-auto">{{ json_encode($storyData, JSON_PRETTY_PRINT) }}</pre>
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
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Maintenance Story Data Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        Maintenance procedure data is not available for this story.
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
