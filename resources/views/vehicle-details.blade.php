<x-layouts.app :title="__('Vehicle Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <x-flux.card class="p-6 h-full flex-1">
            <div class="mb-6">
                <x-flux.heading size="2xl" weight="bold">{{ $registration }} - {{ $make }} {{ $model }}</x-flux.heading>
                <x-flux.text size="sm" class="text-neutral-500 dark:text-neutral-400">{{ $year }}</x-flux.text>
            </div>
        </x-flux.card>
    </div>
</x-layouts.app> 