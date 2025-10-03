<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Add New Reseller</flux:heading>
        <flux:button href="{{ route('admin.resellers.index') }}" variant="ghost">
            Back to Resellers
        </flux:button>
    </div>

    <flux:card class="max-w-2xl">
        <form wire:submit="save" class="p-6 space-y-6">
            <!-- Contact Information -->
            <div class="space-y-4">
                <flux:heading size="lg">Contact Information</flux:heading>

                <div>
                    <flux:input 
                        wire:model="name" 
                        label="Contact Name" 
                        placeholder="e.g., John Smith"
                        required
                    />
                    @error('name') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                    <flux:text class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                        The main contact person for this reseller account.
                    </flux:text>
                </div>

                <div>
                    <flux:input 
                        wire:model="email" 
                        type="email"
                        label="Email Address" 
                        placeholder="contact@company.com"
                        required
                    />
                    @error('email') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                    <flux:text class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                        This will be used for login and notifications.
                    </flux:text>
                </div>

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
            </div>

            <flux:separator />

            <!-- Company Information -->
            <div class="space-y-4">
                <flux:heading size="lg">Company Information</flux:heading>

                <div>
                    <flux:input 
                        wire:model="company_name" 
                        label="Company Name" 
                        placeholder="e.g., ABC Resellers Ltd"
                        required
                    />
                    @error('company_name') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>
            </div>

            <flux:separator />

            <!-- Commission Settings -->
            <div class="space-y-4">
                <flux:heading size="lg">Commission Settings</flux:heading>

                <div>
                    <flux:input 
                        wire:model="commission_rate" 
                        type="number"
                        step="0.01"
                        min="0"
                        max="100"
                        label="Commission Rate (%)" 
                        required
                    />
                    @error('commission_rate') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                    <flux:text class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                        Percentage of monthly subscription revenue paid to this reseller.
                    </flux:text>
                </div>

                <div>
                    <flux:checkbox wire:model="is_active" label="Active" />
                    <flux:text class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                        Inactive resellers cannot log in to the reseller portal.
                    </flux:text>
                </div>
            </div>

            <flux:separator />

            <!-- Information Notice -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-blue-900 dark:text-blue-100">Account Creation</h3>
                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                            A temporary password will be generated automatically. The reseller will receive an email with instructions to set up their account and access the reseller portal.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3 pt-4">
                <flux:button type="submit" variant="primary">
                    Create Reseller
                </flux:button>
                <flux:button type="button" variant="ghost" href="{{ route('admin.resellers.index') }}">
                    Cancel
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
