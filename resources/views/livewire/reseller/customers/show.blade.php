<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl">{{ $account->company_name }}</flux:heading>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Manage customer account and subscription</p>
        </div>
        <flux:button href="{{ route('reseller.customers') }}" variant="ghost" icon="arrow-left" wire:navigate>
            Back to Customers
        </flux:button>
    </div>

    @if (session('success'))
        <flux:card class="mb-6">
            <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-green-800 dark:text-green-200">{{ session('success') }}</p>
            </div>
        </flux:card>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Account Status -->
        <flux:card>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <flux:heading size="lg">Account Status</flux:heading>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Status</p>
                        <flux:badge color="{{ $account->status_color }}" size="lg">
                            {{ $account->status_label }}
                        </flux:badge>
                        
                        @if($account->isOnTrial())
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">
                                {{ $account->trialDaysRemaining() }} days remaining
                            </p>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Account Access</p>
                        <div class="flex items-center gap-2">
                            <flux:badge :color="$account->is_active ? 'green' : 'red'" size="lg">
                                {{ $account->is_active ? 'Enabled' : 'Disabled' }}
                            </flux:badge>
                        </div>
                    </div>

                    @if($account->subscribed_at)
                        <div>
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Subscribed Since</p>
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">
                                {{ $account->subscribed_at->format('M d, Y') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </flux:card>

        <!-- Current Plan -->
        <flux:card>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <flux:heading size="lg">Current Plan</flux:heading>
                </div>
                
                <div class="space-y-4">
                    @if($account->plan)
                        <div>
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Plan</p>
                            <p class="text-xl font-bold text-zinc-900 dark:text-white">
                                {{ $account->plan->name }}
                            </p>
                        </div>
                        
                        @if($account->subscription_price)
                            <div>
                                <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Customer Pays (Annual)</p>
                                <p class="text-lg font-bold text-green-600 dark:text-green-400">
                                    £{{ number_format($account->subscription_price, 2) }}
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-500 mt-1">
                                    £{{ number_format($account->subscription_price / 12, 2) }}/month
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Your Profit (Annual)</p>
                                @php
                                    $resellerCost = $reseller->getPriceForPlan($account->plan);
                                    $profit = $account->subscription_price - $resellerCost;
                                @endphp
                                <p class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                    £{{ number_format($profit, 2) }}
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-500 mt-1">
                                    £{{ number_format($profit / 12, 2) }}/month
                                </p>
                            </div>
                        @endif
                    @else
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">No plan assigned</p>
                    @endif
                </div>
            </div>
        </flux:card>

        <!-- Account Details -->
        <flux:card>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <flux:heading size="lg">Account Details</flux:heading>
                </div>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Email</p>
                        <p class="text-sm text-zinc-900 dark:text-white">{{ $account->company_email }}</p>
                    </div>
                    
                    @if($account->company_phone)
                        <div>
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Phone</p>
                            <p class="text-sm text-zinc-900 dark:text-white">{{ $account->company_phone }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Users</p>
                        <p class="text-sm text-zinc-900 dark:text-white">{{ $account->users->count() }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Created</p>
                        <p class="text-sm text-zinc-900 dark:text-white">{{ $account->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </flux:card>
    </div>

    <!-- Actions -->
    <flux:card class="mb-6">
        <div class="p-6">
            <flux:heading size="lg" class="mb-4">Account Actions</flux:heading>
            
            <div class="flex flex-wrap gap-3">
                <flux:button 
                    variant="primary" 
                    icon="credit-card"
                    wire:click="openChangePlanModal"
                >
                    {{ $account->plan ? 'Change Plan' : 'Assign Plan' }}
                </flux:button>
                
                <flux:button 
                    :variant="$account->is_active ? 'ghost' : 'primary'"
                    :icon="$account->is_active ? 'lock-closed' : 'lock-open'"
                    wire:click="toggleAccountAccess"
                    wire:confirm="Are you sure you want to {{ $account->is_active ? 'disable' : 'enable' }} account access?"
                >
                    {{ $account->is_active ? 'Disable Access' : 'Enable Access' }}
                </flux:button>
                
                <flux:button 
                    variant="danger" 
                    icon="trash"
                    wire:click="$set('showDeleteModal', true)"
                >
                    Delete Account
                </flux:button>
            </div>
        </div>
    </flux:card>

    <!-- Change Plan Modal -->
    <flux:modal wire:model="showChangePlanModal" class="max-w-2xl">
        <div class="p-6">
            <flux:heading size="lg" class="mb-4">
                {{ $account->status === 'trial' || $account->status === 'trial_expired' ? 'Activate Account & Assign Plan' : 'Change Plan' }}
            </flux:heading>
            
            <div class="space-y-4">
                <flux:field>
                    <flux:label>Select Annual Plan</flux:label>
                    <flux:select wire:model.live="selectedPlanId">
                        <option value="">Choose a plan...</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="selectedPlanId" />
                </flux:field>
                
                @if($selectedPlanId)
                    @php
                        $selectedPlan = $plans->firstWhere('id', $selectedPlanId);
                        $resellerCost = $reseller->getPriceForPlan($selectedPlan);
                    @endphp
                    
                    <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Your Cost (Annual)</p>
                                <p class="text-xl font-bold text-zinc-900 dark:text-white">
                                    £{{ number_format($resellerCost, 2) }}
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-500 mt-1">
                                    £{{ number_format($resellerCost / 12, 2) }}/month
                                </p>
                            </div>
                            <div class="border-l border-zinc-300 dark:border-zinc-600 pl-4">
                                <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">Suggested Retail (Annual)</p>
                                <p class="text-xl font-bold text-green-600 dark:text-green-400">
                                    £{{ number_format($selectedPlan->price * 12, 2) }}
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-500 mt-1">
                                    £{{ number_format($selectedPlan->price, 2) }}/month
                                </p>
                            </div>
                        </div>
                        
                        <flux:field>
                            <flux:label>Customer's Annual Price (£)</flux:label>
                            <flux:input 
                                type="number" 
                                step="0.01" 
                                min="0"
                                wire:model.live="customerPrice"
                                placeholder="Enter annual price"
                            />
                            <flux:error name="customerPrice" />
                            <flux:description>
                                The annual amount you will charge this customer
                            </flux:description>
                        </flux:field>
                        
                        @if($customerPrice && $customerPrice > 0)
                            <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 rounded border border-green-200 dark:border-green-800">
                                <p class="text-sm font-medium text-green-900 dark:text-green-200">
                                    Your Annual Profit: £{{ number_format(max(0, $customerPrice - $resellerCost), 2) }}
                                </p>
                                <p class="text-xs text-green-700 dark:text-green-300 mt-1">
                                    £{{ number_format(max(0, ($customerPrice - $resellerCost) / 12), 2) }}/month
                                </p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            
            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button variant="ghost" wire:click="$set('showChangePlanModal', false)">
                    Cancel
                </flux:button>
                <flux:button 
                    variant="primary" 
                    wire:click="changePlan"
                    :disabled="!$selectedPlanId || !$customerPrice"
                >
                    {{ $account->status === 'trial' || $account->status === 'trial_expired' ? 'Activate & Save' : 'Save Changes' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <!-- Delete Confirmation Modal -->
    <flux:modal wire:model="showDeleteModal" class="max-w-md">
        <div class="p-6">
            <flux:heading size="lg" class="mb-4">Delete Account</flux:heading>
            
            <p class="text-zinc-600 dark:text-zinc-400 mb-6">
                Are you sure you want to delete <strong>{{ $account->company_name }}</strong>? This action cannot be undone and will permanently delete all associated data including users and vehicles.
            </p>
            
            <div class="flex items-center justify-end gap-3">
                <flux:button variant="ghost" wire:click="$set('showDeleteModal', false)">
                    Cancel
                </flux:button>
                <flux:button variant="danger" wire:click="deleteAccount">
                    Delete Account
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
