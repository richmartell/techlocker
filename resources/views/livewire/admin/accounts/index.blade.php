<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Accounts Management</flux:heading>
        <flux:button href="{{ route('admin.dashboard') }}" variant="ghost">
            Back to Dashboard
        </flux:button>
    </div>

    <!-- Filters -->
    <flux:card class="mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <flux:input 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search accounts..."
                        label="Search"
                    />
                </div>
                <div>
                    <flux:select wire:model.live="trialStatus" label="Trial Status">
                        <option value="">All Trials</option>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                        <option value="converted">Converted</option>
                        <option value="none">No Trial</option>
                    </flux:select>
                </div>
                <div>
                    <flux:select wire:model.live="planFilter" label="Plan">
                        <option value="">All Plans</option>
                        <option value="none">No Plan</option>
                        @foreach(\App\Models\Plan::all() as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                        @endforeach
                    </flux:select>
                </div>
            </div>
        </div>
    </flux:card>

    <!-- Accounts Table -->
    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>
                    <button wire:click="sortBy('company_name')" class="flex items-center gap-1">
                        Account Name
                        @if($sortBy === 'company_name')
                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </button>
                </flux:table.column>
                <flux:table.column>Users</flux:table.column>
                <flux:table.column>Plan</flux:table.column>
                <flux:table.column>Trial Status</flux:table.column>
                <flux:table.column>Trial Ends</flux:table.column>
                <flux:table.column>
                    <button wire:click="sortBy('created_at')" class="flex items-center gap-1">
                        Created
                        @if($sortBy === 'created_at')
                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </button>
                </flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($this->accounts as $account)
                    <flux:table.row :key="$account->id">
                        <flux:table.cell>
                            <div>
                                <div class="font-medium text-zinc-900 dark:text-white">{{ $account->company_name }}</div>
                                <div class="text-sm text-zinc-600 dark:text-zinc-400">{{ $account->company_email }}</div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge>{{ $account->users->count() }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($account->plan)
                                <flux:badge color="blue">{{ $account->plan->name }}</flux:badge>
                            @else
                                <span class="text-zinc-500 dark:text-zinc-400">No plan</span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($account->trial_status)
                                @if($account->isOnTrial())
                                    <flux:badge color="yellow">Active</flux:badge>
                                @elseif($account->hasExpiredTrial())
                                    <flux:badge color="red">Expired</flux:badge>
                                @elseif($account->trial_status === 'converted')
                                    <flux:badge color="green">Converted</flux:badge>
                                @endif
                            @else
                                <span class="text-zinc-500 dark:text-zinc-400">No trial</span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($account->trial_ends_at)
                                <div class="text-sm">
                                    {{ $account->trial_ends_at->format('M d, Y') }}
                                    @if($account->isOnTrial())
                                        <span class="text-zinc-600 dark:text-zinc-400">({{ $account->trialDaysRemaining() }} days left)</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-zinc-500 dark:text-zinc-400">—</span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $account->created_at->format('M d, Y') }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:button size="sm" href="{{ route('admin.accounts.show', $account) }}">
                                View
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="7" class="text-center text-zinc-500 dark:text-zinc-400 py-8">
                            No accounts found.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $this->accounts->links() }}
        </div>
    </flux:card>
</div>
