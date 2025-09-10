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

        <!-- System Selector -->
        @if(!empty($maintenanceSystems) && count($maintenanceSystems) > 1)
            <div class="mb-6">
                <flux:card>
                    <div class="p-6">
                        <label for="system-selector" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">
                            Maintenance Schedule Type
                        </label>
                        <flux:select 
                            id="system-selector"
                            name="systemId"
                            onchange="window.location.href = '{{ route('maintenance.schedules', $vehicle->registration) }}?systemId=' + this.value"
                        >
                            <option value="">All Systems</option>
                            @foreach($maintenanceSystems as $system)
                                <option value="{{ $system['id'] ?? '' }}" 
                                    {{ request('systemId') == ($system['id'] ?? '') ? 'selected' : '' }}>
                                    {{ $system['name'] ?? 'Unknown System' }}
                                </option>
                            @endforeach
                        </flux:select>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">
                            Select a specific maintenance schedule type to view relevant service intervals
                        </p>
                    </div>
                </flux:card>
            </div>
        @endif

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
                                        {{ $interval['description'] ?? 'Unknown Interval' }}
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

    </div>
</x-layouts.app> 