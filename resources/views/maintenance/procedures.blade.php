@php
    $title = 'Maintenance Procedures - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
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
                <span class="text-zinc-900 dark:text-zinc-100">Maintenance Procedures</span>
            </nav>
            
            <div class="flex items-center gap-3 mb-2">
                <flux:icon.wrench-screwdriver class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Maintenance Procedures</h1>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">
                Step-by-step maintenance procedures for {{ $vehicle->make?->name ?? 'Unknown' }} {{ $vehicle->model?->name ?? 'Unknown' }} ({{ $vehicle->registration }})
            </p>
        </div>

        @if($error)
            <!-- Error Message -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                    <div>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            <strong>Error loading maintenance procedures:</strong> {{ $error }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($procedures))
            <!-- Procedures List -->
            <flux:card>
                <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @foreach($procedures as $story)
                        @php
                            $storyName = $story['name'] ?? 'Unknown Procedure';
                            $storyId = $story['storyId'] ?? null;
                            $storyOrder = $story['order'] ?? 0;
                        @endphp
                        
                        @if($storyId)
                            <div class="p-6 hover:bg-zinc-50 dark:hover:bg-zinc-900/50 transition-colors duration-200">
                                <div class="flex items-center justify-between">
                                    <!-- Story Icon & Title -->
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center">
                                            @if(stripos($storyName, 'service indicator') !== false)
                                                <flux:icon.light-bulb class="w-5 h-5" />
                                            @elseif(stripos($storyName, 'battery') !== false)
                                                <flux:icon.battery-100 class="w-5 h-5" />
                                            @elseif(stripos($storyName, 'key') !== false || stripos($storyName, 'remote') !== false)
                                                <flux:icon.key class="w-5 h-5" />
                                            @elseif(stripos($storyName, 'jack') !== false || stripos($storyName, 'lift') !== false)
                                                <flux:icon.arrow-up class="w-5 h-5" />
                                            @else
                                                <flux:icon.wrench-screwdriver class="w-5 h-5" />
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                                {{ $storyName }}
                                            </h3>
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                Maintenance procedure
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <flux:button 
                                        size="sm" 
                                        variant="primary"
                                        :href="route('maintenance.story', ['registration' => $vehicle->registration, 'storyId' => $storyId])"
                                        wire:navigate
                                    >
                                        View Procedure
                                        <flux:icon.arrow-right class="w-4 h-4 ml-1" />
                                    </flux:button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </flux:card>

        @else
            <!-- No Procedures Available -->
            <flux:card>
                <div class="p-8 text-center">
                    <flux:icon.wrench-screwdriver class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Maintenance Procedures Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-4">
                        No maintenance procedures found for this vehicle. This could be due to:
                    </p>
                    <ul class="text-sm text-zinc-600 dark:text-zinc-400 space-y-1 max-w-md mx-auto text-left">
                        <li>• Vehicle identification not complete</li>
                        <li>• Data not available in HaynesPro database</li>
                        <li>• Procedures may be available under other sections</li>
                    </ul>
                </div>
            </flux:card>
        @endif
    </div>
</x-layouts.app>
