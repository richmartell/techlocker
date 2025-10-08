<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Resellers Management</flux:heading>
        <flux:button href="{{ route('admin.resellers.create') }}" variant="primary" icon="plus">
            Add Reseller
        </flux:button>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Filters -->
    <flux:card class="mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:input 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search by name, email, or company..."
                        label="Search"
                    />
                </div>
                <div>
                    <flux:select wire:model.live="statusFilter" label="Status">
                        <option value="">All Resellers</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive Only</option>
                    </flux:select>
                </div>
            </div>
        </div>
    </flux:card>

    <!-- Resellers Table -->
    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Reseller</flux:table.column>
                <flux:table.column>Company</flux:table.column>
                <flux:table.column>Accounts</flux:table.column>
                <flux:table.column>Pricing</flux:table.column>
                <flux:table.column>Total Earned</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($this->resellers as $reseller)
                    <flux:table.row :key="$reseller->id">
                        <flux:table.cell>
                            <div>
                                <div class="font-medium text-zinc-900 dark:text-white">{{ $reseller->name }}</div>
                                <div class="text-sm text-zinc-600 dark:text-zinc-400">{{ $reseller->email }}</div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="text-sm text-zinc-900 dark:text-white">{{ $reseller->company_name }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge>{{ $reseller->accounts_count }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-1">
                                @if($reseller->planPrices->count() > 0)
                                    <flux:badge color="green" size="sm">
                                        {{ $reseller->planPrices->count() }} Custom
                                    </flux:badge>
                                @endif
                                @if($reseller->fallback_discount_percentage > 0)
                                    <flux:badge color="blue" size="sm">
                                        {{ number_format($reseller->fallback_discount_percentage, 0) }}% Fallback
                                    </flux:badge>
                                @endif
                                @if($reseller->planPrices->count() == 0 && $reseller->fallback_discount_percentage == 0)
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Not Set</span>
                                @endif
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                £{{ number_format($reseller->commissions_sum_amount ?? 0, 2) }}
                            </span>
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($reseller->is_active)
                                <flux:badge color="green">Active</flux:badge>
                            @else
                                <flux:badge color="red">Inactive</flux:badge>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:button size="sm" href="{{ route('admin.resellers.show', $reseller) }}">
                                View
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="7" class="text-center text-zinc-500 dark:text-zinc-400 py-8">
                            No resellers found.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if($this->resellers->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $this->resellers->links() }}
            </div>
        @endif
    </flux:card>
</div>
