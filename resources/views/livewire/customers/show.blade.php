<div class="space-y-6">
    {{-- Page Header --}}
    <flux:card class="p-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                {{-- Customer Avatar --}}
                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl">
                    {{ substr($customer->first_name, 0, 1) }}{{ substr($customer->last_name, 0, 1) }}
                </div>
                
                <div>
                    <flux:heading size="xl">{{ $customer->full_name }}</flux:heading>
                    <div class="flex flex-wrap items-center gap-4 mt-2">
                        @if($customer->email)
                            <div class="flex items-center text-sm text-zinc-600 dark:text-zinc-300">
                                <flux:icon.at-symbol class="w-4 h-4 mr-1" />
                                <a href="mailto:{{ $customer->email }}" class="hover:underline">{{ $customer->email }}</a>
                            </div>
                        @endif
                        @if($customer->phone)
                            <div class="flex items-center text-sm text-zinc-600 dark:text-zinc-300">
                                <flux:icon.phone class="w-4 h-4 mr-1" />
                                <a href="tel:{{ $customer->phone }}" class="hover:underline">{{ $customer->formatted_phone }}</a>
                            </div>
                        @endif
                        @if($customer->last_contact_at)
                            <div class="flex items-center text-sm text-zinc-500 dark:text-zinc-400">
                                <flux:icon.clock class="w-4 h-4 mr-1" />
                                Last contact: {{ $customer->last_contact_at->diffForHumans() }}
                            </div>
                        @endif
                    </div>
                    
                    {{-- Tags --}}
                    @if($customer->tags && count($customer->tags) > 0)
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach($customer->tags as $tag)
                                <flux:badge size="sm" color="blue">{{ $tag }}</flux:badge>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <flux:button wire:click="updateLastContact" variant="ghost" icon="clock" size="sm">
                    Update Contact
                </flux:button>
                <flux:button wire:click="openEditModal" variant="primary" icon="pencil" size="sm">
                    Edit Customer
                </flux:button>
            </div>
        </div>
    </flux:card>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <flux:card class="p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900">
                    <flux:icon.truck class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Current Vehicles</div>
                    <div class="text-2xl font-bold">{{ $customer->currentVehicles->count() }}</div>
                </div>
            </div>
        </flux:card>
        
        <flux:card class="p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900">
                    <flux:icon.calendar class="w-6 h-6 text-green-600 dark:text-green-400" />
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Customer Since</div>
                    <div class="text-lg font-semibold">{{ $customer->created_at->format('M Y') }}</div>
                </div>
            </div>
        </flux:card>
        
        <flux:card class="p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900">
                    <flux:icon.chart-bar class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Vehicles</div>
                    <div class="text-2xl font-bold">{{ $customer->vehicles->count() }}</div>
                </div>
            </div>
        </flux:card>
    </div>

    {{-- Tabs Navigation --}}
    <flux:card>
        <flux:tabs wire:model="activeTab" class="border-b border-zinc-200 dark:border-zinc-700">
            <flux:tab name="profile" icon="user">Profile</flux:tab>
            <flux:tab name="vehicles" icon="truck">Vehicles</flux:tab>
            <flux:tab name="timeline" icon="clock">Timeline</flux:tab>
        </flux:tabs>

        <div class="p-6">
            {{-- Profile Tab --}}
            @if($activeTab === 'profile')
                <div class="space-y-6">
                    {{-- Basic Information --}}
                    <div>
                        <flux:heading size="lg" class="mb-4">Customer Information</flux:heading>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">First Name</label>
                                    <div class="text-zinc-900 dark:text-zinc-100">{{ $customer->first_name }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Last Name</label>
                                    <div class="text-zinc-900 dark:text-zinc-100">{{ $customer->last_name }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Email</label>
                                    <div class="text-zinc-900 dark:text-zinc-100">
                                        @if($customer->email)
                                            <a href="mailto:{{ $customer->email }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                {{ $customer->email }}
                                            </a>
                                        @else
                                            <span class="text-zinc-400">Not provided</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Phone</label>
                                    <div class="text-zinc-900 dark:text-zinc-100">
                                        @if($customer->phone)
                                            <a href="tel:{{ $customer->phone }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                {{ $customer->formatted_phone }}
                                            </a>
                                        @else
                                            <span class="text-zinc-400">Not provided</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Source</label>
                                    <div class="text-zinc-900 dark:text-zinc-100">
                                        {{ $customer->source ? ucfirst(str_replace('-', ' ', $customer->source)) : 'Not specified' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Last Contact</label>
                                    <div class="text-zinc-900 dark:text-zinc-100">
                                        {{ $customer->last_contact_at ? $customer->last_contact_at->format('M d, Y \a\t g:i A') : 'Never' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Notes Section --}}
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <flux:heading size="lg">Notes</flux:heading>
                            @if($notesChanged)
                                <flux:button wire:click="updateNotes" variant="primary" size="sm" icon="check">
                                    Save Changes
                                </flux:button>
                            @endif
                        </div>
                        <flux:textarea 
                            wire:model.live="notes" 
                            placeholder="Add notes about this customer..."
                            rows="6"
                            class="w-full"
                        />
                        @if($notesChanged)
                            <div class="text-sm text-amber-600 dark:text-amber-400 mt-2">
                                You have unsaved changes
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Vehicles Tab --}}
            @if($activeTab === 'vehicles')
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <flux:heading size="lg">Linked Vehicles</flux:heading>
                        <flux:button wire:click="openLinkVehicleModal" variant="primary" icon="plus" size="sm">
                            Link Vehicle
                        </flux:button>
                    </div>

                    @if($customer->currentVehicles->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($customer->currentVehicles as $vehicle)
                                <flux:card class="p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <flux:icon.truck class="w-5 h-5 text-zinc-400 mr-2" />
                                                <span class="font-mono font-bold text-lg">{{ $vehicle->registration }}</span>
                                            </div>
                                            
                                            @if($vehicle->name && $vehicle->name !== $vehicle->registration)
                                                <div class="text-sm text-zinc-600 dark:text-zinc-300 mb-2">
                                                    {{ $vehicle->name }}
                                                </div>
                                            @endif
                                            
                                            <div class="space-y-1 text-sm">
                                                @if($vehicle->year_of_manufacture)
                                                    <div class="text-zinc-500 dark:text-zinc-400">
                                                        Year: {{ $vehicle->year_of_manufacture }}
                                                    </div>
                                                @endif
                                                @if($vehicle->fuel_type)
                                                    <div class="text-zinc-500 dark:text-zinc-400">
                                                        Fuel: {{ $vehicle->fuel_type }}
                                                    </div>
                                                @endif
                                                
                                                {{-- Relationship info --}}
                                                @php
                                                    $pivot = $vehicle->pivot;
                                                @endphp
                                                <div class="pt-2 border-t border-zinc-200 dark:border-zinc-700">
                                                    <flux:badge size="sm" color="blue">
                                                        {{ ucfirst($pivot->relationship) }}
                                                    </flux:badge>
                                                    @if($pivot->owned_from)
                                                        <div class="text-xs text-zinc-400 mt-1">
                                                            Since: {{ \Carbon\Carbon::parse($pivot->owned_from)->format('M Y') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <flux:dropdown>
                                            <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" />
                                            <flux:menu>
                                                <flux:menu.item 
                                                    wire:navigate 
                                                    href="{{ route('vehicle-details', $vehicle->registration) }}"
                                                    icon="eye"
                                                >
                                                    View Details
                                                </flux:menu.item>
                                                <flux:menu.separator />
                                                <flux:menu.item 
                                                    wire:click="confirmUnlinkVehicle({{ $vehicle->id }})"
                                                    icon="link-slash"
                                                    class="text-red-600"
                                                >
                                                    Unlink Vehicle
                                                </flux:menu.item>
                                            </flux:menu>
                                        </flux:dropdown>
                                    </div>
                                </flux:card>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <flux:icon.truck class="mx-auto w-16 h-16 text-zinc-400 mb-4" />
                            <flux:heading size="lg" class="mb-2">No vehicles linked</flux:heading>
                            <flux:subheading class="mb-4">
                                Link vehicles to this customer to track their automotive history and service records.
                            </flux:subheading>
                            <flux:button wire:click="openLinkVehicleModal" variant="primary" icon="plus">
                                Link First Vehicle
                            </flux:button>
                        </div>
                    @endif

                    {{-- Vehicle History --}}
                    @if($customer->vehicles->where('pivot.owned_to', '!=', null)->count() > 0)
                        <div class="mt-8">
                            <flux:heading size="lg" class="mb-4">Vehicle History</flux:heading>
                            <div class="space-y-3">
                                @foreach($customer->vehicles->where('pivot.owned_to', '!=', null) as $vehicle)
                                    <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                                        <div class="flex items-center">
                                            <flux:icon.truck class="w-4 h-4 text-zinc-400 mr-3" />
                                            <div>
                                                <span class="font-mono font-semibold">{{ $vehicle->registration }}</span>
                                                <span class="text-sm text-zinc-500 dark:text-zinc-400 ml-2">
                                                    ({{ ucfirst($vehicle->pivot->relationship) }})
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ \Carbon\Carbon::parse($vehicle->pivot->owned_from)->format('M Y') }} - 
                                            {{ \Carbon\Carbon::parse($vehicle->pivot->owned_to)->format('M Y') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Timeline Tab --}}
            @if($activeTab === 'timeline')
                <div class="space-y-6">
                    <flux:heading size="lg">Customer Timeline</flux:heading>
                    
                    <div class="space-y-4">
                        {{-- Created Event --}}
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                <flux:icon.plus class="w-4 h-4 text-green-600 dark:text-green-400" />
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-zinc-900 dark:text-zinc-100">Customer created</div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $customer->created_at->format('M d, Y \a\t g:i A') }}
                                    ({{ $customer->created_at->diffForHumans() }})
                                </div>
                            </div>
                        </div>

                        {{-- Vehicle Links --}}
                        @foreach($customer->vehicles->sortBy('pivot.created_at') as $vehicle)
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <flux:icon.truck class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-zinc-900 dark:text-zinc-100">
                                        Vehicle {{ $vehicle->registration }} linked
                                        @if($vehicle->pivot->owned_to)
                                            <span class="text-red-600 dark:text-red-400">(ended)</span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        Relationship: {{ ucfirst($vehicle->pivot->relationship) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($vehicle->pivot->created_at)->format('M d, Y \a\t g:i A') }}
                                        ({{ \Carbon\Carbon::parse($vehicle->pivot->created_at)->diffForHumans() }})
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Last Updated Event --}}
                        @if($customer->updated_at->gt($customer->created_at))
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-amber-100 dark:bg-amber-900 rounded-full flex items-center justify-center">
                                    <flux:icon.pencil class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-zinc-900 dark:text-zinc-100">Customer information updated</div>
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $customer->updated_at->format('M d, Y \a\t g:i A') }}
                                        ({{ $customer->updated_at->diffForHumans() }})
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </flux:card>

    {{-- Link Vehicle Modal --}}
    @if($showLinkVehicleModal)
        <flux:modal name="link-vehicle" wire:model="showLinkVehicleModal" class="w-full max-w-lg">
            <form wire:submit="linkVehicle">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Link Vehicle</flux:heading>
                        <flux:text class="mt-2">Connect a vehicle to this customer</flux:text>
                    </div>
                <div class="p-6 space-y-4">
                    <flux:field>
                        <flux:label>Vehicle Registration *</flux:label>
                        <flux:input 
                            wire:model="vehicleRegistration" 
                            placeholder="e.g. AB12 CDE"
                            class="uppercase"
                            :error="$errors->first('vehicleRegistration')"
                        />
                        <flux:error name="vehicleRegistration" />
                        <flux:description>If the vehicle doesn't exist, it will be created</flux:description>
                    </flux:field>

                    <flux:field>
                        <flux:label>Relationship *</flux:label>
                        <flux:select wire:model="vehicleRelationship" :error="$errors->first('vehicleRelationship')">
                            <flux:select.option value="owner">Owner</flux:select.option>
                            <flux:select.option value="driver">Driver</flux:select.option>
                            <flux:select.option value="billing_contact">Billing Contact</flux:select.option>
                        </flux:select>
                        <flux:error name="vehicleRelationship" />
                    </flux:field>

                    <div class="grid grid-cols-2 gap-4">
                        <flux:field>
                            <flux:label>Owned From</flux:label>
                            <flux:input 
                                wire:model="ownedFrom" 
                                type="date"
                                :error="$errors->first('ownedFrom')"
                            />
                            <flux:error name="ownedFrom" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Owned To</flux:label>
                            <flux:input 
                                wire:model="ownedTo" 
                                type="date"
                                :error="$errors->first('ownedTo')"
                            />
                            <flux:error name="ownedTo" />
                            <flux:description>Leave empty for current ownership</flux:description>
                        </flux:field>
                    </div>
                </div>

                    <div class="flex gap-2">
                        <flux:spacer />
                        <flux:button wire:click="closeLinkVehicleModal" variant="ghost">Cancel</flux:button>
                        <flux:button type="submit" variant="primary">Link Vehicle</flux:button>
                    </div>
                </div>
            </form>
        </flux:modal>
    @endif

    {{-- Unlink Confirmation Modal --}}
    @if($showUnlinkConfirmModal)
        <flux:modal name="unlink-vehicle" wire:model="showUnlinkConfirmModal" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Confirm Unlink</flux:heading>
                    <flux:text class="mt-2">
                        <p>Are you sure you want to unlink <strong>{{ $vehicleToUnlink?->registration }}</strong> from {{ $customer->full_name }}?</p>
                        <p class="text-sm mt-2">This will end the current ownership relationship. The vehicle and customer records will remain, but they will no longer be linked.</p>
                    </flux:text>
                </div>
                
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:button wire:click="closeUnlinkConfirmModal" variant="ghost">Cancel</flux:button>
                    <flux:button wire:click="unlinkVehicle" variant="danger">Unlink Vehicle</flux:button>
                </div>
            </div>
        </flux:modal>
    @endif

    {{-- Edit Customer Modal --}}
    @if($showEditModal)
        <livewire:customers.upsert :customer="$customer" wire:key="edit-customer-{{ $customer->id }}" />
    @endif
</div>
