<div class="space-y-6">
    <flux:card class="p-6 space-y-6">
        <flux:heading size="xl">{{ $isEditing ? 'Edit Job' : 'Create Job' }}</flux:heading>

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Vehicle Registration *</flux:label>
                    <flux:input wire:model.lazy="vehicle_registration" x-on:blur="$wire.findVehicleByRegistration()" placeholder="e.g. AB12 CDE" class="uppercase" />
                    <flux:error name="vehicle_registration" />
                </flux:field>
                <flux:field>
                    <flux:label>Title *</flux:label>
                    <flux:input wire:model="title" :error="$errors->first('title')" placeholder="e.g. Annual Service" />
                    <flux:error name="title" />
                </flux:field>
            </div>

            <flux:field>
                <flux:label>Description</flux:label>
                <flux:textarea wire:model="description" rows="4" />
            </flux:field>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <flux:field>
                    <flux:label>Status *</flux:label>
                    <flux:select wire:model="status">
                        <flux:select.option value="scheduled">Scheduled</flux:select.option>
                        <flux:select.option value="in_progress">In progress</flux:select.option>
                        <flux:select.option value="completed">Completed</flux:select.option>
                        <flux:select.option value="cancelled">Cancelled</flux:select.option>
                    </flux:select>
                </flux:field>
                <flux:field>
                    <flux:label>Start</flux:label>
                    <flux:input type="datetime-local" wire:model="start_at" />
                </flux:field>
                <flux:field>
                    <flux:label>End</flux:label>
                    <flux:input type="datetime-local" wire:model="end_at" />
                </flux:field>
            </div>

            <flux:field>
                <flux:label>Technicians</flux:label>
                <div class="space-y-2">
                    @foreach($techniciansList as $tech)
                        <div class="flex items-center gap-3">
                            <input type="checkbox" wire:model="technician_ids" value="{{ $tech->id }}" class="rounded border-zinc-300" />
                            <span class="w-48">{{ $tech->full_name }}</span>
                            <flux:input wire:model="technician_roles.{{ $tech->id }}" placeholder="Role (optional)" class="flex-1" />
                        </div>
                    @endforeach
                </div>
            </flux:field>

            <div class="flex gap-2">
                <flux:spacer />
                <flux:button href="{{ route('workshop.jobs.index') }}" wire:navigate variant="ghost">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Job</flux:button>
            </div>
        </form>
    </flux:card>
</div>
