@php
    $title = 'Engine (General) Adjustments - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
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
                <span class="text-zinc-900 dark:text-zinc-100">Engine (General)</span>
            </nav>

            <div class="flex items-center gap-3 mb-2">
                <flux:icon.cog-8-tooth class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Engine (General) Adjustments</h1>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">
                Engine specifications and general adjustment values for {{ $vehicle->make?->name ?? 'Unknown' }} {{ $vehicle->model?->name ?? 'Unknown' }} ({{ $vehicle->registration }})
            </p>
        </div>

        @if($error)
            <!-- Error Message -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                    <div>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            <strong>Error loading engine adjustments:</strong> {{ $error }}
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
                    @if(!empty($engineAdjustments))
                        Live data from HaynesPro API for this vehicle
                    @else
                        General engine parameters and adjustment values
                    @endif
                </p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @if(!empty($engineAdjustments))
                            @foreach($engineAdjustments as $adjustment)
                                @if($adjustment['name'] === 'Engine')
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                        <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50 w-1/3">
                                            {{ $adjustment['name'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                            {{ $adjustment['value'] ?: '-' }}
                                            @if($adjustment['unit'])
                                                <span class="text-zinc-500">{{ $adjustment['unit'] }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @elseif($adjustment['name'] === 'Distribution type')
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                        <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50 w-1/3">
                                            {{ $adjustment['name'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                            {{ $adjustment['value'] ?: '-' }}
                                        </td>
                                    </tr>
                                    @if(isset($adjustment['subAdjustments']))
                                        @foreach($adjustment['subAdjustments'] as $subAdjustment)
                                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50 w-1/3">
                                                    {{ $subAdjustment['name'] }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                                    {{ $subAdjustment['value'] ?: '-' }}
                                                    @if($subAdjustment['unit'])
                                                        <span class="text-zinc-500">{{ $subAdjustment['unit'] }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @else
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                        <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50 w-1/3">
                                            {{ $adjustment['name'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                            {{ $adjustment['value'] ?: '-' }}
                                            @if($adjustment['unit'])
                                                <span class="text-zinc-500">{{ $adjustment['unit'] }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <!-- Fallback static data if API fails -->
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50 w-1/3">
                                    Engine
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">-</td>
                            </tr>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50">
                                    Engine code
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    No data available
                                </td>
                            </tr>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50">
                                    Capacity
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    No data available
                                </td>
                            </tr>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50">
                                    Distribution type
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    No data available
                                </td>
                            </tr>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50">
                                    Timing chain
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    No data available
                                </td>
                            </tr>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50">
                                    Engine speed at maximum power
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    No data available
                                </td>
                            </tr>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50">
                                    Number of cylinders
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                    No data available
                                </td>
                            </tr>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-800/50">
                                    Valves per cylinder
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

    </div>
</x-layouts.app>
