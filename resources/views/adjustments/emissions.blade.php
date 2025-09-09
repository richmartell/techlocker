@php
    $title = 'Emissions Adjustments - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
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
                <span class="text-zinc-900 dark:text-zinc-100">Emissions</span>
            </nav>

            <div class="flex items-center gap-3 mb-2">
                <flux:icon.cog-8-tooth class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Emissions Adjustments</h1>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">
                Emissions data, fuel consumption, and environmental standards for {{ $vehicle->make?->name ?? 'Unknown' }} {{ $vehicle->model?->name ?? 'Unknown' }} ({{ $vehicle->registration }})
            </p>
        </div>

        @if($error)
            <!-- Error Message -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                    <div>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            <strong>Error loading emissions data:</strong> {{ $error }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($emissionsData))
            <!-- Emissions Data Sections -->
            <div class="space-y-6">
                @foreach($emissionsData as $section)
                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                        <!-- Section Header -->
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                {{ $section['section_name'] }}
                            </h2>
                        </div>
                        
                        <!-- Section Content -->
                        <div class="p-6">
                            @if(isset($section['items']) && !empty($section['items']))
                                <!-- Table for specifications -->
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                            @foreach($section['items'] as $spec)
                                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                                    <td class="px-4 py-3 text-sm font-medium text-zinc-900 dark:text-zinc-100 w-1/2">
                                                        {{ $spec['name'] ?? 'Unknown' }}
                                                        @if(isset($spec['remark']) && $spec['remark'])
                                                            <div class="text-xs text-zinc-500 mt-1">{{ $spec['remark'] }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                                        @if(isset($spec['value']) && $spec['value'])
                                                            <span class="font-medium">{{ $spec['value'] }}</span>
                                                            @if(isset($spec['unit']) && $spec['unit'])
                                                                <span class="text-zinc-500 ml-1">{{ $spec['unit'] }}</span>
                                                            @endif
                                                        @else
                                                            <span class="text-zinc-400">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Emissions Data Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        Emissions data could not be loaded from the HaynesPro API for this vehicle.
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
                        @if(!empty($emissionsData))
                            <strong>Live Data:</strong> Emissions data, fuel consumption values, and environmental standards are dynamically fetched from the HaynesPro API 
                            based on this vehicle's car type ID ({{ $vehicle->car_type_id ?? 'Not available' }}). Data includes EURO standards, CO2 levels, and regulatory test parameters.
                        @else
                            <strong>No Data Available:</strong> Emissions data could not be loaded from the HaynesPro API. 
                            This may be due to missing vehicle identification data, API connectivity issues, or no emissions data being available for this vehicle type.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Legend for Common Emissions Terms -->
        @if(!empty($emissionsData))
            <div class="mt-6 bg-zinc-50 dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                <h3 class="text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-3">Emissions Abbreviations</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 text-xs">
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">CO:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Carbon Monoxide</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">CO2:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Carbon Dioxide</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">HC:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Hydrocarbons</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">NOx:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Nitrogen Oxides</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">HC NOx:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Combined HC + NOx</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">g/km:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Grams per kilometer</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">l/100km:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Liters per 100 kilometers</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">m-1:</span>
                        <span class="text-zinc-600 dark:text-zinc-400">Inverse meters (smoke opacity)</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
