<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <!-- Header -->
        <flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            
            <!-- Logo and Brand -->
            <flux:brand href="{{ route('admin.dashboard') }}" name="Admin Portal" class="max-lg:hidden" wire:navigate />
            
            <!-- Main Navigation -->
            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="home" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>Dashboard</flux:navbar.item>
                <flux:navbar.item icon="building-office" :href="route('admin.accounts.index')" :current="request()->routeIs('admin.accounts.*')" wire:navigate>Accounts</flux:navbar.item>
                <flux:navbar.item icon="user-group" :href="route('admin.resellers.index')" :current="request()->routeIs('admin.resellers.*')" wire:navigate>Resellers</flux:navbar.item>
                <flux:navbar.item icon="rectangle-stack" :href="route('admin.plans.index')" :current="request()->routeIs('admin.plans.*')" wire:navigate>Plans</flux:navbar.item>
                <flux:navbar.item icon="banknotes" :href="route('admin.invoices.index')" :current="request()->routeIs('admin.invoices.*')" wire:navigate>Billing</flux:navbar.item>
            </flux:navbar>
            
            <flux:spacer />
            
            <!-- Admin Profile Dropdown -->
            <flux:dropdown position="top" align="start">
                <flux:profile :initials="strtoupper(substr(auth('admin')->user()->name, 0, 2))" />
                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ strtoupper(substr(auth('admin')->user()->name, 0, 2)) }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth('admin')->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth('admin')->user()->email }}</span>
                                    <span class="truncate text-xs text-yellow-600 dark:text-yellow-400">Admin</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            Logout
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Mobile Sidebar -->
        <flux:sidebar stashable sticky class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
            <flux:brand href="{{ route('admin.dashboard') }}" name="Admin Portal" class="px-2" wire:navigate />
            
            <flux:navlist variant="outline">
                <flux:navlist.item icon="home" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>Dashboard</flux:navlist.item>
                <flux:navlist.item icon="building-office" :href="route('admin.accounts.index')" :current="request()->routeIs('admin.accounts.*')" wire:navigate>Accounts</flux:navlist.item>
                <flux:navlist.item icon="user-group" :href="route('admin.resellers.index')" :current="request()->routeIs('admin.resellers.*')" wire:navigate>Resellers</flux:navlist.item>
                <flux:navlist.item icon="rectangle-stack" :href="route('admin.plans.index')" :current="request()->routeIs('admin.plans.*')" wire:navigate>Plans</flux:navlist.item>
                <flux:navlist.item icon="banknotes" :href="route('admin.invoices.index')" :current="request()->routeIs('admin.invoices.*')" wire:navigate>Billing</flux:navlist.item>
            </flux:navlist>
        </flux:sidebar>

        <!-- Main Content Area -->
        <flux:main container>
            {{ $slot }}
        </flux:main>

        @stack('scripts')
        @fluxScripts
    </body>
</html>

