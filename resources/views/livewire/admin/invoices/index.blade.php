<div>
    <flux:heading size="xl" class="mb-6">Invoices & Billing</flux:heading>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <flux:card>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Revenue</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">£{{ number_format($this->totalRevenue, 2) }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </flux:card>

        <flux:card>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Pending Revenue</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">£{{ number_format($this->pendingRevenue, 2) }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </flux:card>

        <flux:card>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Overdue Invoices</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $this->overdueCount }}</p>
                    </div>
                    <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </flux:card>
    </div>

    <!-- Filters -->
    <flux:card class="mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <flux:input 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search by invoice # or account..."
                        label="Search"
                    />
                </div>
                <div>
                    <flux:select wire:model.live="status" label="Status">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="failed">Failed</option>
                        <option value="refunded">Refunded</option>
                        <option value="cancelled">Cancelled</option>
                    </flux:select>
                </div>
                <div>
                    <flux:select wire:model.live="source" label="Source">
                        <option value="">All Sources</option>
                        <option value="reseller">Reseller Managed</option>
                        <option value="stripe">Stripe Direct</option>
                    </flux:select>
                </div>
            </div>
        </div>
    </flux:card>

    <!-- Invoices Table -->
    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Invoice #</flux:table.column>
                <flux:table.column>Source</flux:table.column>
                <flux:table.column>Account</flux:table.column>
                <flux:table.column>Plan</flux:table.column>
                <flux:table.column>Amount</flux:table.column>
                <flux:table.column>Issue Date</flux:table.column>
                <flux:table.column>Due Date</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($this->invoices as $invoice)
                    <flux:table.row :key="$invoice['id']">
                        <flux:table.cell>
                            <span class="font-medium text-zinc-900 dark:text-white font-mono text-xs">{{ $invoice['invoice_number'] }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($invoice['source'] === 'stripe')
                                <flux:badge color="purple" size="sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                    </svg>
                                    Stripe
                                </flux:badge>
                            @else
                                <flux:badge color="blue" size="sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                    Reseller
                                </flux:badge>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($invoice['account_id'])
                                <a href="{{ route('admin.accounts.show', $invoice['account_id']) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $invoice['account_name'] }}
                                </a>
                            @else
                                <span class="text-zinc-900 dark:text-white">{{ $invoice['account_name'] }}</span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($invoice['plan_name'])
                                <flux:badge color="blue" size="sm">{{ $invoice['plan_name'] }}</flux:badge>
                            @else
                                <span class="text-zinc-500 dark:text-zinc-400">—</span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="font-semibold text-zinc-900 dark:text-white">
                                {{ strtoupper($invoice['currency']) }} {{ number_format($invoice['amount'], 2) }}
                            </span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $invoice['issue_date']->format('M d, Y') }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="text-sm">
                                @if($invoice['due_date'])
                                    {{ $invoice['due_date']->format('M d, Y') }}
                                    @if($invoice['status'] === 'pending' && $invoice['due_date']->isPast())
                                        <span class="text-red-600 dark:text-red-400 font-medium">(Overdue)</span>
                                    @endif
                                @else
                                    <span class="text-zinc-500 dark:text-zinc-400">—</span>
                                @endif
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="match($invoice['status']) {
                                'paid' => 'green',
                                'pending' => 'yellow',
                                'failed' => 'red',
                                'refunded' => 'zinc',
                                'cancelled' => 'zinc',
                                default => 'zinc'
                            }" size="sm">
                                {{ ucfirst($invoice['status']) }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($invoice['source'] === 'stripe')
                                <div class="flex gap-2">
                                    @if($invoice['stripe_invoice_url'])
                                        <a href="{{ $invoice['stripe_invoice_url'] }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                                <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                            </svg>
                                            View
                                        </a>
                                    @endif
                                    @if($invoice['stripe_invoice_pdf'])
                                        <a href="{{ $invoice['stripe_invoice_pdf'] }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                            </svg>
                                            PDF
                                        </a>
                                    @endif
                                </div>
                            @else
                                <flux:button size="sm" variant="ghost" wire:click="viewInvoice('{{ $invoice['id'] }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    View
                                </flux:button>
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="9" class="text-center text-zinc-500 dark:text-zinc-400 py-8">
                            No invoices found.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            <div class="text-sm text-zinc-600 dark:text-zinc-400">
                Showing {{ $this->invoices->count() }} invoice(s)
            </div>
        </div>
    </flux:card>

    <!-- Invoice Details Modal -->
    @if($showInvoiceModal && $selectedInvoice)
        <flux:modal name="invoice-details-modal" :open="$showInvoiceModal" wire:model="showInvoiceModal">
            <div class="space-y-6 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <flux:heading size="lg">Invoice Details</flux:heading>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                            Invoice #{{ $selectedInvoice['invoice_number'] }}
                        </p>
                    </div>
                    <flux:badge :color="match($selectedInvoice['status']) {
                        'paid' => 'green',
                        'pending' => 'yellow',
                        'failed' => 'red',
                        'cancelled' => 'zinc',
                        default => 'zinc'
                    }">
                        {{ ucfirst($selectedInvoice['status']) }}
                    </flux:badge>
                </div>

                <flux:separator />

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">Account</h4>
                        <p class="text-base font-medium text-zinc-900 dark:text-white">
                            <a href="{{ route('admin.accounts.show', $selectedInvoice['account_id']) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                {{ $selectedInvoice['account_name'] }}
                            </a>
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">Plan</h4>
                        <p class="text-base text-zinc-900 dark:text-white">
                            @if($selectedInvoice['plan_name'])
                                {{ $selectedInvoice['plan_name'] }}
                            @else
                                <span class="text-zinc-500 dark:text-zinc-400">—</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">Amount</h4>
                        <p class="text-2xl font-bold text-zinc-900 dark:text-white">
                            {{ $selectedInvoice['currency'] }} {{ number_format($selectedInvoice['amount'], 2) }}
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">Status</h4>
                        <p class="text-base text-zinc-900 dark:text-white">
                            {{ ucfirst($selectedInvoice['status']) }}
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">Issue Date</h4>
                        <p class="text-base text-zinc-900 dark:text-white">
                            {{ $selectedInvoice['issue_date']->format('F d, Y') }}
                        </p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">Due Date</h4>
                        <p class="text-base text-zinc-900 dark:text-white">
                            @if($selectedInvoice['due_date'])
                                {{ $selectedInvoice['due_date']->format('F d, Y') }}
                                @if($selectedInvoice['status'] === 'pending' && $selectedInvoice['due_date']->isPast())
                                    <span class="text-red-600 dark:text-red-400 text-sm font-medium">(Overdue)</span>
                                @endif
                            @else
                                <span class="text-zinc-500 dark:text-zinc-400">—</span>
                            @endif
                        </p>
                    </div>

                    @if($selectedInvoice['paid_at'])
                        <div class="col-span-2">
                            <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">Paid On</h4>
                            <p class="text-base text-zinc-900 dark:text-white">
                                {{ $selectedInvoice['paid_at']->format('F d, Y') }}
                            </p>
                        </div>
                    @endif

                    @if($selectedInvoice['notes'])
                        <div class="col-span-2">
                            <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">Notes</h4>
                            <p class="text-sm text-zinc-700 dark:text-zinc-300 bg-zinc-50 dark:bg-zinc-800 p-3 rounded-lg">
                                {{ $selectedInvoice['notes'] }}
                            </p>
                        </div>
                    @endif
                </div>

                <flux:separator />

                <div class="flex justify-end gap-2">
                    <flux:button wire:click="closeInvoiceModal" variant="ghost">
                        Close
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
