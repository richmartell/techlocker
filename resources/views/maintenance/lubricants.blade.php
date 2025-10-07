@php
    $title = 'Lubricants - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
@endphp

<x-layouts.app :title="$title" :vehicle="$vehicle" :vehicleImage="$vehicleImage ?? null">
    <div class="max-w-6xl mx-auto">
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
                <span class="text-zinc-900 dark:text-zinc-100">Lubricants</span>
            </nav>
            
            <div class="flex items-center gap-3 mb-2">
                <flux:icon.beaker class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Lubricants</h1>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">
                Lubricant specifications and requirements for {{ $vehicle->make?->name ?? 'Unknown' }} {{ $vehicle->model?->name ?? 'Unknown' }} ({{ $vehicle->registration }})
            </p>
        </div>

        @if($error)
            <!-- Error Message -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                    <div>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            <strong>Error loading lubricants:</strong> {{ $error }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($lubricants))
            <!-- Lubricants List -->
            <div class="space-y-6">
                @foreach($lubricants as $lubricantGroup)
                    @php
                        $groupName = $lubricantGroup['name'] ?? 'Unknown Group';
                        $lubricantItems = $lubricantGroup['lubricantItems'] ?? [];
                        $smartLinks = $lubricantGroup['smartLinks'] ?? [];
                        $groupTypes = $lubricantGroup['groupTypes'] ?? [];
                        $order = $lubricantGroup['order'] ?? 0;
                    @endphp

                    <flux:card>
                        <div class="p-6">
                            <!-- Group Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-1">
                                        {{ $groupName }}
                                    </h2>
                                    @if(!empty($groupTypes))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($groupTypes as $type)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                    {{ str_replace('_', ' ', $type) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if(!empty($lubricantItems))
                                <!-- Lubricant Items -->
                                <div class="space-y-4 mb-6">
                                    <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 border-b border-zinc-200 dark:border-zinc-700 pb-2">
                                        Lubricant Specifications
                                    </h3>
                                    
                                    <div class="grid gap-4 md:grid-cols-2">
                                        @foreach($lubricantItems as $item)
                                            @php
                                                $itemName = $item['name'] ?? 'Unknown Lubricant';
                                                $quality = $item['quality'] ?? null;
                                                $viscosity = $item['viscosity'] ?? null;
                                                $temperature = $item['temperature'] ?? null;
                                                $generalArticles = $item['generalArticles'] ?? [];
                                            @endphp

                                            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
                                                <h4 class="font-medium text-zinc-900 dark:text-zinc-100 mb-3">{{ $itemName }}</h4>
                                                
                                                <div class="space-y-2 text-sm">
                                                    @if($quality)
                                                        <div class="flex justify-between">
                                                            <span class="text-zinc-600 dark:text-zinc-400">Quality:</span>
                                                            <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $quality }}</span>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($viscosity)
                                                        <div class="flex justify-between">
                                                            <span class="text-zinc-600 dark:text-zinc-400">Viscosity:</span>
                                                            <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $viscosity }}</span>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($temperature)
                                                        <div class="flex justify-between">
                                                            <span class="text-zinc-600 dark:text-zinc-400">Temperature:</span>
                                                            <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $temperature }}</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                @if(!empty($generalArticles))
                                                    <div class="mt-3 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">General Articles:</div>
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($generalArticles as $article)
                                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                                    {{ $article['description'] ?? 'Unknown' }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(!empty($smartLinks))
                                <!-- Smart Links -->
                                <div class="space-y-4">
                                    <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 border-b border-zinc-200 dark:border-zinc-700 pb-2">
                                        Additional Information
                                    </h3>
                                    
                                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                        @foreach($smartLinks as $link)
                                            @php
                                                $operation = $link['operation'] ?? null;
                                                $text = $link['text'] ?? null;
                                                $id2 = $link['id2'] ?? null;
                                            @endphp

                                            @if($operation === 'IMAGE' && $id2)
                                                <!-- Image Link -->
                                                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-3 bg-zinc-50 dark:bg-zinc-800/50">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <flux:icon.photo class="w-4 h-4 text-zinc-500 dark:text-zinc-400" />
                                                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Diagram</span>
                                                    </div>
                                                    <img src="{{ $id2 }}" alt="Technical diagram" class="w-full h-auto rounded border border-zinc-200 dark:border-zinc-700" loading="lazy" />
                                                </div>
                                            @elseif($text && is_array($text))
                                                <!-- Text Information -->
                                                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-3">
                                                    @foreach($text as $index => $textItem)
                                                        @if($index === 0)
                                                            <div class="font-medium text-zinc-900 dark:text-zinc-100 text-sm mb-1">{{ $textItem }}</div>
                                                        @elseif($index === 1 && $textItem)
                                                            <div class="text-lg font-semibold text-blue-600 dark:text-blue-400">{{ $textItem }}</div>
                                                        @elseif($index === 2 && $textItem)
                                                            <div class="text-sm text-zinc-600 dark:text-zinc-400">{{ $textItem }}</div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </flux:card>
                @endforeach
            </div>
        @else
            <!-- No Data Message -->
            <flux:card>
                <div class="text-center py-12">
                    <flux:icon.beaker class="w-16 h-16 text-zinc-300 dark:text-zinc-600 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No lubricant data available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        Lubricant specifications are not available for this vehicle at the moment.
                    </p>
                </div>
            </flux:card>
        @endif
    </div>
</x-layouts.app>
