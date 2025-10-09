<div class="space-y-6">
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <strong>Success:</strong> {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Error:</strong> {{ session('error') }}
        </div>
    @endif

    {{-- Removed debug info - issue solved! --}}
    
    {{-- Page Header --}}
    <flux:card class="p-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <flux:heading size="xl">Customers</flux:heading>
                <flux:subheading>Manage your garage customers and their vehicles</flux:subheading>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                {{-- Search Input --}}
                <div class="relative">
                    <flux:input 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search customers..." 
                        class="w-full sm:w-64"
                        size="sm"
                        icon="magnifying-glass"
                    />
                </div>
                
                {{-- Add Customer Button --}}
                <flux:button 
                    wire:click="openCreateModal" 
                    variant="primary" 
                    icon="plus"
                    size="sm"
                >
                    Add Customer
                </flux:button>
            </div>
        </div>
        
        {{-- Filters Row --}}
        <div class="flex flex-col sm:flex-row gap-4 mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
            {{-- Filter Dropdown --}}
            <flux:select 
                wire:model.live="filter" 
                size="sm" 
                placeholder="Filter customers"
                class="w-full sm:w-48"
            >
                <flux:select.option value="all">All Customers</flux:select.option>
                <flux:select.option value="active">Active</flux:select.option>
                <flux:select.option value="deleted">Deleted</flux:select.option>
            </flux:select>
            
            {{-- Sort Dropdown --}}
            <flux:select 
                wire:model.live="sortBy" 
                size="sm" 
                placeholder="Sort by"
                class="w-full sm:w-48"
            >
                <flux:select.option value="name">Last Name</flux:select.option>
                <flux:select.option value="first_name">First Name</flux:select.option>
                <flux:select.option value="updated_at">Last Updated</flux:select.option>
            </flux:select>
            
        </div>
    </flux:card>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <flux:card class="p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900">
                    <flux:icon.users class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Customers</div>
                    <div class="text-2xl font-bold">{{ $customers->total() ?? 0 }}</div>
                </div>
            </div>
        </flux:card>
        
        <flux:card class="p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900">
                    <flux:icon.check-circle class="w-6 h-6 text-green-600 dark:text-green-400" />
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Active Customers</div>
                    <div class="text-2xl font-bold">{{ $customers->where('deleted_at', null)->count() }}</div>
                </div>
            </div>
        </flux:card>
        
        <flux:card class="p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900">
                    <flux:icon.truck class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">With Vehicles</div>
                    <div class="text-2xl font-bold">{{ $customers->where('current_vehicles_count', '>', 0)->count() }}</div>
                </div>
            </div>
        </flux:card>
        
        <flux:card class="p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-amber-100 dark:bg-amber-900">
                    <flux:icon.star class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">VIP Customers</div>
                    <div class="text-2xl font-bold">{{ $customers->filter(fn($c) => in_array('VIP', $c->tags ?? []))->count() }}</div>
                </div>
            </div>
        </flux:card>
    </div>

    {{-- Customers Table --}}
    <flux:card>
        @if($customers->count() > 0)
            <div class="overflow-x-auto">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortBy === 'name' ? $sortDirection : null" wire:click="setSortBy('name')">Name</flux:table.column>
                        <flux:table.column>Contact</flux:table.column>
                        <flux:table.column>Vehicles</flux:table.column>
                        <flux:table.column>Tags</flux:table.column>
                        <flux:table.column sortable :sorted="$sortBy === 'updated_at'" :direction="$sortBy === 'updated_at' ? $sortDirection : null" wire:click="setSortBy('updated_at')">Last Updated</flux:table.column>
                        <flux:table.column>Actions</flux:table.column>
                    </flux:table.columns>
                    
                    <flux:table.rows>
                        @foreach($customers as $customer)
                            <flux:table.row class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                {{-- Name Column --}}
                                <flux:table.cell class="font-medium">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ substr($customer->first_name, 0, 1) }}{{ substr($customer->last_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-zinc-900 dark:text-zinc-100">
                                                {{ $customer->full_name }}
                                            </div>
                                        </div>
                                    </div>
                                </flux:table.cell>
                                
                                {{-- Contact Column --}}
                                <flux:table.cell>
                                    <div class="space-y-1">
                                        @if($customer->email)
                                            <div class="flex items-center text-sm">
                                                <flux:icon.at-symbol class="w-4 h-4 text-zinc-400 mr-2" />
                                                <a href="mailto:{{ $customer->email }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                    {{ $customer->email }}
                                                </a>
                                            </div>
                                        @endif
                                        @if($customer->phone)
                                            <div class="flex items-center text-sm">
                                                <flux:icon.phone class="w-4 h-4 text-zinc-400 mr-2" />
                                                <a href="tel:{{ $customer->phone }}" class="text-zinc-600 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100">
                                                    {{ $customer->formatted_phone }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </flux:table.cell>
                                
                                {{-- Vehicles Column --}}
                                <flux:table.cell>
                                    @if($customer->currentVehicles->count() > 0)
                                        <div class="space-y-1">
                                            @foreach($customer->currentVehicles->take(2) as $vehicle)
                                                <div class="flex items-center text-sm">
                                                    <flux:icon.truck class="w-4 h-4 text-zinc-400 mr-2" />
                                                    <span class="font-mono text-xs bg-zinc-100 dark:bg-zinc-700 px-2 py-1 rounded">
                                                        {{ $vehicle->registration }}
                                                    </span>
                                                </div>
                                            @endforeach
                                            @if($customer->currentVehicles->count() > 2)
                                                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                                    +{{ $customer->currentVehicles->count() - 2 }} more
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-sm text-zinc-400">No vehicles</span>
                                    @endif
                                </flux:table.cell>
                                
                                {{-- Tags Column --}}
                                <flux:table.cell>
                                    @if($customer->tags && count($customer->tags) > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($customer->tags, 0, 2) as $tag)
                                                <flux:badge size="sm" :color="$this->getTagColor($tag)">
                                                    {{ $tag }}
                                                </flux:badge>
                                            @endforeach
                                            @if(count($customer->tags) > 2)
                                                <flux:badge size="sm" color="zinc">
                                                    +{{ count($customer->tags) - 2 }}
                                                </flux:badge>
                                            @endif
                                        </div>
                                    @endif
                                </flux:table.cell>
                                
                                {{-- Last Updated Column --}}
                                <flux:table.cell class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $customer->updated_at->diffForHumans() }}
                                </flux:table.cell>
                                
                                {{-- Actions Column --}}
                                <flux:table.cell>
                                    <div class="flex items-center justify-end">
                                        <flux:button
                                            wire:navigate
                                            href="{{ route('customers.show', $customer) }}"
                                            size="sm"
                                            class="opacity-0 group-hover:opacity-100 transition-opacity !bg-zinc-900 !text-white hover:!bg-zinc-800 !border-zinc-900"
                                            icon="eye"
                                        >
                                            View
                                        </flux:button>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </div>
            
            {{-- Pagination --}}
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $customers->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <flux:icon.users class="mx-auto w-16 h-16 text-zinc-400 mb-4" />
                
                @if($search)
                    <flux:heading size="lg" class="mb-2">No customers found</flux:heading>
                    <flux:subheading class="mb-4">
                        No customers match your search for "{{ $search }}". Try adjusting your search terms or filters.
                    </flux:subheading>
                    <flux:button 
                        wire:click="clearSearch" 
                        variant="ghost"
                    >
                        Clear Search
                    </flux:button>
                @else
                    <flux:heading size="lg" class="mb-2">Add your first customer</flux:heading>
                    <flux:subheading class="mb-4">
                        Start building your customer database by adding customer information and linking their vehicles.
                    </flux:subheading>
                    <flux:button 
                        wire:click="openCreateModal" 
                        variant="primary"
                        icon="plus"
                    >
                        Add Customer
                    </flux:button>
                @endif
            </div>
        @endif
    </flux:card>

    {{-- Customer Upsert Modal --}}
    @livewire('customers.upsert')

    {{-- Delete Confirmation Modal --}}
    @if($showDeleteModal)
        <flux:modal name="confirm-delete" wire:model="showDeleteModal" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Confirm Deletion</flux:heading>
                    <flux:text class="mt-2">
                        <p>Are you sure you want to delete <strong>{{ $customerToDelete?->full_name }}</strong>? 
                        This action can be undone by restoring the customer from the deleted filter.</p>
                    </flux:text>
                </div>
                
                @if($customerToDelete?->currentVehicles?->count() > 0)
                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                        <div class="flex">
                            <flux:icon.exclamation-triangle class="w-5 h-5 text-amber-500 mr-2 mt-0.5" />
                            <div>
                                <p class="text-sm text-amber-800 dark:text-amber-200">
                                    This customer has {{ $customerToDelete->currentVehicles->count() }} active vehicle(s). 
                                    The vehicle relationships will be preserved.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:button wire:click="cancelDelete" variant="ghost">Cancel</flux:button>
                    <flux:button wire:click="delete" variant="danger">Delete Customer</flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
