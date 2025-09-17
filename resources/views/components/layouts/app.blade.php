@props(['title' => null, 'vehicle' => null, 'vehicleImage' => null])

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
            <flux:brand href="{{ route('dashboard') }}" name="Tech Locker" class="max-lg:hidden" wire:navigate />
            
            <!-- Main Navigation -->
            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>Home</flux:navbar.item>
                <flux:navbar.item icon="magnifying-glass" :href="route('vehicle-lookup')" :current="request()->routeIs('vehicle-lookup')" wire:navigate>Vehicle Search</flux:navbar.item>
            </flux:navbar>
            
            <flux:spacer />
            
            <!-- User Profile Dropdown -->
            <flux:dropdown position="top" align="start">
                <flux:profile :initials="auth()->user()->initials()" />
                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <flux:menu.item :href="route('settings.profile')" icon="cog-6-tooth" wire:navigate>Settings</flux:menu.item>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
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
            <flux:brand href="{{ route('dashboard') }}" name="Tech Locker" class="px-2" wire:navigate />
            
            <flux:navlist variant="outline">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>Home</flux:navlist.item>
                <flux:navlist.item icon="magnifying-glass" :href="route('vehicle-lookup')" :current="request()->routeIs('vehicle-lookup')" wire:navigate>Vehicle Search</flux:navlist.item>
            </flux:navlist>
            
            <!-- Vehicle Navigation (Mobile) -->
            @if(isset($vehicle))
                <flux:separator class="my-4" />
                <flux:navlist variant="outline">
                    <flux:navlist.item icon="document-text" :href="route('vehicle-details', $vehicle->registration)" :current="request()->routeIs('vehicle-details')" wire:navigate>Overview</flux:navlist.item>
                            <flux:navlist.group expandable :expanded="request()->routeIs('maintenance.*')" heading="Maintenance" icon="wrench-screwdriver">
                                <flux:navlist.item :href="route('maintenance.schedules', $vehicle->registration)" :current="request()->routeIs('maintenance.schedules')" wire:navigate>Schedules</flux:navlist.item>
                                <flux:navlist.item :href="route('maintenance.procedures', $vehicle->registration)" :current="request()->routeIs('maintenance.procedures') || request()->routeIs('maintenance.story')" wire:navigate>Procedures</flux:navlist.item>
                                <flux:navlist.item :href="route('maintenance.lubricants', $vehicle->registration)" :current="request()->routeIs('maintenance.lubricants')" wire:navigate>Lubricants</flux:navlist.item>
                                <flux:navlist.item :href="route('maintenance.service-indicator-reset', $vehicle->registration)" :current="request()->routeIs('maintenance.service-indicator-reset')" wire:navigate>Service indicator reset</flux:navlist.item>
                            </flux:navlist.group>
                    <flux:navlist.group expandable :expanded="request()->routeIs('adjustments.*')" heading="Adjustments" icon="cog-8-tooth">
                        <flux:navlist.item :href="route('adjustments.engine-general', $vehicle->registration)" :current="request()->routeIs('adjustments.engine-general')" wire:navigate>Engine (general)</flux:navlist.item>
                        <flux:navlist.item :href="route('adjustments.engine-specifications', $vehicle->registration)" :current="request()->routeIs('adjustments.engine-specifications')" wire:navigate>Engine (specifications)</flux:navlist.item>
                        <flux:navlist.item :href="route('adjustments.emissions', $vehicle->registration)" :current="request()->routeIs('adjustments.emissions')" wire:navigate>Emissions</flux:navlist.item>
                        <flux:navlist.item :href="route('adjustments.cooling-system', $vehicle->registration)" :current="request()->routeIs('adjustments.cooling-system')" wire:navigate>Cooling system</flux:navlist.item>
                        <flux:navlist.item :href="route('adjustments.electrical', $vehicle->registration)" :current="request()->routeIs('adjustments.electrical')" wire:navigate>Electrical</flux:navlist.item>
                        <flux:navlist.item :href="route('adjustments.brakes', $vehicle->registration)" :current="request()->routeIs('adjustments.brakes')" wire:navigate>Brakes</flux:navlist.item>
                        <flux:navlist.item :href="route('adjustments.steering', $vehicle->registration)" :current="request()->routeIs('adjustments.steering')" wire:navigate>Steering, suspension and wheel alignment</flux:navlist.item>
                        <flux:navlist.item :href="route('adjustments.wheels-tyres', $vehicle->registration)" :current="request()->routeIs('adjustments.wheels-tyres')" wire:navigate>Wheels and tyres</flux:navlist.item>
                        <flux:navlist.item :href="route('adjustments.capacities', $vehicle->registration)" :current="request()->routeIs('adjustments.capacities')" wire:navigate>Capacities</flux:navlist.item>
                        <flux:navlist.item :href="route('adjustments.torque-settings', $vehicle->registration)" :current="request()->routeIs('adjustments.torque-settings')" wire:navigate>Torque settings</flux:navlist.item>
                    </flux:navlist.group>
                    <flux:navlist.group expandable :expanded="request()->routeIs('technical-information.*')" heading="Repair Manuals" icon="cog-6-tooth">
                        <flux:navlist.item :href="route('technical-information.index', $vehicle->registration)" :current="request()->routeIs('technical-information.*')" wire:navigate>All categories</flux:navlist.item>
                        <flux:navlist.item href="#" wire:navigate>Engine</flux:navlist.item>
                        <flux:navlist.item href="#" wire:navigate>Transmission</flux:navlist.item>
                        <flux:navlist.item href="#" wire:navigate>Steering and Suspension</flux:navlist.item>
                                                            <flux:navlist.item :href="route('adjustments.brakes', $vehicle->registration)" :current="request()->routeIs('adjustments.brakes')" wire:navigate>Brakes</flux:navlist.item>
                        <flux:navlist.item href="#" wire:navigate>Exterior/Interior</flux:navlist.item>
                    </flux:navlist.group>
                    <flux:navlist.group expandable :expanded="request()->routeIs('vehicle-diagnostics')" heading="Electronics" icon="cpu-chip">
                        <flux:navlist.item :href="route('vehicle-diagnostics', $vehicle->registration)" :current="request()->routeIs('vehicle-diagnostics')" wire:navigate>Engine</flux:navlist.item>
                        <flux:navlist.item href="#" wire:navigate>Transmission</flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>
            @endif
        </flux:sidebar>

        <!-- Main Content Area -->
        <flux:main container>
            <!-- Desktop Vehicle Sidebar (Conditional) -->
            @if(isset($vehicle))
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                    <div class="col-span-1 md:col-span-3 pb-4">
                        <!-- Vehicle Image -->
                        @if($vehicleImage)
                        <div class="mb-4 p-3 rounded-lg bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700">
                            <div class="flex justify-center items-center">
                                <img src="{{ $vehicleImage }}" alt="{{ $vehicle->make?->name ?? 'Vehicle' }} {{ $vehicle->model?->name ?? '' }}" class="max-w-full h-auto rounded-lg shadow-sm">
                            </div>
                        </div>
                        @endif
                        
                        <flux:navlist>
                            <flux:navlist.item icon="document-text" :href="route('vehicle-details', $vehicle->registration)" :current="request()->routeIs('vehicle-details')" wire:navigate>Overview</flux:navlist.item>
                            <flux:navlist.group expandable :expanded="request()->routeIs('maintenance.*')" heading="Maintenance" icon="wrench-screwdriver">
                                <flux:navlist.item :href="route('maintenance.schedules', $vehicle->registration)" :current="request()->routeIs('maintenance.schedules')" wire:navigate>Schedules</flux:navlist.item>
                                <flux:navlist.item :href="route('maintenance.procedures', $vehicle->registration)" :current="request()->routeIs('maintenance.procedures') || request()->routeIs('maintenance.story')" wire:navigate>Procedures</flux:navlist.item>
                                <flux:navlist.item :href="route('maintenance.lubricants', $vehicle->registration)" :current="request()->routeIs('maintenance.lubricants')" wire:navigate>Lubricants</flux:navlist.item>
                            </flux:navlist.group>
                            <flux:navlist.group expandable :expanded="request()->routeIs('adjustments.*')" heading="Adjustments" icon="cog-8-tooth">
                                <flux:navlist.item :href="route('adjustments.engine-general', $vehicle->registration)" :current="request()->routeIs('adjustments.engine-general')" wire:navigate>Engine (general)</flux:navlist.item>
                                <flux:navlist.item :href="route('adjustments.engine-specifications', $vehicle->registration)" :current="request()->routeIs('adjustments.engine-specifications')" wire:navigate>Engine (specifications)</flux:navlist.item>
                                <flux:navlist.item :href="route('adjustments.emissions', $vehicle->registration)" :current="request()->routeIs('adjustments.emissions')" wire:navigate>Emissions</flux:navlist.item>
                                <flux:navlist.item :href="route('adjustments.cooling-system', $vehicle->registration)" :current="request()->routeIs('adjustments.cooling-system')" wire:navigate>Cooling system</flux:navlist.item>
                                <flux:navlist.item :href="route('adjustments.electrical', $vehicle->registration)" :current="request()->routeIs('adjustments.electrical')" wire:navigate>Electrical</flux:navlist.item>
                                <flux:navlist.item :href="route('adjustments.brakes', $vehicle->registration)" :current="request()->routeIs('adjustments.brakes')" wire:navigate>Brakes</flux:navlist.item>
                                <flux:navlist.item :href="route('adjustments.steering', $vehicle->registration)" :current="request()->routeIs('adjustments.steering')" wire:navigate>Steering, suspension and wheel alignment</flux:navlist.item>
                                <flux:navlist.item :href="route('adjustments.wheels-tyres', $vehicle->registration)" :current="request()->routeIs('adjustments.wheels-tyres')" wire:navigate>Wheels and tyres</flux:navlist.item>
                                <flux:navlist.item :href="route('adjustments.capacities', $vehicle->registration)" :current="request()->routeIs('adjustments.capacities')" wire:navigate>Capacities</flux:navlist.item>
                                <flux:navlist.item :href="route('adjustments.torque-settings', $vehicle->registration)" :current="request()->routeIs('adjustments.torque-settings')" wire:navigate>Torque settings</flux:navlist.item>
                            </flux:navlist.group>
                            <flux:navlist.group expandable :expanded="request()->routeIs('technical-information.*')" heading="Repair Manuals" icon="cog-6-tooth">
                                <flux:navlist.item :href="route('technical-information.index', $vehicle->registration)" :current="request()->routeIs('technical-information.*')" wire:navigate>All categories</flux:navlist.item>
                                <flux:navlist.item href="#" wire:navigate>Engine</flux:navlist.item>
                                <flux:navlist.item href="#" wire:navigate>Transmission</flux:navlist.item>
                                <flux:navlist.item href="#" wire:navigate>Steering and Suspension</flux:navlist.item>
                                                                    <flux:navlist.item :href="route('adjustments.brakes', $vehicle->registration)" :current="request()->routeIs('adjustments.brakes')" wire:navigate>Brakes</flux:navlist.item>
                                <flux:navlist.item href="#" wire:navigate>Exterior/Interior</flux:navlist.item>
                            </flux:navlist.group>
                            <flux:navlist.group expandable :expanded="request()->routeIs('vehicle-diagnostics')" heading="Electronics" icon="cpu-chip">
                                <flux:navlist.item :href="route('vehicle-diagnostics', $vehicle->registration)" :current="request()->routeIs('vehicle-diagnostics')" wire:navigate>Engine</flux:navlist.item>
                                <flux:navlist.item href="#" wire:navigate>Transmission</flux:navlist.item>
                            </flux:navlist.group>
                        </flux:navlist>
                    </div>
                    <flux:separator class="md:hidden" />
                    <div class="col-span-1 md:col-span-9 max-md:pt-6">
                        {{ $slot }}
                    </div>
                </div>
            @else
                {{ $slot }}
            @endif
        </flux:main>

        @stack('scripts')
        @fluxScripts
    </body>
</html>
