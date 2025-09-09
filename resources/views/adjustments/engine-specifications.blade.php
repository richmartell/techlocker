@php
    $title = 'Engine (Specifications) Adjustments - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
@endphp

<x-layouts.app :title="$title" :vehicle="$vehicle" :vehicleImage="$vehicleImage ?? null">
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                <a href="{{ route('vehicle-details', $vehicle->registration) }}" 
                   class="hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors"
                   wire:navigate>
                    {{ $vehicle->registration }}
                </a>
                <flux:icon.chevron-right class="w-4 h-4" />
                <span class="text-zinc-500">Adjustments</span>
                <flux:icon.chevron-right class="w-4 h-4" />
                <span class="text-zinc-900 dark:text-zinc-100">Engine (Specifications)</span>
            </nav>

            <div class="flex items-center gap-3 mb-2">
                <flux:icon.cog-8-tooth class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Engine (Specifications) Adjustments</h1>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">
                Detailed engine specifications and technical diagrams for {{ $vehicle->make?->name ?? 'Unknown' }} {{ $vehicle->model?->name ?? 'Unknown' }} ({{ $vehicle->registration }})
            </p>
        </div>

        @if($error)
            <!-- Error Message -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                    <div>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            <strong>Error loading engine specifications:</strong> {{ $error }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Engine Specifications Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Engine Specifications</h2>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                    @if(!empty($engineSpecifications))
                        Live technical data and diagrams from HaynesPro API
                    @else
                        Engine specifications and technical diagrams
                    @endif
                </p>
            </div>
            
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @if(!empty($engineSpecifications))
                    @foreach($engineSpecifications as $specification)
                        <!-- Specification Row -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Specification Details -->
                                <div class="lg:col-span-2">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">
                                                {{ $specification['name'] }}
                                                @if($specification['remark'])
                                                    <span class="text-sm text-zinc-500 font-normal">({{ $specification['remark'] }})</span>
                                                @endif
                                            </h3>
                                            
                                            @if($specification['value'])
                                                <div class="flex items-center gap-2 text-base">
                                                    <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $specification['value'] }}</span>
                                                    @if($specification['unit'])
                                                        <span class="text-zinc-500">{{ $specification['unit'] }}</span>
                                                    @endif
                                                </div>
                                            @endif

                                            <!-- Handle nested specifications (like Valve clearance -> Hydraulic) -->
                                            @if(isset($specification['subAdjustments']) && !empty($specification['subAdjustments']))
                                                <div class="mt-3 pl-4 border-l-2 border-zinc-200 dark:border-zinc-700">
                                                    @foreach($specification['subAdjustments'] as $subSpec)
                                                        <div class="py-1">
                                                            <div class="flex items-center gap-2">
                                                                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $subSpec['name'] }}:</span>
                                                                <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                                                    {{ $subSpec['value'] ?: 'See technical manual' }}
                                                                    @if($subSpec['unit'])
                                                                        {{ $subSpec['unit'] }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Display -->
                                @if($specification['imageName'])
                                    <div class="lg:col-span-1">
                                        <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg p-4 border border-zinc-200 dark:border-zinc-700">
                                            <div class="aspect-square flex items-center justify-center">
                                                <img 
                                                    src="{{ $specification['imageName'] }}" 
                                                    alt="{{ $specification['name'] }}" 
                                                    class="max-w-full max-h-full object-contain rounded cursor-pointer hover:scale-105 transition-transform"
                                                    onclick="openImageModal('{{ addslashes($specification['imageName']) }}', '{{ addslashes($specification['name']) }}')"
                                                >
                                            </div>
                                            <p class="text-xs text-center text-zinc-500 mt-2">
                                                <flux:icon.magnifying-glass-plus class="w-3 h-3 inline mr-1" />
                                                Click to enlarge image
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback if no data -->
                    <div class="p-6 text-center">
                        <flux:icon.exclamation-triangle class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Specifications Available</h3>
                        <p class="text-zinc-600 dark:text-zinc-400">
                            Engine specifications could not be loaded from the HaynesPro API.
                        </p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
        <div class="relative max-w-4xl max-h-full">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain">
            <button 
                onclick="closeImageModal()" 
                class="absolute top-4 right-4 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full p-2 transition-colors"
                aria-label="Close modal"
            >
                <flux:icon.x-mark class="w-6 h-6 text-white" />
            </button>
            <div id="modalCaption" class="absolute bottom-4 left-4 right-4 text-white text-center bg-black bg-opacity-50 rounded px-4 py-2"></div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openImageModal(imageSrc, caption) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalCaption = document.getElementById('modalCaption');
            
            modalImage.src = imageSrc;
            modalImage.alt = caption;
            modalCaption.textContent = caption;
            modal.classList.remove('hidden');
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            
            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
    @endpush
</x-layouts.app>
