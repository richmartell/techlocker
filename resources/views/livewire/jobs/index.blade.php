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

        <div class="mt-4 flex flex-wrap gap-3">
            <flux:select wire:model.live="status" placeholder="Status" class="w-40">
                <flux:select.option value="all">All</flux:select.option>
                <flux:select.option value="scheduled">Scheduled</flux:select.option>
                <flux:select.option value="in_progress">In progress</flux:select.option>
                <flux:select.option value="completed">Completed</flux:select.option>
                <flux:select.option value="cancelled">Cancelled</flux:select.option>
            </flux:select>
            <flux:input type="date" wire:model.live="dateFrom" placeholder="From" />
            <flux:input type="date" wire:model.live="dateTo" placeholder="To" />
        </div>
    </flux:card>

    <flux:card>
        @if($jobs->count())
            <div class="overflow-x-auto">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column sortable wire:click="$set('sortBy', 'job_number')">Job #</flux:table.column>
                        <flux:table.column>Title</flux:table.column>
                        <flux:table.column>Vehicle</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column sortable wire:click="$set('sortBy', 'start_at')">Start</flux:table.column>
                        <flux:table.column sortable wire:click="$set('sortBy', 'end_at')">End</flux:table.column>
                        <flux:table.column>Technicians</flux:table.column>
                        <flux:table.column>Actions</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @foreach($jobs as $job)
                            <flux:table.row>
                                <flux:table.cell class="font-mono">{{ $job->job_number }}</flux:table.cell>
                                <flux:table.cell>{{ $job->title }}</flux:table.cell>
                                <flux:table.cell>
                                    @if($job->vehicle)
                                        <a href="{{ route('vehicle-details', $job->vehicle->registration) }}" class="text-blue-600" wire:navigate>
                                            {{ $job->vehicle->registration }}
                                        </a>
                                        <div class="text-xs text-zinc-500">{{ $job->vehicle->make }} {{ $job->vehicle->model }}</div>
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge :color="match($job->status){'scheduled'=>'zinc','in_progress'=>'blue','completed'=>'green','cancelled'=>'red',default=>'zinc'}">
                                        {{ str($job->status)->headline() }}
                                    </flux:badge>
                                </flux:table.cell>
                                <flux:table.cell class="text-sm text-zinc-500">{{ $job->start_at?->format('Y-m-d H:i') }}</flux:table.cell>
                                <flux:table.cell class="text-sm text-zinc-500">{{ $job->end_at?->format('Y-m-d H:i') }}</flux:table.cell>
                                <flux:table.cell class="text-sm">
                                    {{ $job->technicians->pluck('full_name')->join(', ') }}
                                </flux:table.cell>
                                <flux:table.cell>
                                    <div class="flex gap-2">
                                        <flux:button href="{{ route('workshop.jobs.show', $job) }}" wire:navigate size="sm" icon="eye">View</flux:button>
                                        <flux:button href="{{ route('workshop.jobs.edit', $job) }}" wire:navigate size="sm" variant="ghost" icon="pencil">Edit</flux:button>
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
