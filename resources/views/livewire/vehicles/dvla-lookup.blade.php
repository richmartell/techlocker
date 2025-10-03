<div>
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="xl">DVLA Vehicle Lookup</flux:heading>
            <flux:button variant="ghost" href="javascript:history.back()">
                Back
            </flux:button>
        </div>

        <!-- Search Form -->
        <flux:card class="mb-6">
            <div class="p-6">
                <form wire:submit="lookup" class="space-y-4">
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <flux:input 
                                wire:model="registration" 
                                label="Vehicle Registration Number" 
                                placeholder="e.g., AB12 CDE"
                                maxlength="8"
                                required
                                class="uppercase"
                            />
                            @error('registration') 
                                <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-end gap-2">
                            <flux:button type="submit" variant="primary" :disabled="$loading">
                                @if($loading)
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Looking up...
                                @else
                                    Search
                                @endif
                            </flux:button>
                            @if($vehicleData || $error)
                                <flux:button type="button" variant="ghost" wire:click="clear">
                                    Clear
                                </flux:button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </flux:card>

        <!-- Error Message -->
        @if($error)
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-red-900 dark:text-red-100">Error</h3>
                        <p class="text-sm text-red-700 dark:text-red-300 mt-1">{{ $error }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- DVLA Vehicle Data -->
        @if($vehicleData)
            <flux:card class="mb-6">
                <div class="p-6">
                    <flux:heading size="lg" class="mb-4">Vehicle Details (DVLA)</flux:heading>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($vehicleData as $key => $value)
                            <div>
                                <label class="text-sm font-medium text-zinc-600 dark:text-zinc-400">
                                    {{ ucwords(str_replace('_', ' ', \Illuminate\Support\Str::snake($key))) }}
                                </label>
                                <p class="text-zinc-900 dark:text-white mt-1">
                                    @if(is_array($value))
                                        {{ json_encode($value) }}
                                    @elseif(is_bool($value))
                                        {{ $value ? 'Yes' : 'No' }}
                                    @else
                                        {{ $value ?? '—' }}
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </flux:card>
        @endif

        <!-- MOT History -->
        @if($motHistory)
            <flux:card>
                <div class="p-6">
                    <flux:heading size="lg" class="mb-4">MOT History</flux:heading>
                    
                    @if(is_array($motHistory) && count($motHistory) > 0)
                        <div class="space-y-4">
                            @foreach($motHistory as $test)
                                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="font-semibold text-zinc-900 dark:text-white">
                                                {{ $test['testResult'] ?? 'Unknown Result' }}
                                            </h3>
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                Test Date: {{ $test['completedDate'] ?? 'Unknown' }}
                                            </p>
                                        </div>
                                        <flux:badge 
                                            :color="($test['testResult'] ?? '') === 'PASSED' ? 'green' : 'red'"
                                        >
                                            {{ $test['testResult'] ?? 'Unknown' }}
                                        </flux:badge>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-3">
                                        <div>
                                            <span class="text-zinc-600 dark:text-zinc-400">Mileage:</span>
                                            <span class="font-medium text-zinc-900 dark:text-white ml-1">
                                                {{ isset($test['odometerValue']) ? number_format($test['odometerValue']) : '—' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-zinc-600 dark:text-zinc-400">Expiry:</span>
                                            <span class="font-medium text-zinc-900 dark:text-white ml-1">
                                                {{ $test['expiryDate'] ?? '—' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-zinc-600 dark:text-zinc-400">Test Number:</span>
                                            <span class="font-mono text-xs text-zinc-900 dark:text-white ml-1">
                                                {{ $test['motTestNumber'] ?? '—' }}
                                            </span>
                                        </div>
                                    </div>

                                    @if(!empty($test['rfrAndComments']))
                                        <div class="mt-3 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                            <h4 class="font-medium text-sm text-zinc-900 dark:text-white mb-2">Issues & Advisories:</h4>
                                            <div class="space-y-2">
                                                @foreach($test['rfrAndComments'] as $comment)
                                                    <div class="flex gap-2">
                                                        <span class="text-xs font-semibold px-2 py-1 rounded {{ $comment['type'] === 'FAIL' ? 'bg-red-100 text-red-700 dark:bg-red-900/20 dark:text-red-400' : ($comment['type'] === 'ADVISORY' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400') }}">
                                                            {{ $comment['type'] ?? 'INFO' }}
                                                        </span>
                                                        <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                                            {{ $comment['text'] ?? 'No description' }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-zinc-500 dark:text-zinc-400 text-center py-8">
                            No MOT history available for this vehicle.
                        </p>
                    @endif
                </div>
            </flux:card>
        @elseif($vehicleData && !$motHistory)
            <flux:card>
                <div class="p-6">
                    <flux:heading size="lg" class="mb-4">MOT History</flux:heading>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            MOT history is not available. This could be because the vehicle is new, exempt from MOT, or the MOT API is not configured.
                        </p>
                    </div>
                </div>
            </flux:card>
        @endif
    </div>
</div>
