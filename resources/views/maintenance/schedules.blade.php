@php
    $title = 'Maintenance Schedules - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
@endphp

<x-layouts.app :title="$title" :vehicle="$vehicle">
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <flux:icon.calendar-days class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Maintenance Schedules</h1>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">
                Service intervals and scheduled maintenance for {{ $vehicle->make?->name ?? 'Unknown' }} {{ $vehicle->model?->name ?? 'Unknown' }} ({{ $vehicle->registration }})
            </p>
        </div>

        @if(!empty($maintenanceIntervals))
            <!-- Service Intervals Table -->
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Service Interval</flux:table.column>
                </flux:table.columns>
                
                <flux:table.rows>
                    @foreach($maintenanceIntervals as $interval)
                        <flux:table.row :key="$interval['periodId'] ?? $loop->index">
                            <!-- Service Interval -->
                            <flux:table.cell>
                                <div class="space-y-1">
                                    <div class="font-medium text-zinc-900 dark:text-zinc-100">
                                        @if(isset($interval['intervalMileage']) && $interval['intervalMileage'] > 0)
                                            {{ number_format($interval['intervalMileage']) }} miles
                                        @endif
                                        @if(isset($interval['intervalMileage']) && $interval['intervalMileage'] > 0 && isset($interval['intervalMonths']) && $interval['intervalMonths'] > 0)
                                            /
                                        @endif
                                        @if(isset($interval['intervalMonths']) && $interval['intervalMonths'] > 0)
                                            {{ $interval['intervalMonths'] }} months
                                        @endif
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $interval['systemName'] ?? 'Standard Service' }}
                                    </div>
                                </div>
                            </flux:table.cell>
                            
                            <!-- Action -->
                            <flux:table.cell align="end">
                                <flux:button 
                                    size="sm" 
                                    variant="primary"
                                    href="{{ route('maintenance.schedule-details', [
                                        'registration' => $vehicle->registration,
                                        'systemId' => $interval['systemId'] ?? 0,
                                        'periodId' => $interval['periodId'] ?? 0
                                    ]) }}"
                                    wire:navigate
                                >
                                    View
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        @else
            <!-- No Data State -->
            <flux:card>
                <div class="p-8 text-center">
                    <flux:icon.calendar-days class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Maintenance Schedules Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-4">
                        No scheduled maintenance intervals found for this vehicle. This could be due to:
                    </p>
                    <ul class="text-sm text-zinc-600 dark:text-zinc-400 space-y-1 max-w-md mx-auto text-left">
                        <li>• Vehicle identification not complete</li>
                        <li>• Data not available in HaynesPro database</li>
                        <li>• Maintenance schedules may be available under Technical Information</li>
                    </ul>
                </div>
            </flux:card>
        @endif

        <!-- Debug Information (remove in production) -->
        @if(config('app.debug'))
            <div class="mt-8 space-y-4">
                @if(!empty($maintenanceIntervals))
                    <flux:card>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Debug: Maintenance Intervals ({{ count($maintenanceIntervals) }} found)</h3>
                            <pre class="bg-zinc-100 dark:bg-zinc-800 p-4 rounded text-xs overflow-auto">{{ json_encode($maintenanceIntervals, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </flux:card>
                @endif
                
                @if(!empty($maintenanceSystems))
                    <flux:card>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Debug: Raw Maintenance Systems ({{ count($maintenanceSystems) }} found)</h3>
                            <pre class="bg-zinc-100 dark:bg-zinc-800 p-4 rounded text-xs overflow-auto">{{ json_encode($maintenanceSystems, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </flux:card>
                @endif
            </div>
        @endif
    </div>
</x-layouts.app> 