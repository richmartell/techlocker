<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">My Customers</flux:heading>
        <flux:button href="{{ route('reseller.customers.create') }}" variant="primary" icon="plus">
            Create Trial
        </flux:button>
    </div>

    <!-- Search -->
    <flux:card class="mb-6">
        <div class="p-6">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search customers..."
                label="Search"
            />
        </div>
    </flux:card>

    <!-- Customers Table -->
    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Company Name</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Users</flux:table.column>
                <flux:table.column>Plan</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Created</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($this->customers as $customer)
                    <flux:table.row :key="$customer->id">
                        <flux:table.cell>
                            <div class="font-medium text-zinc-900 dark:text-white">{{ $customer->company_name }}</div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $customer->company_email }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge>{{ $customer->users->count() }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($customer->plan)
                                <flux:badge color="blue">{{ $customer->plan->name }}</flux:badge>
                            @else
                                <span class="text-zinc-500 dark:text-zinc-400">No plan</span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($customer->status)
                                <div>
                                    <flux:badge color="{{ $customer->status_color }}">{{ $customer->status_label }}</flux:badge>
                                    @if($customer->isOnTrial())
                                        <div class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                                            {{ $customer->trialDaysRemaining() }} days left
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span class="text-zinc-500 dark:text-zinc-400">No status</span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $customer->created_at->format('M d, Y') }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:button 
                                size="sm" 
                                variant="primary"
                                href="{{ route('reseller.customers.show', $customer) }}"
                                wire:navigate
                            >
                                View
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="7" class="text-center text-zinc-500 dark:text-zinc-400 py-8">
                            <div class="flex flex-col items-center gap-4">
                                <svg class="w-16 h-16 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-lg font-medium mb-1">No customers yet</p>
                                    <p class="text-sm">Contact your administrator to have customer accounts assigned to you.</p>
                                </div>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if($this->customers->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $this->customers->links() }}
            </div>
        @endif
    </flux:card>

</div>
