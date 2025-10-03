<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Create Trial Account</flux:heading>
        <flux:button href="{{ route('reseller.customers') }}" variant="ghost">
            Back to Customers
        </flux:button>
    </div>

    <flux:card class="max-w-2xl">
        <form wire:submit="createTrial" class="p-6 space-y-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-blue-900 dark:text-blue-100">14-Day Trial</h3>
                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                            This will create a new customer account with a 14-day free trial. The customer will receive an email to set up their password and access the platform.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Business Name -->
            <div>
                <flux:input 
                    wire:model="company_name" 
                    label="Business Name" 
                    placeholder="e.g., ABC Motors Ltd"
                    required
                />
                @error('company_name') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </div>

            <!-- Contact Name -->
            <div>
                <flux:input 
                    wire:model="contact_name" 
                    label="Contact Name" 
                    placeholder="e.g., John Smith"
                    required
                />
                @error('contact_name') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
                <flux:text class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                    The main contact person who will manage this account.
                </flux:text>
            </div>

            <!-- Email Address -->
            <div>
                <flux:input 
                    wire:model="email" 
                    type="email"
                    label="Email Address" 
                    placeholder="contact@business.com"
                    required
                />
                @error('email') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
                <flux:text class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                    This will be used for login and account notifications.
                </flux:text>
            </div>

            <!-- Phone (Optional) -->
            <div>
                <flux:input 
                    wire:model="phone" 
                    type="tel"
                    label="Phone Number (Optional)" 
                    placeholder="07700 900000"
                />
                @error('phone') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </div>

            <flux:separator />

            <!-- Trial Information -->
            <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4">
                <h3 class="text-sm font-medium text-zinc-900 dark:text-white mb-2">Trial Details</h3>
                <ul class="space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>14 days free trial period</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Full access to all features</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>No credit card required</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Commission earned on conversion</span>
                    </li>
                </ul>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3 pt-4">
                <flux:button type="submit" variant="primary">
                    Create Trial Account
                </flux:button>
                <flux:button type="button" variant="ghost" href="{{ route('reseller.customers') }}">
                    Cancel
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
