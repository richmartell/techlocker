<x-layouts.app :title="'Vehicle Adjustments - ' . $carTypeGroup">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-6">
                <!-- Header with Back Button -->
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">{{ $carTypeGroup }} Adjustments</h2>
                    
                </div>

                <!-- Adjustments List -->
                <div class="space-y-6">
                    @foreach($adjustments as $adjustment)
                        <div class="rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                            <!-- Main Adjustment Header -->
                            <div class="bg-neutral-50 dark:bg-neutral-900 p-4">
                                <h3 class="text-lg font-semibold">{{ $adjustment['name'] }}</h3>
                            </div>

                            <!-- Sub-adjustments -->
                            @if(isset($adjustment['subAdjustments']) && !empty($adjustment['subAdjustments']))
                                <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                    @foreach($adjustment['subAdjustments'] as $subAdjustment)
                                        <div class="p-4">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <h4 class="font-medium text-lg mb-2">{{ $subAdjustment['name'] }}</h4>
                                                    
                                                    @if(isset($subAdjustment['value']) && $subAdjustment['value'] !== null)
                                                        <div class="flex items-center gap-2 text-sm">
                                                            <span class="text-neutral-500">Value:</span>
                                                            <span class="font-medium">{{ $subAdjustment['value'] }}</span>
                                                            @if(isset($subAdjustment['unit']) && $subAdjustment['unit'] !== null)
                                                                <span class="text-neutral-500">{{ $subAdjustment['unit'] }}</span>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if(isset($subAdjustment['remark']) && $subAdjustment['remark'] !== null)
                                                        <div class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                                                            <span class="font-medium">Note:</span> {{ $subAdjustment['remark'] }}
                                                        </div>
                                                    @endif

                                                    @if(isset($subAdjustment['imageName']) && $subAdjustment['imageName'] !== null)
                                                        <div class="mt-4">
                                                            <img src="{{ $subAdjustment['imageName'] }}" alt="{{ $subAdjustment['name'] }}" class="max-w-full h-auto rounded-lg">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Nested Sub-adjustments -->
                                            @if(isset($subAdjustment['subAdjustments']) && !empty($subAdjustment['subAdjustments']))
                                                <div class="mt-4 pl-4 border-l-2 border-neutral-200 dark:border-neutral-700">
                                                    @foreach($subAdjustment['subAdjustments'] as $nestedAdjustment)
                                                        <div class="py-2">
                                                            <div class="flex justify-between items-start">
                                                                <div class="flex-1">
                                                                    <h5 class="font-medium">{{ $nestedAdjustment['name'] }}</h5>
                                                                    
                                                                    @if(isset($nestedAdjustment['value']) && $nestedAdjustment['value'] !== null)
                                                                        <div class="flex items-center gap-2 text-sm mt-1">
                                                                            <span class="text-neutral-500">Value:</span>
                                                                            <span class="font-medium">{{ $nestedAdjustment['value'] }}</span>
                                                                            @if(isset($nestedAdjustment['unit']) && $nestedAdjustment['unit'] !== null)
                                                                                <span class="text-neutral-500">{{ $nestedAdjustment['unit'] }}</span>
                                                                            @endif
                                                                        </div>
                                                                    @endif

                                                                    @if(isset($nestedAdjustment['remark']) && $nestedAdjustment['remark'] !== null)
                                                                        <div class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                                                                            <span class="font-medium">Note:</span> {{ $nestedAdjustment['remark'] }}
                                                                        </div>
                                                                    @endif

                                                                    @if(isset($nestedAdjustment['imageName']) && $nestedAdjustment['imageName'] !== null)
                                                                        <div class="mt-2">
                                                                            <img src="{{ $nestedAdjustment['imageName'] }}" alt="{{ $nestedAdjustment['name'] }}" class="max-w-full h-auto rounded-lg">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add any interactive features here if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Add collapsible functionality
            const headers = document.querySelectorAll('.adjustment-header');
            headers.forEach(header => {
                header.addEventListener('click', () => {
                    const content = header.nextElementSibling;
                    content.classList.toggle('hidden');
                });
            });
        });
    </script>
    @endpush
</x-layouts.app> 