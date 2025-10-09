<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl" class="mb-2">Edit Quote: {{ $quote->quote_number }}</flux:heading>
                <p class="text-zinc-600 dark:text-zinc-400">
                    Update quote details for {{ $quote->customer->first_name }} {{ $quote->customer->last_name }}
                </p>
            </div>
        </div>
    </div>

    <!-- Customer & Vehicle Info (Read-only) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Customer Info -->
        <flux:card>
            <div class="p-6">
                <flux:heading size="lg" class="mb-4">Customer Details</flux:heading>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Name</p>
                        <p class="font-semibold text-zinc-900 dark:text-white">
                            {{ $quote->customer->first_name }} {{ $quote->customer->last_name }}
                        </p>
                    </div>
                    @if($quote->customer->email)
                        <div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Email</p>
                            <p class="font-semibold text-zinc-900 dark:text-white">{{ $quote->customer->email }}</p>
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
                        <p class="font-semibold text-zinc-900 dark:text-white">{{ $quote->vehicle->registration }}</p>
                    </div>
                    @if($quote->vehicle->make || $quote->vehicle->model)
<div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Make & Model</p>
                            <p class="font-semibold text-zinc-900 dark:text-white">
                                {{ $quote->vehicle->make?->name ?? 'Unknown' }} {{ $quote->vehicle->model?->name ?? 'Unknown' }}
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
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">Quote Items</flux:heading>
                <flux:button wire:click="$set('showAddItemModal', true)" variant="primary">
                    <div class="flex items-center justify-center">
                        <flux:icon.plus class="w-4 h-4 mr-2" />
                        <span>Add Item</span>
                    </div>
                </flux:button>
            </div>
            
            @if(count($quoteItems) > 0)
                <div class="space-y-3 mb-6">
                    @foreach($quoteItems as $itemId => $item)
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-3">
                                        <flux:badge size="sm" :color="$item['type'] === 'labour' ? 'blue' : 'green'">
                                            {{ ucfirst($item['type']) }}
                                        </flux:badge>
                                        <p class="font-medium text-zinc-900 dark:text-white">
                                            {{ $item['description'] }}
                                        </p>
                                    </div>
                                    
                                    @if($item['type'] === 'labour')
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                            <flux:field>
                                                <flux:label>Time (hours)</flux:label>
                                                <flux:input 
                                                    type="number" 
                                                    step="0.1"
                                                    min="0"
                                                    wire:model.blur="quoteItems.{{ $itemId }}.time_hours"
                                                />
                                            </flux:field>
                                            
                                            <flux:field>
                                                <flux:label>Quantity</flux:label>
                                                <flux:input 
                                                    type="number" 
                                                    min="1"
                                                    wire:model.blur="quoteItems.{{ $itemId }}.quantity"
                                                />
                                            </flux:field>
                                            
                                            <div class="flex items-end">
                                                <div class="flex-1">
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">Line Total</p>
                                                    <p class="font-bold text-zinc-900 dark:text-white">
                                                        £{{ number_format($item['time_hours'] * $labourRate * $item['quantity'], 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Parts --}}
                                        @if($item['part_number'])
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">Part #: {{ $item['part_number'] }}</p>
                                        @endif
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                            <flux:field>
                                                <flux:label>Unit Price (£)</flux:label>
                                                <flux:input 
                                                    type="number" 
                                                    step="0.01"
                                                    min="0"
                                                    wire:model.blur="quoteItems.{{ $itemId }}.unit_price"
                                                />
                                            </flux:field>
                                            
                                            <flux:field>
                                                <flux:label>Quantity</flux:label>
                                                <flux:input 
                                                    type="number" 
                                                    min="1"
                                                    wire:model.blur="quoteItems.{{ $itemId }}.quantity"
                                                />
                                            </flux:field>
                                            
                                            <div class="flex items-end">
                                                <div class="flex-1">
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">Line Total</p>
                                                    <p class="font-bold text-zinc-900 dark:text-white">
                                                        £{{ number_format($item['unit_price'] * $item['quantity'], 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
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
                    @endforeach
                </div>
            @else
                <p class="text-zinc-600 dark:text-zinc-400">No items yet. Click "Add Item" to get started.</p>
            @endif
        </div>
    </flux:card>

    <!-- Quote Summary and Actions -->
    <flux:card class="mb-8">
        <div class="p-6">
            <flux:heading size="lg" class="mb-6">Quote Totals</flux:heading>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Quote Totals Display -->
                <div class="space-y-4">
                    <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">Labour Rate:</span>
                                <span class="font-semibold text-zinc-900 dark:text-white">£{{ number_format($labourRate, 2) }}/hr</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">VAT Rate:</span>
                                <span class="font-semibold text-zinc-900 dark:text-white">{{ number_format($vatRate, 0) }}%</span>
                            </div>
                            <div class="flex items-center justify-between text-sm pt-2 border-t border-zinc-200 dark:border-zinc-700">
                                <span class="text-zinc-600 dark:text-zinc-400">Subtotal:</span>
                                <span class="font-semibold text-zinc-900 dark:text-white">£{{ number_format($this->subtotal, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">VAT:</span>
                                <span class="font-semibold text-zinc-900 dark:text-white">£{{ number_format($this->vatAmount, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-lg font-bold pt-2 border-t border-zinc-200 dark:border-zinc-700">
                                <span class="text-zinc-900 dark:text-white">Total:</span>
                                <span class="text-blue-600 dark:text-blue-400">£{{ number_format($this->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quote Details -->
                <div class="space-y-4">
                    <flux:field>
                        <flux:label>Status</flux:label>
                        <flux:select wire:model.live="status">
                            <option value="draft">Draft</option>
                            <option value="sent">Sent</option>
                            <option value="approved">Approved</option>
                            <option value="declined">Declined</option>
                        </flux:select>
                        <flux:error name="status" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Valid Until</flux:label>
                        <flux:input 
                            type="date"
                            wire:model="validUntil"
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
        </div>
    </flux:card>

    <!-- Actions -->
    <div class="flex items-center justify-between gap-4">
        <flux:button 
            variant="outline" 
            href="{{ route('quotes.show', $quote->id) }}"
            wire:navigate
        >
            <div class="flex items-center justify-center">
                <flux:icon.x-mark class="w-4 h-4 mr-2" />
                <span>Cancel</span>
            </div>
        </flux:button>
        
        <flux:button 
            variant="primary"
            wire:click="saveQuote"
            :disabled="count($quoteItems) === 0"
        >
            <div class="flex items-center justify-center">
                <flux:icon.check class="w-4 h-4 mr-2" />
                <span>Save Changes</span>
            </div>
        </flux:button>
    </div>

    <!-- Add Item Modal -->
    <flux:modal wire:model="showAddItemModal" class="max-w-3xl">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <flux:heading size="lg">Add New Item</flux:heading>
                
                <!-- Item Type Selector -->
                <div class="flex gap-2">
                    <flux:button 
                        size="sm"
                        :variant="$newItemType === 'labour' ? 'primary' : 'outline'"
                        wire:click="$set('newItemType', 'labour')"
                    >
                        Labour
                    </flux:button>
                    <flux:button 
                        size="sm"
                        :variant="$newItemType === 'parts' ? 'primary' : 'outline'"
                        wire:click="$set('newItemType', 'parts')"
                    >
                        Parts
                    </flux:button>
                </div>
            </div>
            
            @if($newItemType === 'labour')
                <!-- Labour Form -->
                <div class="space-y-4 mb-6">
                    <flux:field>
                        <flux:label>Description</flux:label>
                        <flux:input 
                            wire:model="newItemDescription" 
                            placeholder="e.g., Oil change, Brake service..."
                        />
                        <flux:error name="newItemDescription" />
                    </flux:field>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <flux:field>
                            <flux:label>Time (hours)</flux:label>
                            <flux:input 
                                type="number" 
                                step="0.1"
                                min="0"
                                wire:model="newItemTimeHours"
                                placeholder="0.5"
                            />
                            <flux:error name="newItemTimeHours" />
                        </flux:field>
                        
                        <flux:field>
                            <flux:label>Quantity</flux:label>
                            <flux:input 
                                type="number" 
                                min="1"
                                wire:model="newItemQuantity"
                            />
                            <flux:error name="newItemQuantity" />
                        </flux:field>
                    </div>
                </div>
            @else
                <!-- Parts Form -->
                <div class="space-y-4 mb-6">
                    <flux:field>
                        <flux:label>Part Number (optional)</flux:label>
                        <flux:input 
                            wire:model="newItemPartNumber" 
                            placeholder="Optional"
                        />
                        <flux:error name="newItemPartNumber" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Part Name</flux:label>
                        <flux:input 
                            wire:model="newItemPartName" 
                            placeholder="e.g., Oil filter, Brake pads..."
                        />
                        <flux:error name="newItemPartName" />
                    </flux:field>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <flux:field>
                            <flux:label>Unit Price (£)</flux:label>
                            <flux:input 
                                type="number" 
                                step="0.01"
                                min="0"
                                wire:model="newItemUnitPrice"
                                placeholder="0.00"
                            />
                            <flux:error name="newItemUnitPrice" />
                        </flux:field>
                        
                        <flux:field>
                            <flux:label>Quantity</flux:label>
                            <flux:input 
                                type="number" 
                                min="1"
                                wire:model="newItemQuantity"
                            />
                            <flux:error name="newItemQuantity" />
                        </flux:field>
                    </div>
                </div>
            @endif
            
            <!-- Modal Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button 
                    variant="ghost"
                    wire:click="$set('showAddItemModal', false)"
                >
                    Cancel
                </flux:button>
                <flux:button 
                    variant="primary"
                    wire:click="addNewItem"
                >
                    <div class="flex items-center justify-center">
                        <flux:icon.plus class="w-4 h-4 mr-2" />
                        <span>Add Item</span>
                    </div>
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
