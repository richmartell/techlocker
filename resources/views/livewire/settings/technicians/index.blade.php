<section>
    <x-settings.layout>
        <x-slot name="title">{{ __('Technicians') }}</x-slot>
        <x-slot name="description">{{ __('Manage your workshop technicians') }}</x-slot>

        <div class="mb-4 flex items-center justify-between">
            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Search technicians..." />
            <flux:button href="{{ route('settings.technicians.create') }}" wire:navigate icon="plus" variant="primary">Add Technician</flux:button>
        </div>

        <flux:card>
            @if($technicians->count())
                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($technicians as $tech)
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <div class="font-medium">{{ $tech->full_name }}</div>
                                <div class="text-sm text-zinc-500">{{ $tech->email }} {{ $tech->phone ? ' · ' . $tech->phone : '' }}</div>
                            </div>
                            <div class="flex items-center gap-3">
                                <flux:switch :checked="$tech->active" wire:click="toggleActive('{{ $tech->id }}')">Active</flux:switch>
                                <flux:button href="{{ route('settings.technicians.show', $tech) }}" wire:navigate size="sm" variant="ghost" icon="eye">View</flux:button>
                                <flux:button href="{{ route('settings.technicians.edit', $tech) }}" wire:navigate size="sm" variant="ghost" icon="pencil">Edit</flux:button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="p-4">{{ $technicians->links() }}</div>
            @else
                <div class="p-8 text-center">
                    <flux:heading size="lg">No technicians</flux:heading>
                    <flux:text>Add your first technician to start assigning jobs.</flux:text>
                </div>
            @endif
        </flux:card>
    </x-settings.layout>
</section>
