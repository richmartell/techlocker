@php
    $title = 'Fluid Capacities - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
@endphp

<x-layouts.app :title="$title" :vehicle="$vehicle" :vehicleImage="$vehicleImage ?? null">
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 dark:hover:text-zinc-100">Dashboard</a>
                <flux:icon.chevron-right class="w-4 h-4" />
                <a href="{{ route('vehicle-details', $vehicle->registration) }}" class="hover:text-zinc-900 dark:hover:text-zinc-100">{{ $vehicle->registration }}</a>
                <flux:icon.chevron-right class="w-4 h-4" />
                <span class="text-zinc-900 dark:text-zinc-100">Capacities</span>
            </nav>
            
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Capacities</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-2">
                Fluid capacities, plug locations, and refill specifications for {{ $vehicle->registration }}
            </p>
        </div>

        @if(!empty($capacitiesData))
            <!-- Capacities System Sections -->
            <div class="space-y-6">
                @foreach($capacitiesData as $section)
                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                        <!-- Section Header -->
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $section['section_name'] }}</h2>
                        </div>
                        
                        <!-- Section Content -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @foreach($section['items'] as $spec)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                            <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50 w-1/3 {{ isset($spec['is_sub_item']) && $spec['is_sub_item'] ? 'pl-12' : '' }}">
                                                @if(isset($spec['is_sub_item']) && $spec['is_sub_item'])
                                                    <div class="flex items-center">
                                                        <flux:icon.arrow-turn-down-right class="w-4 h-4 text-zinc-400 mr-2 flex-shrink-0" />
                                                        <span>{{ $spec['name'] ?? 'Unknown' }}</span>
                                                    </div>
                                                @else
                                                    {{ $spec['name'] ?? 'Unknown' }}
                                                @endif
                                                @if($spec['remark'])
                                                    <div class="text-xs text-zinc-500 mt-1">({{ $spec['remark'] }})</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
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
                                                            <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg p-3 border border-zinc-200 dark:border-zinc-700">
                                                                <img 
                                                                    src="{{ $spec['imageName'] }}" 
                                                                    alt="{{ $spec['name'] }}" 
                                                                    class="w-32 h-32 object-contain rounded cursor-pointer hover:scale-105 transition-transform"
                                                                    onclick="openImageModal('{{ addslashes($spec['imageName']) }}', '{{ addslashes($spec['name']) }}')"
                                                                >
                                                                <p class="text-xs text-center text-zinc-500 mt-2">
                                                                    <flux:icon.magnifying-glass-plus class="w-3 h-3 inline mr-1" />
                                                                    Click to enlarge
                                                                </p>
                                                                @if($spec['remark'])
                                                                    <p class="text-xs text-center text-zinc-600 dark:text-zinc-400 mt-1 font-medium">
                                                                        {{ $spec['remark'] }}
                                                                    </p>
                                                                @endif
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
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Data Available -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="p-8 text-center">
                    <flux:icon.exclamation-triangle class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Capacities Data Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        @if($error)
                            Error loading capacities data: {{ $error }}
                        @else
                            No capacities data found for this vehicle.
                        @endif
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

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button 
                onclick="closeImageModal()" 
                class="absolute -top-10 right-0 text-white hover:text-zinc-300 transition-colors"
            >
                <flux:icon.x-mark class="w-8 h-8" />
            </button>
            <img 
                id="modalImage" 
                src="" 
                alt="" 
                class="max-w-full max-h-full object-contain rounded-lg"
            >
            <div id="modalTitle" class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-75 text-white p-4 rounded-b-lg">
                <h3 class="text-lg font-medium"></h3>
            </div>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc, imageTitle) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle').querySelector('h3');
            
            modalImage.src = imageSrc;
            modalImage.alt = imageTitle;
            modalTitle.textContent = imageTitle;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-layouts.app>
