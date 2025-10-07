@php
    $displayName = $storyName ?? $storyMetadata['name'] ?? 'Maintenance Story';
    $title = $displayName . ' - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
@endphp

<x-layouts.app :title="$title" :vehicle="$vehicle">
    <div class="max-w-5xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 dark:hover:text-zinc-100">Dashboard</a>
                <flux:icon.chevron-right class="w-4 h-4" />
                <a href="{{ route('vehicle-details', $vehicle->registration) }}" class="hover:text-zinc-900 dark:hover:text-zinc-100">{{ $vehicle->registration }}</a>
                <flux:icon.chevron-right class="w-4 h-4" />
                <a href="{{ route('maintenance.procedures', $vehicle->registration) }}" class="hover:text-zinc-900 dark:hover:text-zinc-100">Procedures</a>
                <flux:icon.chevron-right class="w-4 h-4" />
                <span class="text-zinc-900 dark:text-zinc-100">{{ $displayName }}</span>
            </nav>
            
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $displayName }}</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-2">
                Step-by-step procedure for {{ $vehicle->registration }}
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
            @php
                // Enhanced parsing function to extract all content including text, images, and specs
                function parseStoryLines($lines, $level = 0) {
                    $parsed = [];
                    
                    if (!is_array($lines)) {
                        return $parsed;
                    }
                    
                    foreach ($lines as $line) {
                        if (!is_array($line)) continue;
                        
                        // Helper function to safely extract string value
                        $getString = function($value) {
                            if (is_string($value)) {
                                return trim($value);
                            } elseif (is_array($value)) {
                                // If it's an array, try to extract a string or join values
                                if (isset($value[0]) && is_string($value[0])) {
                                    return trim($value[0]);
                                }
                                return '';
                            }
                            return '';
                        };
                        
                        $item = [
                            'id' => $line['id'] ?? null,
                            'name' => $getString($line['name'] ?? ''),
                            'text' => $getString($line['text'] ?? ''),
                            'remark' => $getString($line['remark'] ?? ''),
                            'paragraphContent' => $getString($line['paragraphContent'] ?? ''),
                            'order' => $line['order'] ?? 0,
                            'level' => $level,
                            'image' => null,
                            'sentenceStyle' => $line['sentenceStyle'] ?? null,
                            'sentenceGroupType' => $line['sentenceGroupType'] ?? null,
                            'isGroup' => is_null($line['id'] ?? null), // Groups have null id
                            'children' => []
                        ];
                        
                        // Extract image URL from mimeData
                        if (isset($line['mimeData']) && is_array($line['mimeData'])) {
                            $item['image'] = $line['mimeData']['mimeDataName'] ?? null;
                        } elseif (isset($line['mimeData']) && is_string($line['mimeData']) && !empty($line['mimeData'])) {
                            $item['image'] = $line['mimeData'];
                        }
                        
                        // Parse sub-story lines recursively
                        if (isset($line['subStoryLines']) && is_array($line['subStoryLines'])) {
                            $item['children'] = parseStoryLines($line['subStoryLines'], $level + 1);
                        }
                        
                        $parsed[] = $item;
                    }
                    
                    // Sort by order
                    usort($parsed, function($a, $b) {
                        return $a['order'] - $b['order'];
                    });
                    
                    return $parsed;
                }
                
                $storyLines = [];
                if (isset($storyData['storyLines']) && is_array($storyData['storyLines'])) {
                    $storyLines = parseStoryLines($storyData['storyLines']);
                }
            @endphp

            <flux:card>
                <div class="p-6">
                    @if(!empty($storyLines))
                        <div class="space-y-6">
                            @foreach($storyLines as $index => $line)
                                @include('maintenance.partials.story-line', ['line' => $line, 'index' => $index])
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <flux:icon.exclamation-triangle class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">Content Not Available</h3>
                            <p class="text-zinc-600 dark:text-zinc-400">
                                The procedure content could not be loaded.
                            </p>
                        </div>
                    @endif
                </div>
            </flux:card>

            <!-- Image Modal -->
            <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
                <div class="relative max-w-7xl w-full bg-white dark:bg-zinc-100 rounded-lg shadow-2xl p-6" onclick="event.stopPropagation()">
                    <button 
                        onclick="closeImageModal()"
                        class="absolute top-4 right-4 bg-zinc-200 hover:bg-zinc-300 text-zinc-900 p-2 rounded-lg transition-colors z-10"
                        title="Close (Esc)"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    
                    <div class="flex items-center justify-center">
                        <img 
                            id="modalImage" 
                            src="" 
                            alt="Technical diagram"
                            class="max-w-full max-h-[80vh] object-contain"
                        />
                    </div>
                    
                    <div class="text-center mt-4">
                        <p id="modalCaption" class="text-zinc-900 dark:text-zinc-800 text-lg font-medium"></p>
                    </div>
                </div>
            </div>

        @else
            <flux:card>
                <div class="p-8 text-center">
                    <flux:icon.exclamation-triangle class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">Story Not Found</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        The requested maintenance story could not be loaded.
                    </p>
                </div>
            </flux:card>
        @endif
    </div>

    @push('scripts')
    <script>
        function openImageModal(imageUrl, caption) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('modalCaption').textContent = caption || '';
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('imageModal');
            if (!modal.classList.contains('hidden')) {
                if (e.key === 'Escape') {
                    closeImageModal();
                }
            }
        });
    </script>
    @endpush
</x-layouts.app>
