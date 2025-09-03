@php
    $title = 'Electrical System Adjustments - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
@endphp

<x-layouts.app :title="$title" :vehicle="$vehicle" :vehicleImage="$vehicleImage ?? null">
    <div class="max-w-6xl mx-auto">
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
                <span class="text-zinc-900 dark:text-zinc-100">Electrical</span>
            </nav>

            <div class="flex items-center gap-3 mb-2">
                <flux:icon.cog-8-tooth class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Electrical System Adjustments</h1>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">
                Electrical system specifications and battery information for {{ $vehicle->make?->name ?? 'Unknown' }} {{ $vehicle->model?->name ?? 'Unknown' }} ({{ $vehicle->registration }})
            </p>
        </div>

        @if($error)
            <!-- Error Message -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                    <div>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            <strong>Error loading electrical data:</strong> {{ $error }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($electricalData))
            <!-- Electrical System Sections -->
            <div class="space-y-6">
                @foreach($electricalData as $section)
                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                        <!-- Section Header -->
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                {{ $section['name'] }}
                                @if($section['remark'])
                                    <span class="text-sm text-zinc-500 font-normal ml-2">({{ $section['remark'] }})</span>
                                @endif
                            </h2>
                        </div>
                        
                        <!-- Section Content -->
                        <div class="p-6">
                            @if(isset($section['subAdjustments']) && !empty($section['subAdjustments']))
                                <!-- Table for specifications -->
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                            @foreach($section['subAdjustments'] as $spec)
                                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                                    <td class="px-4 py-3 text-sm font-medium text-zinc-900 dark:text-zinc-100 w-1/2">
                                                        {{ $spec['name'] }}
                                                        @if($spec['remark'])
                                                            <div class="text-xs text-zinc-500 mt-1">{{ $spec['remark'] }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                                        <div class="flex items-start gap-4">
                                                            <div class="flex-1">
                                                                @if($spec['value'])
                                                                    <span class="font-medium">{{ $spec['value'] }}</span>
                                                                    @if($spec['unit'])
                                                                        <span class="text-zinc-500 ml-1">{{ $spec['unit'] }}</span>
                                                                    @endif
                                                                @else
                                                                    <span class="text-zinc-400">-</span>
                                                                @endif
                                                            </div>
                                                            
                                                            @if($spec['imageName'])
                                                                <div class="flex-shrink-0">
                                                                    <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg p-2 border border-zinc-200 dark:border-zinc-700">
                                                                        <img 
                                                                            src="{{ $spec['imageName'] }}" 
                                                                            alt="{{ $spec['name'] }}" 
                                                                            class="w-24 h-24 object-contain rounded cursor-pointer hover:scale-105 transition-transform"
                                                                            onclick="openImageModal('{{ addslashes($spec['imageName']) }}', '{{ addslashes($spec['name']) }}')"
                                                                        >
                                                                        <p class="text-xs text-center text-zinc-500 mt-1">
                                                                            <flux:icon.magnifying-glass-plus class="w-3 h-3 inline mr-1" />
                                                                            Click to enlarge
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($section['value'] || $section['unit'])
                                <!-- Single value specification -->
                                <div class="flex items-center gap-4">
                                    <div class="flex-1">
                                        @if($section['value'])
                                            <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $section['value'] }}</span>
                                        @endif
                                        @if($section['unit'])
                                            <span class="text-zinc-500">{{ $section['unit'] }}</span>
                                        @endif
                                    </div>
                                    
                                    @if($section['imageName'])
                                        <div class="flex-shrink-0">
                                            <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg p-4 border border-zinc-200 dark:border-zinc-700">
                                                <img 
                                                    src="{{ $section['imageName'] }}" 
                                                    alt="{{ $section['name'] }}" 
                                                    class="w-32 h-32 object-contain rounded cursor-pointer hover:scale-105 transition-transform"
                                                    onclick="openImageModal('{{ addslashes($section['imageName']) }}', '{{ addslashes($section['name']) }}')"
                                                >
                                                <p class="text-xs text-center text-zinc-500 mt-2">
                                                    <flux:icon.magnifying-glass-plus class="w-3 h-3 inline mr-1" />
                                                    Click to enlarge image
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- No specific data message -->
                                <p class="text-zinc-500 text-sm">No specific data available for this section.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Data Available -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="p-8 text-center">
                    <flux:icon.exclamation-triangle class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Electrical Data Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        Electrical system data could not be loaded from the HaynesPro API for this vehicle.
                    </p>
                </div>
            </div>
        @endif

        <!-- Information Note -->
        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
            <div class="flex items-start gap-3">
                <flux:icon.information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" />
                <div>
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        @if(!empty($electricalData))
                            <strong>Live Data:</strong> Electrical system specifications are dynamically fetched from the HaynesPro API 
                            based on this vehicle's car type ID ({{ $vehicle->car_type_id ?? 'Not available' }}). Data includes alternator output, battery specifications, and electrical component locations.
                        @else
                            <strong>No Data Available:</strong> Electrical system data could not be loaded from the HaynesPro API. 
                            This may be due to missing vehicle identification data or API connectivity issues.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Electrical Terms Legend -->
        @if(!empty($electricalData))
            <div class="mt-6 bg-zinc-50 dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                <h3 class="text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-3">Electrical System Terms</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 text-xs">
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">A:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Amperes (current)</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">Ah:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Ampere-hours (capacity)</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">CCA:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Cold Cranking Amperes</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">EFB:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Enhanced Flooded Battery</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">Alternator:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Generates electrical power</span>
                    </div>
                </div>
            </div>
        @endif
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
