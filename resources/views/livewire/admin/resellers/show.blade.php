<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">{{ $reseller->name }}</flux:heading>
        <div class="flex gap-2">
            <flux:button 
                wire:click="toggleStatus" 
                variant="ghost"
                wire:confirm="Are you sure you want to {{ $reseller->is_active ? 'deactivate' : 'activate' }} this reseller?"
            >
                {{ $reseller->is_active ? 'Deactivate' : 'Activate' }}
            </flux:button>
            <flux:button href="{{ route('admin.resellers.index') }}" variant="ghost">
                Back to Resellers
            </flux:button>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Reseller Information -->
        <div>
            <flux:card class="mb-6">
                <div class="p-6">
                    <flux:heading size="lg" class="mb-4">Contact Details</flux:heading>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Name</label>
                            <p class="text-zinc-900 dark:text-white mt-1">{{ $reseller->name }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Email</label>
                            <p class="text-zinc-900 dark:text-white mt-1">{{ $reseller->email }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Company</label>
                            <p class="text-zinc-900 dark:text-white mt-1">{{ $reseller->company_name }}</p>
                        </div>

                        @if($reseller->phone)
                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Phone</label>
                            <p class="text-zinc-900 dark:text-white mt-1">{{ $reseller->phone }}</p>
                        </div>
                        @endif

                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Status</label>
                            <p class="mt-1">
                                @if($reseller->is_active)
                                    <flux:badge color="green">Active</flux:badge>
                                @else
                                    <flux:badge color="red">Inactive</flux:badge>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Member Since</label>
                            <p class="text-zinc-900 dark:text-white mt-1">{{ $reseller->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Performance Stats -->
            <flux:card>
                <div class="p-6">
                    <flux:heading size="lg" class="mb-4">Performance</flux:heading>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Trials Created</span>
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $reseller->trials_created }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Trials Converted</span>
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $reseller->trials_converted }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Conversion Rate</span>
                            <span class="font-semibold text-zinc-900 dark:text-white">
                                {{ $reseller->trials_created > 0 ? round(($reseller->trials_converted / $reseller->trials_created) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Accounts & Commissions -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Commission Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <flux:card>
                    <div class="p-6">
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Earned</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">
                            £{{ number_format($reseller->total_commission_earned, 2) }}
                        </p>
                    </div>
                </flux:card>

                <flux:card>
                    <div class="p-6">
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Paid Out</p>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                            £{{ number_format($reseller->total_commission_paid, 2) }}
                        </p>
                    </div>
                </flux:card>

                <flux:card>
                    <div class="p-6">
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Pending</p>
                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400 mt-2">
                            £{{ number_format($reseller->pending_commission, 2) }}
                        </p>
                    </div>
                </flux:card>
            </div>

            <!-- Pricing Configuration -->
            <flux:card>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <flux:heading size="lg">Pricing Configuration</flux:heading>
                        <flux:button wire:click="$set('showPricingModal', true)" size="sm" variant="primary">
                            Manage Pricing
                        </flux:button>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Fallback Discount</label>
                            <p class="text-zinc-900 dark:text-white text-2xl font-bold mt-1">
                                {{ number_format($reseller->fallback_discount_percentage, 0) }}%
                            </p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                Applied when no custom price is set
                            </p>
                        </div>

                        <div class="pt-3 border-t border-zinc-200 dark:border-zinc-700">
                            <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-2 block">Custom Plan Pricing (Annual)</label>
                            @if($reseller->planPrices->count() > 0)
                                <div class="space-y-2">
                                    @foreach($reseller->planPrices as $planPrice)
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-zinc-600 dark:text-zinc-400">{{ $planPrice->plan->name }}</span>
                                            <span class="font-medium text-zinc-900 dark:text-white">£{{ number_format($planPrice->price, 2) }}/year</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">No custom pricing set</p>
                            @endif
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Accounts List -->
            <flux:card>
                <div class="p-6">
                    <flux:heading size="lg" class="mb-4">Customer Accounts ({{ $reseller->accounts->count() }})</flux:heading>
                    
                    @if($reseller->accounts->count() > 0)
                        <flux:table>
                            <flux:table.columns>
                                <flux:table.column>Company</flux:table.column>
                                <flux:table.column>Status</flux:table.column>
                                <flux:table.column>Plan</flux:table.column>
                                <flux:table.column>Users</flux:table.column>
                                <flux:table.column>Created</flux:table.column>
                            </flux:table.columns>

                            <flux:table.rows>
                                @foreach($reseller->accounts()->orderBy('created_at', 'desc')->get() as $account)
                                    <flux:table.row :key="$account->id">
                                        <flux:table.cell>
                                            <a href="{{ route('admin.accounts.show', $account) }}" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                                {{ $account->company_name }}
                                            </a>
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            @if($account->status)
                                                <flux:badge color="{{ $account->status_color }}">{{ $account->status_label }}</flux:badge>
                                            @else
                                                <span class="text-zinc-500 dark:text-zinc-400">—</span>
                                            @endif
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            @if($account->plan)
                                                <flux:badge color="blue">{{ $account->plan->name }}</flux:badge>
                                            @else
                                                <span class="text-zinc-500 dark:text-zinc-400">No plan</span>
                                            @endif
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <flux:badge>{{ $account->users->count() }}</flux:badge>
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                                {{ $account->created_at->format('M d, Y') }}
                                            </span>
                                        </flux:table.cell>
                                    </flux:table.row>
                                @endforeach
                            </flux:table.rows>
                        </flux:table>
                    @else
                        <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                            <p>No customer accounts yet.</p>
                        </div>
                    @endif
                </div>
            </flux:card>

            <!-- Commission Payments -->
            <flux:card>
                <div class="p-6">
                    <flux:heading size="lg" class="mb-4">Commission Payments ({{ $reseller->commissions->count() }})</flux:heading>
                    
                    @if($reseller->commissions->count() > 0)
                        <flux:table>
                            <flux:table.columns>
                                <flux:table.column>Account</flux:table.column>
                                <flux:table.column>Amount</flux:table.column>
                                <flux:table.column>Status</flux:table.column>
                                <flux:table.column>Earned</flux:table.column>
                                <flux:table.column>Paid</flux:table.column>
                            </flux:table.columns>

                            <flux:table.rows>
                                @foreach($reseller->commissions()->orderBy('earned_at', 'desc')->get() as $commission)
                                    <flux:table.row :key="$commission->id">
                                        <flux:table.cell>
                                            @if($commission->account)
                                                <a href="{{ route('admin.accounts.show', $commission->account) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                    {{ $commission->account->company_name }}
                                                </a>
                                            @else
                                                <span class="text-zinc-500 dark:text-zinc-400">—</span>
                                            @endif
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <span class="font-medium text-zinc-900 dark:text-white">
                                                £{{ number_format($commission->amount, 2) }}
                                            </span>
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <flux:badge color="{{ $commission->status_color }}">
                                                {{ ucfirst($commission->status) }}
                                            </flux:badge>
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                                {{ $commission->earned_at->format('M d, Y') }}
                                            </span>
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            @if($commission->paid_at)
                                                <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                                    {{ $commission->paid_at->format('M d, Y') }}
                                                </span>
                                            @else
                                                <span class="text-sm text-zinc-500 dark:text-zinc-400">—</span>
                                            @endif
                                        </flux:table.cell>
                                    </flux:table.row>
                                @endforeach
                            </flux:table.rows>
                        </flux:table>
                    @else
                        <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                            <p>No commission payments yet.</p>
                        </div>
                    @endif
                </div>
            </flux:card>
        </div>
    </div>

    <!-- Pricing Management Modal -->
    <flux:modal name="pricing-modal" class="min-w-2xl" wire:model="showPricingModal">
        <form wire:submit="savePricing">
            <div class="p-6">
                <flux:heading size="lg" class="mb-6">Manage Reseller Pricing</flux:heading>

                <!-- Fallback Discount -->
                <div class="mb-6">
                    <flux:field>
                        <flux:label>
                            Fallback Discount Percentage
                            <flux:badge color="zinc" size="sm" class="ml-2">Optional</flux:badge>
                        </flux:label>
                        <flux:description>
                            Applied to plans without custom pricing. E.g., 15% means reseller pays 85% of the retail price.
                        </flux:description>
                        <flux:input 
                            wire:model="fallbackDiscount" 
                            type="number" 
                            step="0.01" 
                            min="0" 
                            max="100"
                            placeholder="0.00"
                            suffix="%"
                        />
                        <flux:error name="fallbackDiscount" />
                    </flux:field>
                </div>

                <flux:separator class="my-6" />

                <!-- Custom Plan Prices (Annual) -->
                <div>
                    <div class="mb-4">
                        <flux:heading size="md">Custom Plan Pricing (Annual)</flux:heading>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                            Set annual prices the reseller pays for each plan. Leave blank to use fallback discount.
                        </p>
                    </div>

                    <div class="space-y-4">
                        @foreach($plans as $plan)
                            @php
                                $stripePrice = $plan->getStripeYearlyCost();
                                $retailPrice = $stripePrice ? $stripePrice['amount'] / 100 : ($plan->price * 12);
                                $resellerPrice = $reseller->getPriceForPlan($plan);
                                $margin = $retailPrice - $resellerPrice;
                            @endphp
                            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <flux:heading size="sm">{{ $plan->name }}</flux:heading>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-zinc-600 dark:text-zinc-400">
                                                Retail: <span class="font-semibold">£{{ number_format($retailPrice, 2) }}/year</span>
                                            </span>
                                            @if(isset($planPrices[$plan->id]) && $planPrices[$plan->id])
                                                <flux:badge color="green" size="sm">Custom Price Set</flux:badge>
                                            @elseif($reseller->fallback_discount_percentage > 0)
                                                <flux:badge color="blue" size="sm">Using Fallback</flux:badge>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-zinc-600 dark:text-zinc-400">Current Margin</div>
                                        <div class="text-sm font-semibold text-green-600 dark:text-green-400">
                                            £{{ number_format($margin, 2) }}/year
                                        </div>
                                    </div>
                                </div>

                                <flux:field>
                                    <flux:label>Reseller Price (Annual)</flux:label>
                                    <flux:input 
                                        wire:model.live="planPrices.{{ $plan->id }}" 
                                        type="number" 
                                        step="0.01" 
                                        min="0"
                                        placeholder="Leave blank to use fallback discount"
                                        prefix="£"
                                    />
                                    <flux:error name="planPrices.{{ $plan->id }}" />
                                </flux:field>

                                @if(isset($planPrices[$plan->id]) && $planPrices[$plan->id])
                                    @php
                                        $newMargin = $retailPrice - $planPrices[$plan->id];
                                        $marginPercent = $retailPrice > 0 ? ($newMargin / $retailPrice) * 100 : 0;
                                    @endphp
                                    <div class="mt-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-zinc-700 dark:text-zinc-300">New Margin:</span>
                                            <span class="font-semibold text-blue-700 dark:text-blue-300">
                                                £{{ number_format($newMargin, 2) }}/year ({{ number_format($marginPercent, 1) }}%)
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <flux:separator />

            <div class="flex gap-2 justify-end p-6">
                <flux:button type="button" variant="ghost" wire:click="$set('showPricingModal', false)">
                    Cancel
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Save Pricing
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
