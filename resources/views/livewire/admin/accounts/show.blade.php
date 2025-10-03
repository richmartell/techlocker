<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Account Details</flux:heading>
        <flux:button href="{{ route('admin.accounts.index') }}" variant="ghost">
            Back to Accounts
        </flux:button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Account Information -->
        <div class="lg:col-span-2">
            <flux:card>
                <div class="p-6">
                    <flux:heading size="lg" class="mb-4">Account Information</flux:heading>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Company Name</label>
                            <p class="text-zinc-900 dark:text-white">{{ $account->company_name }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Email</label>
                            <p class="text-zinc-900 dark:text-white">{{ $account->company_email }}</p>
                        </div>

                        @if($account->company_phone)
                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Phone</label>
                            <p class="text-zinc-900 dark:text-white">{{ $account->company_phone }}</p>
                        </div>
                        @endif

                        @if($account->registered_address)
                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Address</label>
                            <p class="text-zinc-900 dark:text-white">
                                {{ $account->registered_address }}<br>
                                @if($account->town){{ $account->town }}, @endif
                                @if($account->county){{ $account->county }}<br>@endif
                                @if($account->post_code){{ $account->post_code }}@endif
                            </p>
                        </div>
                        @endif

                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Created</label>
                            <p class="text-zinc-900 dark:text-white">{{ $account->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Status</label>
                            <p>
                                @if($account->is_active)
                                    <flux:badge color="green">Active</flux:badge>
                                @else
                                    <flux:badge color="red">Inactive</flux:badge>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Statistics -->
        <div>
            <flux:card class="mb-6">
                <div class="p-6">
                    <flux:heading size="lg" class="mb-4">Statistics</flux:heading>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Users</span>
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $account->users->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Customers</span>
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $account->customers->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Vehicles</span>
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $account->vehicles->count() }}</span>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Plan & Trial Information -->
            <flux:card>
                <div class="p-6">
                    <flux:heading size="lg" class="mb-4">Plan & Trial</flux:heading>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Current Plan</label>
                            <p class="mt-1">
                                @if($account->plan)
                                    <flux:badge color="blue">{{ $account->plan->name }}</flux:badge>
                                @else
                                    <span class="text-zinc-500 dark:text-zinc-400">No plan</span>
                                @endif
                            </p>
                        </div>

                        @if($account->status)
                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Account Status</label>
                            <p class="mt-1">
                                <flux:badge color="{{ $account->status_color }}">{{ $account->status_label }}</flux:badge>
                            </p>
                        </div>

                        @if($account->trial_started_at)
                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Trial Started</label>
                            <p class="text-zinc-900 dark:text-white text-sm">{{ $account->trial_started_at->format('M d, Y') }}</p>
                        </div>
                        @endif

                        @if($account->trial_ends_at)
                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Trial Ends</label>
                            <p class="text-zinc-900 dark:text-white text-sm">
                                {{ $account->trial_ends_at->format('M d, Y') }}
                                @if($account->isOnTrial())
                                    <span class="text-zinc-600 dark:text-zinc-400">({{ $account->trialDaysRemaining() }} days left)</span>
                                @endif
                            </p>
                        </div>
                        @endif
                        @endif

                        @if($account->subscribed_at)
                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Subscribed Since</label>
                            <p class="text-zinc-900 dark:text-white text-sm">{{ $account->subscribed_at->format('M d, Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </flux:card>
        </div>
    </div>

    <!-- Users Table -->
    <flux:card>
        <div class="p-6">
            <flux:heading size="lg" class="mb-4">Users ({{ $account->users->count() }})</flux:heading>
            
            @if($account->users->count() > 0)
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Name</flux:table.column>
                        <flux:table.column>Email</flux:table.column>
                        <flux:table.column>Role</flux:table.column>
                        <flux:table.column>Joined</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column>Actions</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach($account->users as $user)
                            <flux:table.row :key="$user->id">
                                <flux:table.cell>{{ $user->name }}</flux:table.cell>
                                <flux:table.cell>{{ $user->email }}</flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge>{{ $user->role ?? 'User' }}</flux:badge>
                                </flux:table.cell>
                                <flux:table.cell>
                                    <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $user->created_at->format('M d, Y') }}</span>
                                </flux:table.cell>
                                <flux:table.cell>
                                    @if($user->is_active)
                                        <flux:badge color="green">Active</flux:badge>
                                    @else
                                        <flux:badge color="red">Inactive</flux:badge>
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>
                                    <flux:button 
                                        size="sm" 
                                        variant="ghost"
                                        href="{{ route('dvla-lookup') }}"
                                        target="_blank"
                                    >
                                        DVLA Lookup
                                    </flux:button>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            @else
                <p class="text-zinc-500 dark:text-zinc-400 text-center py-8">No users found for this account.</p>
            @endif
        </div>
    </flux:card>
</div>
