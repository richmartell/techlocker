<div>
    <flux:heading size="xl" class="mb-6">My Commissions</flux:heading>

    <!-- Filter -->
    <flux:card class="mb-6">
        <div class="p-6">
            <flux:select wire:model.live="statusFilter" label="Filter by Status">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="cancelled">Cancelled</option>
            </flux:select>
        </div>
    </flux:card>

    <!-- Commissions Table -->
    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Account</flux:table.column>
                <flux:table.column>Amount</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Earned Date</flux:table.column>
                <flux:table.column>Paid Date</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($this->commissions as $commission)
                    <flux:table.row :key="$commission->id">
                        <flux:table.cell>
                            <div class="font-medium text-zinc-900 dark:text-white">{{ $commission->account->company_name }}</div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="font-semibold text-zinc-900 dark:text-white">£{{ number_format($commission->amount, 2) }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="$commission->status_color" size="sm">
                                {{ ucfirst($commission->status) }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $commission->earned_at->format('M d, Y') }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($commission->paid_at)
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $commission->paid_at->format('M d, Y') }}</span>
                            @else
                                <span class="text-zinc-500 dark:text-zinc-400">—</span>
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="5" class="text-center text-zinc-500 dark:text-zinc-400 py-8">
                            <div class="flex flex-col items-center gap-4">
                                <svg class="w-16 h-16 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-lg font-medium mb-1">No commissions yet</p>
                                    <p class="text-sm">Commissions will appear here when your customers convert from trials to paid accounts.</p>
                                </div>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if($this->commissions->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $this->commissions->links() }}
            </div>
        @endif
    </flux:card>
</div>
