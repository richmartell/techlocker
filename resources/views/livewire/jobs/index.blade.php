<div class="space-y-6">
    <flux:card class="p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <flux:heading size="xl">Jobs</flux:heading>
                <flux:subheading>Track service and repair activities</flux:subheading>
            </div>
            <div class="flex gap-3">
                <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Search jobs..." />
                <flux:button href="{{ route('workshop.jobs.create') }}" wire:navigate icon="plus" variant="primary">New Job</flux:button>
            </div>
        </div>
    </flux:card>

    <flux:card>
        @if($jobs->count())
            <div class="overflow-x-auto">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column sortable wire:click="$set('sortBy', 'start_at')">Date</flux:table.column>
                        <flux:table.column sortable wire:click="$set('sortBy', 'title')">Name</flux:table.column>
                        <flux:table.column>Vehicle</flux:table.column>
                        <flux:table.column>Customer</flux:table.column>
                        <flux:table.column sortable wire:click="$set('sortBy', 'status')">Status</flux:table.column>
                        <flux:table.column>Technicians</flux:table.column>
                        <flux:table.column>Actions</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @foreach($jobs as $job)
                            <flux:table.row class="group">
                                <flux:table.cell class="text-sm">
                                    {{ $job->start_at?->format('d/m/y') ?? 'Not set' }}
                                </flux:table.cell>
                                <flux:table.cell class="font-medium">{{ $job->title }}</flux:table.cell>
                                <flux:table.cell>
                                    @if($job->vehicle)
                                        <div class="font-medium">{{ $job->vehicle->registration }}</div>
                                        <div class="text-xs text-zinc-500">{{ $job->vehicle->make }} {{ $job->vehicle->model }}</div>
                                    @else
                                        <span class="text-zinc-400">No vehicle</span>
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>
                                    @if($job->vehicle && $job->vehicle->currentCustomers->isNotEmpty())
                                        @php
                                            $customer = $job->vehicle->currentCustomers->first();
                                            $initial = strtoupper(substr($customer->first_name, 0, 1));
                                        @endphp
                                        <span class="text-sm">{{ $initial }} {{ $customer->last_name }}</span>
                                    @else
                                        <span class="text-zinc-400 text-sm">No customer</span>
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge :color="match($job->status){'scheduled'=>'zinc','in_progress'=>'blue','completed'=>'green','cancelled'=>'red',default=>'zinc'}">
                                        {{ str($job->status)->headline() }}
                                    </flux:badge>
                                </flux:table.cell>
                                <flux:table.cell class="text-sm">
                                    @if($job->technicians->isNotEmpty())
                                        @foreach($job->technicians as $technician)
                                            @php
                                                $techInitial = strtoupper(substr($technician->first_name, 0, 1));
                                            @endphp
                                            <span>{{ $techInitial }} {{ $technician->last_name }}</span>@if(!$loop->last), @endif
                                        @endforeach
                                    @else
                                        <span class="text-zinc-400">No technicians</span>
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>
                                    <div class="flex justify-end">
                                        <flux:button href="{{ route('workshop.jobs.show', $job) }}" wire:navigate size="sm" icon="eye" class="opacity-0 group-hover:opacity-100 transition-opacity !bg-zinc-900 !text-white hover:!bg-zinc-800 !border-zinc-900">View</flux:button>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </div>
            <div class="mt-4">{{ $jobs->links() }}</div>
        @else
            <div class="p-8 text-center">
                <flux:icon.briefcase class="w-12 h-12 text-zinc-400 mx-auto mb-3" />
                <flux:heading size="lg">No jobs yet</flux:heading>
                <flux:text>Create your first job to get started.</flux:text>
                <div class="mt-4">
                    <flux:button href="{{ route('workshop.jobs.create') }}" wire:navigate icon="plus" variant="primary">Create Job</flux:button>
                </div>
            </div>
        @endif
    </flux:card>
</div>
