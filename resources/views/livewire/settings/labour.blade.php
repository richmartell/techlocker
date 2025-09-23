<section>
    <x-settings.layout>
        <x-slot name="title">{{ __('Labour Settings') }}</x-slot>
        <x-slot name="description">{{ __('Configure hourly rates and time adjustments for labour calculations.') }}</x-slot>

        @if($hasUnsavedChanges)
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                <div class="flex items-center gap-3">
                    <flux:badge color="amber" icon="exclamation-triangle">
                        Unsaved Changes
                    </flux:badge>
                    <flux:button wire:click="save" variant="primary" icon="check" loading="save" size="sm">
                        Save Changes
                    </flux:button>
                </div>
            </div>
        @endif

        {{-- Flash Messages --}}
        @if (session()->has('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <strong>Success:</strong> {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        @endif

        <form wire:submit="save">
            <div class="space-y-6">
                {{-- Hourly Labour Rate --}}
                <flux:field>
                    <flux:label>Hourly Labour Rate (GBP) *</flux:label>
                    <flux:input 
                        wire:model.live="hourly_labour_rate" 
                        type="number" 
                        step="0.01" 
                        min="0" 
                        max="9999.99"
                        placeholder="50.00"
                        :error="$errors->first('hourly_labour_rate')"
                    >
                        <x-slot:prefix>£</x-slot:prefix>
                    </flux:input>
                    <flux:error name="hourly_labour_rate" />
                    <flux:description>
                        The standard hourly rate charged for labour. This will be used to calculate job costs based on time estimates.
                    </flux:description>
                </flux:field>

                {{-- Labour Loading Percentage --}}
                <flux:field>
                    <flux:label>Labour Loading Percentage *</flux:label>
                    <flux:input 
                        wire:model.live="labour_loading_percentage" 
                        type="number" 
                        step="0.01" 
                        min="0" 
                        max="100"
                        placeholder="0.00"
                        :error="$errors->first('labour_loading_percentage')"
                    >
                        <x-slot:suffix>%</x-slot:suffix>
                    </flux:input>
                    <flux:error name="labour_loading_percentage" />
                    <flux:description>
                        Additional percentage to add to Haynes time estimates. For example, 10% will add 10% more time to all job estimates to account for setup, cleanup, or complexity factors.
                    </flux:description>
                </flux:field>

                {{-- Preview Section --}}
                @if($this->estimatedCost)
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="text-sm font-medium text-blue-700 dark:text-blue-300 mb-3">Example: 1 Hour Job</div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-blue-600 dark:text-blue-400">Base time:</span>
                                <span>1.00 hours</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-blue-600 dark:text-blue-400">With {{ $labour_loading_percentage ?: '0' }}% loading:</span>
                                <span>{{ number_format(1 * (1 + (float)($labour_loading_percentage ?: 0) / 100), 2) }} hours</span>
                            </div>
                            <div class="flex justify-between font-medium border-t border-blue-200 dark:border-blue-700 pt-2">
                                <span class="text-blue-700 dark:text-blue-300">Total cost:</span>
                                <span class="text-blue-700 dark:text-blue-300">£{{ $this->estimatedCost }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button 
                        wire:click="resetToDefaults" 
                        variant="ghost" 
                        icon="arrow-path"
                        type="button"
                        size="sm"
                    >
                        Reset to Defaults
                    </flux:button>
                    
                    <flux:button type="submit" variant="primary" icon="check" loading="save">
                        Save Settings
                    </flux:button>
                </div>
            </div>
        </form>
    </x-settings.layout>
</section>