<section>
    <x-settings.layout>
        <x-slot name="title">{{ $technician->full_name }}</x-slot>
        <x-slot name="description">{{ __('Technician details and job assignments') }}</x-slot>

        <div class="space-y-6">
            {{-- Technician Info Card --}}
            <flux:card class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <flux:heading size="lg">Technician Information</flux:heading>
                    <div class="flex items-center gap-3">
                        <flux:switch :checked="$technician->active" wire:click="toggleActive">
                            {{ $technician->active ? 'Active' : 'Inactive' }}
                        </flux:switch>
                        <flux:button 
                            href="{{ route('settings.technicians.edit', $technician) }}" 
                            wire:navigate 
                            icon="pencil" 
                            size="sm"
                        >
                            Edit
                        </flux:button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-zinc-500">First Name</div>
                        <div class="font-medium">{{ $technician->first_name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-zinc-500">Last Name</div>
                        <div class="font-medium">{{ $technician->last_name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-zinc-500">Email</div>
                        <div class="font-medium">
                            @if($technician->email)
                                <a href="mailto:{{ $technician->email }}" class="text-blue-600 hover:underline">
                                    {{ $technician->email }}
                                </a>
                            @else
                                <span class="text-zinc-400">—</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-zinc-500">Phone</div>
                        <div class="font-medium">
                            @if($technician->phone)
                                <a href="tel:{{ $technician->phone }}" class="text-blue-600 hover:underline">
                                    {{ $technician->phone }}
                                </a>
                            @else
                                <span class="text-zinc-400">—</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($technician->notes)
                    <div class="mt-4">
                        <div class="text-sm text-zinc-500 mb-2">Notes</div>
                        <div class="text-sm bg-zinc-50 dark:bg-zinc-800 p-3 rounded">
                            {{ $technician->notes }}
                        </div>
                    </div>
                @endif
            </flux:card>

            {{-- Assigned Jobs --}}
            <flux:card class="p-6">
                <flux:heading size="lg" class="mb-4">Assigned Jobs ({{ $technician->jobs->count() }})</flux:heading>
                
                @if($technician->jobs->count() > 0)
                    <div class="space-y-3">
                        @foreach($technician->jobs->take(10) as $job)
                            <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-800 rounded">
                                <div>
                                    <div class="font-medium">
                                        <a href="{{ route('workshop.jobs.show', $job) }}" class="text-blue-600 hover:underline" wire:navigate>
                                            {{ $job->job_number }}
                                        </a>
                                        — {{ $job->title }}
                                    </div>
                                    <div class="text-sm text-zinc-500">
                                        @if($job->vehicle)
                                            {{ $job->vehicle->registration }} ({{ $job->vehicle->make }} {{ $job->vehicle->model }})
                                        @endif
                                        @if($job->pivot?->role)
                                            — Role: {{ $job->pivot->role }}
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <flux:badge :color="match($job->status){'scheduled'=>'zinc','in_progress'=>'blue','completed'=>'green','cancelled'=>'red',default=>'zinc'}">
                                        {{ str($job->status)->headline() }}
                                    </flux:badge>
                                    <div class="text-xs text-zinc-500 mt-1">
                                        {{ $job->start_at?->format('M d, Y') ?? 'No date' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($technician->jobs->count() > 10)
                            <div class="text-center text-sm text-zinc-500 py-2">
                                And {{ $technician->jobs->count() - 10 }} more jobs...
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8">
                        <flux:icon.briefcase class="w-12 h-12 text-zinc-400 mx-auto mb-3" />
                        <div class="text-zinc-500">No jobs assigned yet</div>
                    </div>
                @endif
            </flux:card>
        </div>
    </x-settings.layout>
</section>