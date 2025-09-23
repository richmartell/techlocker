<div class="space-y-6">
    <flux:card class="p-6">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ $job->title }}</flux:heading>
                <flux:subheading>Job #{{ $job->job_number }}</flux:subheading>
            </div>
            <div class="flex items-center gap-2">
                <flux:badge :color="match($job->status){'scheduled'=>'zinc','in_progress'=>'blue','completed'=>'green','cancelled'=>'red',default=>'zinc'}">
                    {{ str($job->status)->headline() }}
                </flux:badge>
                <flux:button href="{{ route('workshop.jobs.edit', $job) }}" wire:navigate icon="pencil">Edit</flux:button>
            </div>
        </div>
    </flux:card>

    <flux:card>
        <flux:tab.group default="overview">
            <flux:tabs>
                <flux:tab name="overview" icon="document-text">Overview</flux:tab>
                <flux:tab name="notes" icon="pencil-square">Notes</flux:tab>
                <flux:tab name="timeline" icon="clock">Timeline</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="overview" class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-zinc-500">Vehicle</div>
                        @if($job->vehicle)
                            <a href="{{ route('vehicle-details', $job->vehicle->registration) }}" class="font-medium text-blue-600" wire:navigate>
                                {{ $job->vehicle->registration }}
                            </a>
                            <div class="text-sm text-zinc-500">{{ $job->vehicle->make }} {{ $job->vehicle->model }}</div>
                        @endif
                    </div>
                    <div>
                        <div class="text-sm text-zinc-500">Times</div>
                        <div class="text-sm">Start: {{ $job->start_at?->format('Y-m-d H:i') ?? '—' }}</div>
                        <div class="text-sm">End: {{ $job->end_at?->format('Y-m-d H:i') ?? '—' }}</div>
                    </div>
                </div>

                <div>
                    <div class="text-sm text-zinc-500 mb-2">Technicians</div>
                    <div class="flex flex-wrap gap-2">
                        @forelse($job->technicians as $tech)
                            <flux:badge>{{ $tech->full_name }}{{ $tech->pivot?->role ? ' — ' . $tech->pivot->role : '' }}</flux:badge>
                        @empty
                            <span class="text-sm text-zinc-500">None assigned</span>
                        @endforelse
                    </div>
                </div>

                <div>
                    <div class="text-sm text-zinc-500 mb-2">Description</div>
                    <div class="prose dark:prose-invert max-w-none text-sm">{{ $job->description ?: '—' }}</div>
                </div>
            </flux:tab.panel>

            <flux:tab.panel name="notes" class="p-6">
                <div class="text-sm text-zinc-500">Long-form notes (coming soon)</div>
            </flux:tab.panel>

            <flux:tab.panel name="timeline" class="p-6">
                <div class="text-sm text-zinc-500">Timeline of status changes and assignments (coming soon)</div>
            </flux:tab.panel>
        </flux:tab.group>
    </flux:card>
</div>
