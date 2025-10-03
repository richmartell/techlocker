<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Plans Management</flux:heading>
        <flux:button href="{{ route('admin.plans.create') }}" variant="primary" icon="plus">
            Create Plan
        </flux:button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($this->plans as $plan)
            <flux:card>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <flux:heading size="lg" class="mb-1">{{ $plan->name }}</flux:heading>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $plan->accounts_count }} {{ Str::plural('account', $plan->accounts_count) }}
                            </p>
                        </div>
                        <div>
                            @if($plan->is_active)
                                <flux:badge color="green">Active</flux:badge>
                            @else
                                <flux:badge color="red">Inactive</flux:badge>
                            @endif
                        </div>
                    </div>

                    @if($plan->description)
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">{{ $plan->description }}</p>
                    @endif

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between items-center py-2 border-t border-zinc-200 dark:border-zinc-700">
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">Price</span>
                            <span class="text-lg font-bold text-zinc-900 dark:text-white">£{{ number_format($plan->price, 2) }}/mo</span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-t border-zinc-200 dark:border-zinc-700">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Max Users</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                {{ $plan->max_users ? number_format($plan->max_users) : 'Unlimited' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-t border-zinc-200 dark:border-zinc-700">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Max Customers</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                {{ $plan->max_customers ? number_format($plan->max_customers) : 'Unlimited' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-t border-zinc-200 dark:border-zinc-700">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Max Searches</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                {{ $plan->max_searches ? number_format($plan->max_searches) : 'Unlimited' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <flux:button href="{{ route('admin.plans.edit', $plan) }}" variant="ghost" size="sm" class="flex-1">
                            Edit
                        </flux:button>
                        <flux:button 
                            wire:click="toggleStatus({{ $plan->id }})"
                            variant="ghost" 
                            size="sm"
                            class="flex-1"
                        >
                            {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                        </flux:button>
                    </div>
                </div>
            </flux:card>
        @endforeach
    </div>

    @if($this->plans->isEmpty())
        <flux:card>
            <div class="p-12 text-center">
                <p class="text-zinc-500 dark:text-zinc-400 mb-4">No plans found.</p>
                <flux:button href="{{ route('admin.plans.create') }}" variant="primary" icon="plus">
                    Create Your First Plan
                </flux:button>
            </div>
        </flux:card>
    @endif
</div>
