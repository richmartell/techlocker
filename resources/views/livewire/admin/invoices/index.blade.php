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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
            </div>
        </div>
    </flux:card>

    <!-- Invoices Table -->
    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Invoice #</flux:table.column>
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
                    <flux:table.row :key="$invoice->id">
                        <flux:table.cell>
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $invoice->invoice_number }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <a href="{{ route('admin.accounts.show', $invoice->account) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                {{ $invoice->account->company_name }}
                            </a>
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($invoice->plan)
                                <flux:badge color="blue" size="sm">{{ $invoice->plan->name }}</flux:badge>
                            @else
                                <span class="text-zinc-500 dark:text-zinc-400">—</span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="font-semibold text-zinc-900 dark:text-white">£{{ number_format($invoice->amount, 2) }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $invoice->issue_date->format('M d, Y') }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="text-sm">
                                {{ $invoice->due_date->format('M d, Y') }}
                                @if($invoice->isOverdue())
                                    <span class="text-red-600 dark:text-red-400 font-medium">(Overdue)</span>
                                @endif
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="$invoice->status_color" size="sm">
                                {{ ucfirst($invoice->status) }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:button size="sm" variant="ghost" icon="eye">
                                View
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="8" class="text-center text-zinc-500 dark:text-zinc-400 py-8">
                            No invoices found.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $this->invoices->links() }}
        </div>
    </flux:card>
</div>
