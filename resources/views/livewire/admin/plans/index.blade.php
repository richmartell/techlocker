<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Plans Management</flux:heading>
        <flux:button href="{{ route('admin.plans.create') }}" variant="primary" wire:navigate>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
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
                            <span class="text-lg font-bold text-zinc-900 dark:text-white">
                                {{ $plan->getDisplayPrice() }}
                            </span>
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

                        <div class="flex justify-between items-center py-2 border-t border-zinc-200 dark:border-zinc-700">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Stripe Integration</span>
                            <div class="flex items-center gap-1">
                                @if($plan->stripe_monthly_price_id || $plan->stripe_yearly_price_id)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600 dark:text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-medium text-green-700 dark:text-green-300">
                                        Connected
                                    </span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-600 dark:text-orange-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-medium text-orange-700 dark:text-orange-300">
                                        Not Set
                                    </span>
                                @endif
                            </div>
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
                <flux:button href="{{ route('admin.plans.create') }}" variant="primary" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create Your First Plan
                </flux:button>
            </div>
        </flux:card>
    @endif
</div>
