@php
    $title = 'Torque Settings - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
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
                <span class="text-zinc-900 dark:text-zinc-100">Torque Settings</span>
            </nav>
            
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Torque Settings</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-2">
                Tightening torques and specifications for {{ $vehicle->registration }}
            </p>
        </div>

        <!-- Important Notice -->
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <flux:icon.exclamation-triangle class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 mr-3 flex-shrink-0" />
                <div>
                    <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-200">Important Notes</h3>
                    <p class="text-sm text-amber-700 dark:text-amber-300 mt-1">
                        Always renew stretch bolts and self-locking nuts. Follow the specified tightening sequence and stages exactly as shown.
                    </p>
                </div>
            </div>
        </div>

        @if(!empty($torqueData))
            <!-- Torque Settings System Sections -->
            <div class="space-y-6">
                @foreach($torqueData as $section)
                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                        <!-- Section Header -->
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $section['section_name'] }}</h2>
                        </div>
                        
                        <!-- Section Content -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Component</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Torque Specification</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @foreach($section['items'] as $spec)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                            <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 w-1/2 {{ isset($spec['is_sub_item']) && $spec['is_sub_item'] ? 'pl-12' : '' }}">
                                                @if(isset($spec['is_sub_item']) && $spec['is_sub_item'])
                                                    <div class="flex items-start">
                                                        <flux:icon.arrow-turn-down-right class="w-4 h-4 text-zinc-400 mr-2 flex-shrink-0 mt-0.5" />
                                                        <div>
                                                            <span>{{ $spec['name'] ?? 'Unknown' }}</span>
                                                            @if($spec['remark'])
                                                                <div class="text-xs text-zinc-500 mt-1">{{ $spec['remark'] }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <div>
                                                        {{ $spec['name'] ?? 'Unknown' }}
                                                        @if($spec['remark'])
                                                            <div class="text-xs text-zinc-500 mt-1">{{ $spec['remark'] }}</div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                                <div class="flex items-start gap-4">
                                                    <div class="flex-1">
                                                        @if($spec['value'])
                                                            <div class="space-y-1">
                                                                @php
                                                                    // Check if this is a multi-stage torque specification
                                                                    $value = $spec['value'];
                                                                    $unit = $spec['unit'] ?? '';
                                                                    
                                                                    // Look for stage patterns
                                                                    if (str_contains($value, 'Stage')) {
                                                                        $stages = explode("\n", $value);
                                                                    } else {
                                                                        $stages = [$value];
                                                                    }
                                                                @endphp
                                                                
                                                                @foreach($stages as $stage)
                                                                    @if(trim($stage))
                                                                        <div class="flex items-center gap-2">
                                                                            @if(str_contains($stage, 'Stage'))
                                                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                                                                                    {{ trim($stage) }}
                                                                                </span>
                                                                            @else
                                                                                <span class="font-medium">{{ trim($stage) }}</span>
                                                                                @if($unit)
                                                                                    <span class="text-zinc-500 text-xs">({{ $unit }})</span>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <span class="text-zinc-400">-</span>
                                                        @endif
                                                        
                                                        @if(str_contains(strtolower($spec['remark'] ?? ''), 'renew'))
                                                            <div class="mt-2 inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200">
                                                                <flux:icon.exclamation-triangle class="w-3 h-3 mr-1" />
                                                                Renew bolts/nuts
                                                            </div>
                                                        @endif
                                                        
                                                        @if(str_contains(strtolower($spec['remark'] ?? ''), 'clean'))
                                                            <div class="mt-2 inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                                                                <flux:icon.sparkles class="w-3 h-3 mr-1" />
                                                                Clean surfaces
                                                            </div>
                                                        @endif
                                                        
                                                        @if(str_contains(strtolower($spec['remark'] ?? ''), 'sealant'))
                                                            <div class="mt-2 inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200">
                                                                <flux:icon.wrench class="w-3 h-3 mr-1" />
                                                                Apply sealant
                                                            </div>
                                                        @endif
                                                        
                                                        @if(str_contains(strtolower($spec['remark'] ?? ''), 'criss-cross'))
                                                            <div class="mt-2 inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-200">
                                                                <flux:icon.arrows-pointing-out class="w-3 h-3 mr-1" />
                                                                Criss-cross pattern
                                                            </div>
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
                    <flux:icon.wrench-screwdriver class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Torque Settings Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        @if($error)
                            Error loading torque settings: {{ $error }}
                        @else
                            No torque settings data found for this vehicle.
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
