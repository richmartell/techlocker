<x-layouts.app :title="__('Vehicle Type Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-4">
                <h2 class="text-xl font-bold">Vehicle Type Details</h2>
                
                <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                    <p class="text-lg">Vehicle Type ID: {{ $typeId }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 