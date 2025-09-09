@php
    $title = 'Brake System Adjustments - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
@endphp

<x-layouts.app :title="$title" :vehicle="$vehicle" :vehicleImage="$vehicleImage ?? null">
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 dark:hover:text-zinc-100">Dashboard</a>
                <flux:icon.chevron-right class="w-4 h-4" />
                <a href="{{ route('vehicle-details', $vehicle->registration) }}" class="hover:text-zinc-900 dark:hover:text-zinc-100">{{ $vehicle->registration }}</a>
                <flux:icon.chevron-right class="w-4 h-4" />
                <span class="text-zinc-900 dark:text-zinc-100">Brakes</span>
            </div>
            
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Brakes</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-2">
                Brake system specifications, disc measurements, and adjustment values for {{ $vehicle->registration }}
            </p>
        </div>

        @if(!empty($brakesData))
            <!-- Brakes System Sections -->
            <div class="space-y-6">
                @foreach($brakesData as $section)
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
                                                @elseif(isset($spec['parent_remark']) && $spec['parent_remark'])
                                                    <div class="text-xs text-zinc-500 mt-1">({{ $spec['parent_remark'] }})</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                                @if($spec['value'])
                                                    <span class="font-medium">{{ $spec['value'] }}</span>
                                                    @if($spec['unit'])
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
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Data Available -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="p-8 text-center">
                    <flux:icon.exclamation-triangle class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Brake Data Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        @if($error)
                            Error loading brake data: {{ $error }}
                        @else
                            No brake adjustment data found for this vehicle.
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
</x-layouts.app>
