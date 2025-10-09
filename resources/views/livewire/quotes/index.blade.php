<div>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl" class="mb-2">Quotes</flux:heading>
                <p class="text-zinc-600 dark:text-zinc-400">
                    Manage all your customer quotes
                </p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <flux:card class="mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Search</flux:label>
                    <flux:input 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search by quote number, customer name, or registration..."
                    />
                </flux:field>
                
                <flux:field>
                    <flux:label>Status</flux:label>
                    <flux:select wire:model.live="statusFilter">
                        <option value="">All Statuses</option>
                        <option value="draft">Draft</option>
                        <option value="sent">Sent</option>
                        <option value="approved">Approved</option>
                        <option value="declined">Declined</option>
                    </flux:select>
                </flux:field>
            </div>
        </div>
    </flux:card>

    <!-- Quotes Table -->
    <flux:card>
        @if($quotes->count())
            <div class="overflow-x-auto">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Quote No.</flux:table.column>
                        <flux:table.column>Date</flux:table.column>
                        <flux:table.column>Customer</flux:table.column>
                        <flux:table.column>Vehicle</flux:table.column>
                        <flux:table.column>Amount</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column>Actions</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach($quotes as $quote)
                            <flux:table.row :key="$quote->id">
                                <flux:table.cell>
                                    <span class="font-mono text-sm font-semibold">
                                        {{ $quote->quote_number }}
                                    </span>
                                </flux:table.cell>
                                
                                <flux:table.cell>
                                    <div class="text-sm">
                                        {{ $quote->created_at->format('d M Y') }}
                                    </div>
                                </flux:table.cell>
                                
                                <flux:table.cell>
                                    <div>
                                        <p class="font-semibold text-zinc-900 dark:text-white">
                                            {{ $quote->customer->first_name }} {{ $quote->customer->last_name }}
                                        </p>
                                        @if($quote->customer->organisation)
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                {{ $quote->customer->organisation }}
                                            </p>
                                        @endif
                                    </div>
                                </flux:table.cell>
                                
                                <flux:table.cell>
                                    <span class="font-mono text-sm font-semibold">
                                        {{ $quote->vehicle->registration }}
                                    </span>
                                </flux:table.cell>
                                
                                <flux:table.cell>
                                    <span class="font-semibold text-zinc-900 dark:text-white">
                                        £{{ number_format($quote->total, 2) }}
                                    </span>
                                </flux:table.cell>
                                
                                <flux:table.cell>
                                    @if($quote->status === 'draft')
                                        <flux:badge color="zinc" size="sm">Draft</flux:badge>
                                    @elseif($quote->status === 'sent')
                                        <flux:badge color="blue" size="sm">Sent</flux:badge>
                                    @elseif($quote->status === 'approved')
                                        <flux:badge color="green" size="sm">Approved</flux:badge>
                                    @elseif($quote->status === 'declined')
                                        <flux:badge color="red" size="sm">Declined</flux:badge>
                                    @endif
                                </flux:table.cell>
                                
                                <flux:table.cell>
                                    <div class="flex gap-2">
                                        <flux:button 
                                            size="sm" 
                                            variant="outline"
                                            :href="route('quotes.show', $quote->id)"
                                            wire:navigate
                                        >
                                            View
                                        </flux:button>
                                        <flux:button 
                                            size="sm" 
                                            variant="ghost"
                                            :href="route('quotes.edit', $quote->id)"
                                            wire:navigate
                                        >
                                            <flux:icon.pencil class="w-4 h-4" />
                                        </flux:button>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </div>
            
            <!-- Pagination -->
            @if($quotes->hasPages())
                <div class="mt-4">
                    {{ $quotes->links() }}
                </div>
            @endif
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <flux:heading size="lg" class="mb-2">No quotes found</flux:heading>
                <flux:text>
                    @if($search || $statusFilter)
                        Try adjusting your search or filters
                    @else
                        Create your first quote to get started
                    @endif
                </flux:text>
            </div>
        @endif
    </flux:card>
</div>
