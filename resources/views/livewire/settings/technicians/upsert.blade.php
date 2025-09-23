<section>
    <x-settings.layout>
        <x-slot name="title">{{ $isEditing ? __('Edit Technician') : __('Add Technician') }}</x-slot>
        <x-slot name="description">{{ __('Manage technician details and contact information.') }}</x-slot>

        @if (session()->has('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <strong>Success:</strong> {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        @endif

        <form wire:submit="save">
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label>First Name *</flux:label>
                        <flux:input 
                            wire:model="first_name" 
                            placeholder="e.g. John"
                            :error="$errors->first('first_name')"
                        />
                        <flux:error name="first_name" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Last Name *</flux:label>
                        <flux:input 
                            wire:model="last_name" 
                            placeholder="e.g. Smith"
                            :error="$errors->first('last_name')"
                        />
                        <flux:error name="last_name" />
                    </flux:field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label>Email Address</flux:label>
                        <flux:input 
                            wire:model="email" 
                            type="email" 
                            placeholder="e.g. john.smith@example.com"
                            :error="$errors->first('email')"
                        />
                        <flux:error name="email" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Phone</flux:label>
                        <flux:input 
                            wire:model="phone" 
                            type="tel" 
                            placeholder="e.g. 07700 900123"
                            :error="$errors->first('phone')"
                        />
                        <flux:error name="phone" />
                    </flux:field>
                </div>

                <flux:field>
                    <flux:label>Notes</flux:label>
                    <flux:textarea 
                        wire:model="notes" 
                        placeholder="Any additional notes about the technician..."
                        rows="4"
                        :error="$errors->first('notes')"
                    />
                    <flux:error name="notes" />
                    <flux:description>Internal notes visible only to your team</flux:description>
                </flux:field>

                <flux:field>
                    <flux:checkbox wire:model="active">Active</flux:checkbox>
                    <flux:description>Active technicians can be assigned to jobs</flux:description>
                </flux:field>

                <div class="flex gap-2">
                    <flux:spacer />
                    
                    <flux:button 
                        href="{{ route('settings.technicians.index') }}" 
                        wire:navigate 
                        variant="ghost"
                    >
                        Cancel
                    </flux:button>
                    
                    <flux:button type="submit" variant="primary">
                        {{ $isEditing ? 'Update Technician' : 'Add Technician' }}
                    </flux:button>
                </div>
            </div>
        </form>
    </x-settings.layout>
</section>