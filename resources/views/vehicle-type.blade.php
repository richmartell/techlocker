<x-layouts.app :title="$details['fullName']">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-6">
                <!-- Header with Back Button -->
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">{{ $details['fullName'] }}</h2>
                    <a href="{{ route('vehicle-data') }}" class="text-primary-600 hover:text-primary-700">
                        <flux:button size="sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Search
                        </flux:button>
                    </a>
                </div>

                <!-- Vehicle Image and Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Vehicle Image -->
                    <div class="flex justify-center items-center p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                        @if($details['image'])
                            <img src="{{ $details['image'] }}" alt="{{ $details['fullName'] }}" class="max-w-full h-auto">
                        @else
                            <div class="text-center text-neutral-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                No image available
                            </div>
                        @endif
                    </div>

                    <!-- Vehicle Stats -->
                    <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                        <h3 class="text-lg font-semibold mb-4">Vehicle Specifications</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <flux:text class="text-sm text-neutral-500">Engine Code</flux:text>
                                <flux:text class="font-medium">{{ $details['engineCode'] }}</flux:text>
                            </div>
                            <div>
                                <flux:text class="text-sm text-neutral-500">Production Years</flux:text>
                                <flux:text class="font-medium">{{ $details['madeFrom'] }} - {{ $details['madeUntil'] }}</flux:text>
                            </div>
                            <div>
                                <flux:text class="text-sm text-neutral-500">Engine Capacity</flux:text>
                                <flux:text class="font-medium">{{ number_format($details['capacity']) }} cc</flux:text>
                            </div>
                            <div>
                                <flux:text class="text-sm text-neutral-500">Power Output</flux:text>
                                <flux:text class="font-medium">{{ $details['output'] }} kW</flux:text>
                            </div>
                            <div>
                                <flux:text class="text-sm text-neutral-500">Fuel Type</flux:text>
                                <flux:text class="font-medium">{{ implode(', ', $details['fuelType']) }}</flux:text>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subject Cards -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Available Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($details['subjectsByGroup']['mapItems'] as $group)
                            <flux:card class="p-4">
                                <flux:heading size="sm" class="mb-3">{{ $group['key'] }}</flux:heading>
                                <ul class="space-y-2">
                                    @foreach(explode(',', $group['value']) as $subject)
                                        <li class="flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            {{ str_replace('_', ' ', $subject) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </flux:card>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 