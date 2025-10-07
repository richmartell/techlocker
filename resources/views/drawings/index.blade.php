@php
    $title = 'Technical Drawings - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
@endphp

<x-layouts.app :title="$title" :vehicle="$vehicle" :vehicleImage="$vehicleImage ?? null">
    <div class="max-w-5xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <flux:icon.document-chart-bar class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Technical Drawings</h1>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">
                Technical diagrams and exploded views for {{ $vehicle->make?->name ?? 'Unknown' }} {{ $vehicle->model?->name ?? 'Unknown' }} ({{ $vehicle->registration }})
            </p>
            
            @if($totalDrawings > 0)
                <div class="mt-4">
                    <flux:badge variant="outline" size="sm">
                        {{ $totalDrawings }} drawings available
                    </flux:badge>
                </div>
            @endif
        </div>

        @if(!empty($groupedDrawings))
            <!-- Hierarchical Drawings List -->
            <div class="space-y-6">
                @foreach($groupedDrawings as $systemGroup => $systemData)
                    <flux:card>
                        <div class="p-6">
                            <!-- Category Header -->
                            <div class="flex items-center gap-3 mb-4 pb-3 border-b border-zinc-200 dark:border-zinc-700">
                                @if(str_contains(strtolower($systemGroup), 'brake'))
                                    <flux:icon.cog-8-tooth class="w-6 h-6 text-red-500" />
                                @elseif(str_contains(strtolower($systemGroup), 'transmission'))
                                    <flux:icon.cog class="w-6 h-6 text-green-500" />
                                @elseif(str_contains(strtolower($systemGroup), 'suspension'))
                                    <flux:icon.wrench-screwdriver class="w-6 h-6 text-purple-500" />
                                @elseif(str_contains(strtolower($systemGroup), 'steering'))
                                    <flux:icon.wrench-screwdriver class="w-6 h-6 text-purple-500" />
                                @elseif(str_contains(strtolower($systemGroup), 'body'))
                                    <flux:icon.home class="w-6 h-6 text-orange-500" />
                                @else
                                    <flux:icon.document-chart-bar class="w-6 h-6 text-zinc-500" />
                                @endif
                                <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
                                    {{ $systemData['name'] }}
                                </h2>
                                <flux:badge variant="outline" size="sm">
                                    {{ count($systemData['drawings']) }} drawing{{ count($systemData['drawings']) !== 1 ? 's' : '' }}
                                </flux:badge>
                            </div>

                            <!-- Drawings List -->
                            <div class="space-y-2">
                                @foreach($systemData['drawings'] as $drawing)
                                    <div class="flex items-center justify-between py-2 px-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-lg transition-colors group cursor-pointer"
                                         onclick="openDrawingModal({{ json_encode($drawing) }})">
                                        <div class="flex items-center gap-3 flex-1">
                                            <flux:icon.document class="w-4 h-4 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-300" />
                                            <div class="flex-1">
                                                <h3 class="font-medium text-zinc-900 dark:text-zinc-100 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                                    {{ $drawing['description'] ?? 'Technical Drawing' }}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <flux:icon.arrow-top-right-on-square class="w-4 h-4 text-zinc-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </flux:card>
                @endforeach
            </div>

        @else
            <!-- No Drawings Available -->
            <flux:card>
                <div class="p-8 text-center">
                    <flux:icon.document-chart-bar class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Technical Drawings Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-4">
                        No technical drawings found for this vehicle. This could be due to:
                    </p>
                    <ul class="text-sm text-zinc-600 dark:text-zinc-400 space-y-1 max-w-md mx-auto text-left">
                        <li>• Vehicle identification not complete</li>
                        <li>• Data not available in HaynesPro database</li>
                        <li>• Technical drawings may be available in other sections</li>
                    </ul>
                    
                    <div class="mt-6">
                        <flux:button 
                            variant="outline" 
                            href="{{ route('vehicle-details', $vehicle->registration) }}"
                            wire:navigate
                        >
                            <flux:icon.arrow-left class="w-4 h-4 mr-2" />
                            Back to Vehicle Overview
                        </flux:button>
                    </div>
                </div>
            </flux:card>
        @endif

    </div>

    <!-- Drawing Modal -->
    <div id="drawingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex-1">
                    <h3 id="modalTitle" class="text-lg font-semibold text-zinc-900 dark:text-zinc-100"></h3>
                    <p id="modalDescription" class="text-sm text-zinc-600 dark:text-zinc-400 mt-1"></p>
                </div>
                <flux:button 
                    variant="ghost" 
                    size="sm"
                    onclick="closeDrawingModal()"
                >
                    <flux:icon.x-mark class="w-5 h-5" />
                </flux:button>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                <!-- Drawing Image -->
                <div id="modalImageContainer" class="mb-6 bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                    <!-- Image will be populated by JavaScript -->
                </div>

                <!-- Drawing Details -->
                <div id="modalDetails" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <!-- Details will be populated by JavaScript -->
                </div>

                <!-- Raw Data Toggle -->
                <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button 
                        variant="ghost" 
                        size="sm"
                        onclick="toggleModalRawData()"
                        id="toggleModalRawBtn"
                    >
                        <flux:icon.code-bracket class="w-4 h-4 mr-2" />
                        Show Raw Data
                    </flux:button>
                    
                    <div id="modalRawData" class="hidden mt-3">
                        <div class="bg-zinc-900 dark:bg-zinc-950 rounded-lg overflow-hidden">
                            <div class="bg-zinc-800 dark:bg-zinc-900 px-3 py-2 border-b border-zinc-700">
                                <span class="text-xs font-medium text-zinc-300">Raw API Data</span>
                            </div>
                            <pre id="modalRawDataContent" class="p-3 text-xs text-zinc-100 overflow-x-auto max-h-48 overflow-y-auto"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentDrawingData = null;

        function openDrawingModal(drawing) {
            currentDrawingData = drawing;
            
            // Update modal content
            document.getElementById('modalTitle').textContent = drawing.description || 'Technical Drawing';
            document.getElementById('modalDescription').textContent = '';
            
            // Update image
            const imageContainer = document.getElementById('modalImageContainer');
            if (drawing.mimeDataName) {
                imageContainer.innerHTML = `
                    <div class="relative">
                        <img 
                            src="${drawing.mimeDataName}" 
                            alt="${drawing.description || 'Technical Drawing'}"
                            class="w-full h-auto max-h-96 object-contain bg-white"
                            onload="this.style.opacity='1'"
                            onerror="this.parentElement.innerHTML='<div class=\\'p-8 text-center\\'>Failed to load drawing image</div>'"
                            style="opacity:0; transition: opacity 0.3s;"
                        />
                        <div class="absolute top-2 right-2">
                            <button 
                                onclick="window.open('${drawing.mimeDataName}', '_blank')"
                                class="bg-black bg-opacity-50 text-white p-2 rounded-lg hover:bg-opacity-70 transition-colors"
                                title="Open in new tab"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
            } else {
                imageContainer.innerHTML = `
                    <div class="p-8 text-center">
                        <svg class="w-16 h-16 text-zinc-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-zinc-600 dark:text-zinc-400">No image available for this drawing</p>
                    </div>
                `;
            }
            
            // Update details (currently empty, reserved for future use)
            const detailsContainer = document.getElementById('modalDetails');
            detailsContainer.innerHTML = '';
            
            // Update raw data
            document.getElementById('modalRawDataContent').textContent = JSON.stringify(drawing, null, 2);
            
            // Show modal
            document.getElementById('drawingModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawingModal() {
            document.getElementById('drawingModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Reset raw data toggle
            const rawDataDiv = document.getElementById('modalRawData');
            const toggleBtn = document.getElementById('toggleModalRawBtn');
            rawDataDiv.classList.add('hidden');
            toggleBtn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>Show Raw Data';
        }

        function toggleModalRawData() {
            const rawDataDiv = document.getElementById('modalRawData');
            const toggleBtn = document.getElementById('toggleModalRawBtn');
            
            if (rawDataDiv.classList.contains('hidden')) {
                rawDataDiv.classList.remove('hidden');
                toggleBtn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>Hide Raw Data';
            } else {
                rawDataDiv.classList.add('hidden');
                toggleBtn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>Show Raw Data';
            }
        }

        // Close modal when clicking outside
        document.getElementById('drawingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDrawingModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDrawingModal();
            }
        });
    </script>
    @endpush
</x-layouts.app>