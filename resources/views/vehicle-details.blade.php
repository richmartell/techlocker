<x-layouts.app :title="__('Vehicle Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-4">
                <h2 class="text-xl font-bold">Vehicle Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Vehicle Information -->
                    <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                        <dl class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Registration</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->registration }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Make</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->make }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Model</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->model }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Colour</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ ucwords(strtolower($vehicle->colour)) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Year</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->year_of_manufacture }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Fuel Type</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->fuel_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Engine Capacity</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->engine_capacity }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">MOT Status</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->mot_status }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Tax Status</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->tax_status }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">DVLA Sync</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->last_dvla_sync_at?->diffForHumans() ?? 'Never' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>


            </div>
        </div>
    </div>
</x-layouts.app> 