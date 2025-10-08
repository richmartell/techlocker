<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Create Plan</flux:heading>
        <flux:button href="{{ route('admin.plans.index') }}" variant="ghost">
            Back to Plans
        </flux:button>
    </div>

    <flux:card class="max-w-3xl">
        <form wire:submit="save" class="p-6 space-y-6">
            <!-- Plan Name -->
            <div>
                <flux:input 
                    wire:model="name" 
                    label="Plan Name" 
                    placeholder="e.g., Starter, Professional, Enterprise"
                    required
                />
                @error('name') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <flux:textarea 
                    wire:model="description" 
                    label="Description" 
                    placeholder="Brief description of what this plan offers"
                    rows="3"
                />
                @error('description') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </div>

            <!-- Pricing from Stripe (Read-only Display) -->
            <div class="space-y-4">
                <flux:heading size="lg">Pricing (from Stripe)</flux:heading>
                <flux:text class="text-sm text-zinc-600 dark:text-zinc-400">
                    Prices are fetched directly from Stripe. Update pricing in your Stripe Dashboard.
                </flux:text>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Monthly Price Display -->
                    <div class="p-4 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 block mb-2">
                            Monthly Price
                        </label>
                        @if($monthly_price_display)
                            <div class="text-2xl font-bold text-zinc-900 dark:text-white">
                                {{ $monthly_price_display }}/mo
                            </div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 font-mono">
                                {{ $stripe_monthly_price_id }}
                            </div>
                        @else
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 italic">
                                No monthly price set
                            </div>
                        @endif
                    </div>

                    <!-- Yearly Price Display -->
                    <div class="p-4 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 block mb-2">
                            Yearly Price
                        </label>
                        @if($yearly_price_display)
                            <div class="text-2xl font-bold text-zinc-900 dark:text-white">
                                {{ $yearly_price_display }}/yr
                            </div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 font-mono">
                                {{ $stripe_yearly_price_id }}
                            </div>
                        @else
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 italic">
                                No yearly price set (optional)
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <flux:separator />

            <div class="space-y-4">
                <flux:heading size="lg">Plan Limits</flux:heading>
                <flux:text class="text-sm text-zinc-600 dark:text-zinc-400">
                    Leave fields empty for unlimited access.
                </flux:text>

                <!-- Max Users -->
                <div>
                    <flux:input 
                        wire:model="max_users" 
                        type="number" 
                        label="Maximum Users" 
                        placeholder="Leave empty for unlimited"
                    />
                    @error('max_users') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>

                <!-- Max Customers -->
                <div>
                    <flux:input 
                        wire:model="max_customers" 
                        type="number" 
                        label="Maximum Customers" 
                        placeholder="Leave empty for unlimited"
                    />
                    @error('max_customers') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>

                <!-- Max Searches -->
                <div>
                    <flux:input 
                        wire:model="max_searches" 
                        type="number" 
                        label="Maximum Searches per Month" 
                        placeholder="Leave empty for unlimited"
                    />
                    @error('max_searches') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>
            </div>

            <flux:separator />

            <div class="space-y-4">
                <flux:heading size="lg">Stripe Integration</flux:heading>
                <flux:text class="text-sm text-zinc-600 dark:text-zinc-400">
                    Connect this plan to your Stripe price IDs. You can find these in your Stripe Dashboard under Products.
                </flux:text>

                <!-- Stripe Monthly Price ID -->
                <div>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <flux:input 
                                wire:model="stripe_monthly_price_id" 
                                label="Stripe Monthly Price ID" 
                                placeholder="price_xxxxxxxxxxxxx"
                            />
                        </div>
                        <div class="pt-6">
                            <flux:button 
                                type="button"
                                wire:click="openStripePricesModal('monthly')"
                                variant="ghost"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                Browse
                            </flux:button>
                        </div>
                    </div>
                    @error('stripe_monthly_price_id') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                    <flux:text class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                        Click "Browse" to select from your Stripe prices
                    </flux:text>
                </div>

                <!-- Stripe Yearly Price ID -->
                <div>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <flux:input 
                                wire:model="stripe_yearly_price_id" 
                                label="Stripe Yearly Price ID (Optional)" 
                                placeholder="price_xxxxxxxxxxxxx"
                            />
                        </div>
                        <div class="pt-6">
                            <flux:button 
                                type="button"
                                wire:click="openStripePricesModal('yearly')"
                                variant="ghost"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                Browse
                            </flux:button>
                        </div>
                    </div>
                    @error('stripe_yearly_price_id') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                    <flux:text class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                        Leave empty if you only offer monthly billing
                    </flux:text>
                </div>
            </div>

            <flux:separator />

            <!-- Active Status -->
            <div>
                <flux:checkbox wire:model="is_active" label="Plan is active and available for new subscriptions" />
                @error('is_active') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3 pt-4">
                <flux:button type="submit" variant="primary">
                    Create Plan
                </flux:button>
                <flux:button type="button" variant="ghost" href="{{ route('admin.plans.index') }}">
                    Cancel
                </flux:button>
            </div>
        </form>
    </flux:card>

    <!-- Stripe Prices Modal -->
    <flux:modal name="stripe-prices-modal" :open="$showStripePricesModal" wire:model="showStripePricesModal">
        <div class="space-y-6 p-6">
            <div>
                <flux:heading size="lg">
                    Select Stripe Price ({{ ucfirst($selectingPriceFor) }})
                </flux:heading>
                <flux:text class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                    Choose a price from your Stripe account to link to this plan
                </flux:text>
            </div>

            @if($stripePricesLoading)
                <div class="flex flex-col items-center justify-center py-12">
                    <svg class="animate-spin h-10 w-10 text-primary-600 dark:text-primary-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <flux:text class="text-zinc-600 dark:text-zinc-400">Loading prices from Stripe...</flux:text>
                </div>
            @elseif($stripePricesError)
                <div class="p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-600 dark:text-red-400 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-red-900 dark:text-red-200">Error</h4>
                            <p class="text-sm text-red-800 dark:text-red-300 mt-1">{{ $stripePricesError }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <flux:button wire:click="fetchStripePrices" variant="ghost" size="sm">
                            Try Again
                        </flux:button>
                    </div>
                </div>
            @elseif(empty($stripePrices))
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-zinc-400 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <flux:heading size="lg" class="mt-4">No prices found</flux:heading>
                    <flux:text class="text-zinc-600 dark:text-zinc-400 mt-2">
                        No active prices were found in your Stripe account. Create some prices in Stripe first.
                    </flux:text>
                </div>
            @else
                <div class="max-h-96 overflow-y-auto space-y-3">
                    @foreach($stripePrices as $price)
                        <div 
                            wire:click="selectStripePrice('{{ $price['id'] }}')"
                            class="p-4 rounded-lg border border-zinc-200 dark:border-zinc-700 hover:border-primary-500 dark:hover:border-primary-500 hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer transition-all"
                        >
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-semibold text-zinc-900 dark:text-white">
                                            {{ $price['product_name'] }}
                                        </h4>
                                        @if($price['type'] === 'recurring')
                                            <flux:badge color="blue" size="sm">
                                                {{ ucfirst($price['interval']) }}ly
                                            </flux:badge>
                                        @else
                                            <flux:badge color="zinc" size="sm">
                                                One-time
                                            </flux:badge>
                                        @endif
                                    </div>
                                    @if($price['product_description'])
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                            {{ $price['product_description'] }}
                                        </p>
                                    @endif
                                    <p class="text-xs text-zinc-500 dark:text-zinc-500 mt-2 font-mono">
                                        {{ $price['id'] }}
                                    </p>
                                </div>
                                <div class="text-right ml-4">
                                    <div class="text-lg font-bold text-zinc-900 dark:text-white">
                                        {{ $price['currency'] }} {{ number_format($price['amount'] / 100, 2) }}
                                    </div>
                                    @if($price['type'] === 'recurring')
                                        <div class="text-xs text-zinc-600 dark:text-zinc-400">
                                            per {{ $price['interval'] }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <flux:separator />

            <div class="flex justify-end gap-2">
                <flux:button wire:click="closeStripePricesModal" variant="ghost">
                    Cancel
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
