<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">{{ $plan ? 'Edit Plan' : 'Create Plan' }}</flux:heading>
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

            <!-- Price -->
            <div>
                <flux:input 
                    wire:model="price" 
                    type="number" 
                    step="0.01"
                    label="Monthly Price (£)" 
                    placeholder="29.99"
                    required
                />
                @error('price') 
                    <flux:error>{{ $message }}</flux:error>
                @enderror
                <flux:text class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                    Enter the monthly subscription price in British pounds.
                </flux:text>
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
                    {{ $plan ? 'Update Plan' : 'Create Plan' }}
                </flux:button>
                <flux:button type="button" variant="ghost" href="{{ route('admin.plans.index') }}">
                    Cancel
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
