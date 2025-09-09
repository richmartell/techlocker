@php
    $title = 'Cooling System Adjustments - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
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
                <span class="text-zinc-900 dark:text-zinc-100">Cooling System</span>
            </nav>

            <div class="flex items-center gap-3 mb-2">
                <flux:icon.cog-8-tooth class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Cooling System Adjustments</h1>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">
                Cooling system specifications and adjustment values for {{ $vehicle->make?->name ?? 'Unknown' }} {{ $vehicle->model?->name ?? 'Unknown' }} ({{ $vehicle->registration }})
            </p>
        </div>

        @if($error)
            <!-- Error Message -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                    <div>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            <strong>Error loading cooling system data:</strong> {{ $error }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Cooling System Specifications Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Cooling System Specifications</h2>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                    @if(!empty($coolingSystemData))
                        Live cooling system data from HaynesPro API
                    @else
                        Cooling system specifications and adjustment values
                    @endif
                </p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @if(!empty($coolingSystemData))
                            @foreach($coolingSystemData as $specification)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50 w-1/3">
                                        {{ $specification['name'] }}
                                        @if($specification['remark'])
                                            <div class="text-xs text-zinc-500 mt-1">{{ $specification['remark'] }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                        @if($specification['value'])
                                            <span class="font-medium">{{ $specification['value'] }}</span>
                                            @if($specification['unit'])
                                                <span class="text-zinc-500 ml-1">{{ $specification['unit'] }}</span>
                                            @endif
                                        @else
                                            <span class="text-zinc-400">-</span>
                                        @endif

                                        @if($specification['imageName'])
                                            <div class="mt-2">
                                                <img 
                                                    src="{{ $specification['imageName'] }}" 
                                                    alt="{{ $specification['name'] }}" 
                                                    class="max-w-xs h-auto rounded cursor-pointer hover:scale-105 transition-transform"
                                                    onclick="openImageModal('{{ addslashes($specification['imageName']) }}', '{{ addslashes($specification['name']) }}')"
                                                >
                                                <p class="text-xs text-zinc-500 mt-1">
                                                    <flux:icon.magnifying-glass-plus class="w-3 h-3 inline mr-1" />
                                                    Click to enlarge image
                                                </p>
                                            </div>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Handle nested specifications if any -->
                                @if(isset($specification['subAdjustments']) && !empty($specification['subAdjustments']))
                                    @foreach($specification['subAdjustments'] as $subSpec)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                            <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50 w-1/3 pl-12">
                                                <div class="flex items-center gap-2">
                                                    <flux:icon.arrow-turn-down-right class="w-3 h-3 text-zinc-400" />
                                                    {{ $subSpec['name'] }}
                                                </div>
                                                @if($subSpec['remark'])
                                                    <div class="text-xs text-zinc-500 mt-1 ml-5">{{ $subSpec['remark'] }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                                @if($subSpec['value'])
                                                    <span class="font-medium">{{ $subSpec['value'] }}</span>
                                                    @if($subSpec['unit'])
                                                        <span class="text-zinc-500 ml-1">{{ $subSpec['unit'] }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-zinc-400">-</span>
                                                @endif

                                                @if($subSpec['imageName'])
                                                    <div class="mt-2">
                                                        <img 
                                                            src="{{ $subSpec['imageName'] }}" 
                                                            alt="{{ $subSpec['name'] }}" 
                                                            class="max-w-xs h-auto rounded cursor-pointer hover:scale-105 transition-transform"
                                                            onclick="openImageModal('{{ addslashes($subSpec['imageName']) }}', '{{ addslashes($subSpec['name']) }}')"
                                                        >
                                                        <p class="text-xs text-zinc-500 mt-1">
                                                            <flux:icon.magnifying-glass-plus class="w-3 h-3 inline mr-1" />
                                                            Click to enlarge image
                                                        </p>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @else
                            <!-- Fallback static data if API fails -->
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50 w-1/3">
                                    Cap pressure
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    No data available
                                </td>
                            </tr>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50">
                                    Thermostat opening temperature
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    No data available
                                </td>
                            </tr>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50">
                                    Thermostat fully open
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    No data available
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Technical Terms Legend -->
        @if(!empty($coolingSystemData))
            <div class="mt-6 bg-zinc-50 dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                <h3 class="text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-3">Cooling System Terms</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">Cap pressure:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Radiator cap relief pressure</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">Thermostat:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Controls coolant flow temperature</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">bar:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Unit of pressure (1 bar ≈ 14.5 psi)</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">°C:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Degrees Celsius</span>
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
