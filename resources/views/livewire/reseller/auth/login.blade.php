<div class="min-h-screen flex items-center justify-center bg-zinc-50 dark:bg-zinc-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-bold text-zinc-900 dark:text-white">
                Reseller Portal
            </h2>
            <p class="mt-2 text-center text-sm text-zinc-600 dark:text-zinc-400">
                Sign in to manage your customers and commissions
            </p>
        </div>
        
        <flux:card class="p-8">
            <form wire:submit="login" class="space-y-6">
                <div>
                    <flux:input 
                        wire:model="email" 
                        type="email" 
                        label="Email Address" 
                        placeholder="reseller@example.com"
                        required 
                        autofocus 
                    />
                    @error('email') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>

                <div>
                    <flux:input 
                        wire:model="password" 
                        type="password" 
                        label="Password" 
                        placeholder="••••••••"
                        required 
                    />
                    @error('password') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>

                <div class="flex items-center">
                    <flux:checkbox wire:model="remember" label="Remember me" />
                </div>

                <div>
                    <flux:button type="submit" variant="primary" class="w-full">
                        Sign in
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</div>
