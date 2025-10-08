<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl" class="mb-2">Create Quote</flux:heading>
                <p class="text-zinc-600 dark:text-zinc-400">
                    Review and finalize your quote for {{ $customer->first_name }} {{ $customer->last_name }}
                </p>
            </div>
        </div>
    </div>

    <!-- Customer & Vehicle Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Customer Info -->
        <flux:card>
            <div class="p-6">
                <flux:heading size="lg" class="mb-4">Customer Details</flux:heading>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Name</p>
                        <p class="font-semibold text-zinc-900 dark:text-white">
                            {{ $customer->first_name }} {{ $customer->last_name }}
                        </p>
                    </div>
                    @if($customer->email)
                        <div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Email</p>
                            <p class="font-semibold text-zinc-900 dark:text-white">{{ $customer->email }}</p>
                        </div>
                    @endif
                    @if($customer->phone)
                        <div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Phone</p>
                            <p class="font-semibold text-zinc-900 dark:text-white">{{ $customer->phone }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </flux:card>

        <!-- Vehicle Info -->
        <flux:card>
            <div class="p-6">
                <flux:heading size="lg" class="mb-4">Vehicle Details</flux:heading>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Registration</p>
                        <p class="font-semibold text-zinc-900 dark:text-white">{{ $vehicle->registration }}</p>
                    </div>
                    @if($vehicle->combined_vin)
                        <div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">VIN</p>
                            <p class="font-semibold text-zinc-900 dark:text-white font-mono text-xs">
                                {{ $vehicle->combined_vin }}
                            </p>
                        </div>
                    @endif
                    @if($vehicle->make || $vehicle->model)
                        <div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Make & Model</p>
                            <p class="font-semibold text-zinc-900 dark:text-white">
                                {{ $vehicle->make?->name ?? 'Unknown Make' }} {{ $vehicle->model?->name ?? 'Unknown Model' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </flux:card>
    </div>

    <!-- Quote Items -->
    <flux:card class="mb-8">
        <div class="p-6">
            <flux:heading size="lg" class="mb-4">Quote Items</flux:heading>
            
            @if(count($quoteItems) > 0)
                <div class="space-y-3">
                    @foreach($quoteItems as $itemId => $item)
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <p class="font-medium text-zinc-900 dark:text-white mb-2">
                                        {{ $item['description'] }}
                                    </p>
                                    <div class="flex items-center gap-6 text-sm text-zinc-600 dark:text-zinc-400">
                                        <div>
                                            <span class="font-semibold">Time:</span> 
                                            {{ number_format($item['time'], 2) }} hrs
                                        </div>
                                        <div>
                                            <span class="font-semibold">Rate:</span> 
                                            £{{ number_format($labourRate, 2) }}/hr
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold">Quantity:</span>
                                            <input 
                                                type="number" 
                                                min="1" 
                                                value="{{ $item['quantity'] }}"
                                                wire:change="updateItemQuantity('{{ $itemId }}', $event.target.value)"
                                                class="w-16 px-2 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <p class="font-bold text-zinc-900 dark:text-white whitespace-nowrap">
                                        £{{ number_format($item['time'] * $labourRate * $item['quantity'], 2) }}
                                    </p>
                                    <flux:button 
                                        size="sm" 
                                        variant="ghost" 
                                        wire:click="removeItem('{{ $itemId }}')"
                                        wire:confirm="Remove this item from the quote?"
                                    >
                                        <flux:icon.trash class="w-4 h-4" />
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Quote Totals -->
                <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="max-w-md ml-auto space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-zinc-600 dark:text-zinc-400">Subtotal:</span>
                            <span class="font-semibold text-zinc-900 dark:text-white">
                                £{{ number_format($this->subtotal, 2) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-zinc-600 dark:text-zinc-400">VAT ({{ $vatRate }}%):</span>
                            <span class="font-semibold text-zinc-900 dark:text-white">
                                £{{ number_format($this->vatAmount, 2) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-lg font-bold pt-2 border-t border-zinc-200 dark:border-zinc-700">
                            <span class="text-zinc-900 dark:text-white">Total:</span>
                            <span class="text-blue-600 dark:text-blue-400">
                                £{{ number_format($this->total, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <flux:icon.document-text class="w-12 h-12 mx-auto text-zinc-300 dark:text-zinc-600 mb-3" />
                    <p class="text-zinc-600 dark:text-zinc-400">No items in quote</p>
                </div>
            @endif
        </div>
    </flux:card>

    <!-- Additional Details -->
    <flux:card class="mb-8">
        <div class="p-6">
            <flux:heading size="lg" class="mb-4">Additional Details</flux:heading>
            
            <div class="space-y-4">
                <flux:field>
                    <flux:label>Valid Until</flux:label>
                    <flux:input 
                        type="date" 
                        wire:model="validUntil"
                        min="{{ now()->addDays(1)->format('Y-m-d') }}"
                    />
                    <flux:error name="validUntil" />
                </flux:field>

                <flux:field>
                    <flux:label>Notes (optional)</flux:label>
                    <flux:textarea 
                        wire:model="notes"
                        rows="4"
                        placeholder="Add any additional notes or terms for this quote..."
                    />
                    <flux:error name="notes" />
                </flux:field>
            </div>
        </div>
    </flux:card>

    <!-- Actions -->
    <div class="flex items-center justify-between gap-4">
        <flux:button 
            variant="outline" 
            href="{{ route('vehicle-details', $vehicle->registration) }}"
            wire:navigate
        >
            Cancel
        </flux:button>
        
        <div class="flex gap-3">
            <flux:button 
                variant="primary"
                wire:click="saveQuote"
                :disabled="count($quoteItems) === 0"
            >
                <div class="flex items-center justify-center">
                    <flux:icon.check class="w-4 h-4 mr-2" />
                    <span>Save Quote</span>
                </div>
            </flux:button>
        </div>
    </div>
</div>
