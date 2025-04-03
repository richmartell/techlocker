<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-semibold">Monthly Revenue</h3>
                    <p class="text-2xl font-bold">$24,500</p>
                    <p class="text-sm text-green-600 dark:text-green-400">+12% from last month</p>
                    
                </div>
            </div>
            <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-semibold">New Customers</h3>
                    <p class="text-2xl font-bold">156</p>
                    <p class="text-sm text-green-600 dark:text-green-400">+8% from last month</p>
                    
                </div>
            </div>
            <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-semibold">Conversion Rate</h3>
                    <p class="text-2xl font-bold">24.8%</p>
                    <p class="text-sm text-red-600 dark:text-red-400">-2.1% from last month</p>
                    
                </div>
            </div>
        </div>
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-4">
                <h2 class="text-xl font-bold">Annual Performance Overview</h2>
                
                <!-- Annual Performance Chart -->
                <livewire:dashboard.performance-chart />
            </div>
        </div>
    </div>
</x-layouts.app>
