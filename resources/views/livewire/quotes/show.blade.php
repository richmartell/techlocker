<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header with Actions -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <flux:heading size="xl" class="mb-2">{{ $quote->quote_number }}</flux:heading>
                <p class="text-zinc-600 dark:text-zinc-400">
                    Created {{ $quote->created_at->format('d/m/Y') }}
                </p>
            </div>
            
            <div class="flex gap-3">
                <flux:button 
                    variant="primary"
                    href="{{ route('quotes.edit', $quote->id) }}"
                    wire:navigate
                >
                    <div class="flex items-center justify-center">
                        <flux:icon.pencil class="w-4 h-4 mr-2" />
                        <span>Edit Quote</span>
                    </div>
                </flux:button>
                
                <flux:button 
                    variant="outline"
                    href="{{ route('quotes.pdf', $quote->id) }}"
                    target="_blank"
                >
                    <div class="flex items-center justify-center">
                        <flux:icon.arrow-down-tray class="w-4 h-4 mr-2" />
                        <span>Download PDF</span>
                    </div>
                </flux:button>
                
                <flux:button 
                    variant="danger"
                    wire:click="deleteQuote"
                    wire:confirm="Are you sure you want to delete this quote?"
                >
                    <div class="flex items-center justify-center">
                        <flux:icon.trash class="w-4 h-4 mr-2" />
                        <span>Delete</span>
                    </div>
                </flux:button>
            </div>
        </div>
        
        <!-- Status Badge -->
        <div class="flex items-center gap-3">
            <flux:badge 
                :color="match($quote->status) {
                    'draft' => 'zinc',
                    'sent' => 'blue',
                    'accepted' => 'green',
                    'rejected' => 'red',
                    'expired' => 'orange',
                    default => 'zinc'
                }"
            >
                {{ ucfirst($quote->status) }}
            </flux:badge>
            
            @if($quote->valid_until)
                <span class="text-sm text-zinc-600 dark:text-zinc-400">
                    Valid until {{ $quote->valid_until->format('d/m/Y') }}
                </span>
            @endif
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
                            {{ $quote->customer->first_name }} {{ $quote->customer->last_name }}
                        </p>
                    </div>
                    @if($quote->customer->email)
                        <div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Email</p>
                            <p class="font-semibold text-zinc-900 dark:text-white">{{ $quote->customer->email }}</p>
                        </div>
                    @endif
                    @if($quote->customer->phone)
                        <div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Phone</p>
                            <p class="font-semibold text-zinc-900 dark:text-white">{{ $quote->customer->phone }}</p>
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
                        <p class="font-semibold text-zinc-900 dark:text-white">
                            <a href="{{ route('vehicle-details', $quote->vehicle->registration) }}" class="text-blue-600 dark:text-blue-400 hover:underline" wire:navigate>
                                {{ $quote->vehicle->registration }}
                            </a>
                        </p>
                    </div>
                    @if($quote->vehicle->haynespro_make || $quote->vehicle->haynespro_model)
                        <div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Make & Model</p>
                            <p class="font-semibold text-zinc-900 dark:text-white">
                                {{ $quote->vehicle->haynespro_make }} {{ $quote->vehicle->haynespro_model }}
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
            
            <div class="space-y-3">
                @foreach($quote->items as $item)
                    <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <flux:badge size="sm" :color="$item->type === 'labour' ? 'blue' : 'green'">
                                        {{ ucfirst($item->type) }}
                                    </flux:badge>
                                    <p class="font-medium text-zinc-900 dark:text-white">
                                        {{ $item->description }}
                                    </p>
                                </div>
                                
                                @if($item->type === 'labour')
                                    <div class="flex items-center gap-6 text-sm text-zinc-600 dark:text-zinc-400">
                                        <div>
                                            <span class="font-semibold">Time:</span> 
                                            {{ number_format($item->time_hours, 2) }} hrs
                                        </div>
                                        <div>
                                            <span class="font-semibold">Rate:</span> 
                                            £{{ number_format($item->labour_rate, 2) }}/hr
                                        </div>
                                        <div>
                                            <span class="font-semibold">Qty:</span> 
                                            {{ $item->quantity }}
                                        </div>
                                    </div>
                                @else
                                    {{-- Parts --}}
                                    <div class="flex items-center gap-6 text-sm text-zinc-600 dark:text-zinc-400">
                                        @if($item->part_number)
                                            <div>
                                                <span class="font-semibold">Part #:</span> 
                                                {{ $item->part_number }}
                                            </div>
                                        @endif
                                        <div>
                                            <span class="font-semibold">Unit Price:</span> 
                                            £{{ number_format($item->unit_price, 2) }}
                                        </div>
                                        <div>
                                            <span class="font-semibold">Qty:</span> 
                                            {{ $item->quantity }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <p class="font-bold text-zinc-900 dark:text-white whitespace-nowrap">
                                £{{ number_format($item->line_total, 2) }}
                            </p>
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
                            £{{ number_format($quote->subtotal, 2) }}
                        </span>
                    </div>
                    @if($quote->vat_rate > 0)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-zinc-600 dark:text-zinc-400">VAT ({{ number_format($quote->vat_rate, 0) }}%):</span>
                            <span class="font-semibold text-zinc-900 dark:text-white">
                                £{{ number_format($quote->vat_amount, 2) }}
                            </span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between text-lg font-bold pt-2 border-t border-zinc-200 dark:border-zinc-700">
                        <span class="text-zinc-900 dark:text-white">Total:</span>
                        <span class="text-blue-600 dark:text-blue-400">
                            £{{ number_format($quote->total, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </flux:card>

    <!-- Notes -->
    @if($quote->notes)
        <flux:card class="mb-8">
            <div class="p-6">
                <flux:heading size="lg" class="mb-4">Additional Notes</flux:heading>
                <p class="text-zinc-600 dark:text-zinc-400 whitespace-pre-line">{{ $quote->notes }}</p>
            </div>
        </flux:card>
    @endif

    <!-- Back Button -->
    <div class="flex justify-start">
        <flux:button 
            variant="outline" 
            href="{{ route('vehicle-details', $quote->vehicle->registration) }}"
            wire:navigate
        >
            <div class="flex items-center justify-center">
                <flux:icon.arrow-left class="w-4 h-4 mr-2" />
                <span>Back to Vehicle</span>
            </div>
        </flux:button>
    </div>
</div>
