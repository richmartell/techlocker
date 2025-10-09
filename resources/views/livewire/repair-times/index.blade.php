<div>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <flux:icon.clock class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Quote Builder</h1>
        </div>
        <p class="text-zinc-600 dark:text-zinc-400">
            Select vehicle type and browse repair times for {{ $vehicle->registration }}
        </p>
    </div>

    <!-- Loading State -->
    @if($isLoading)
        <flux:card>
            <div class="flex flex-col items-center justify-center py-12">
                <svg class="animate-spin h-12 w-12 text-blue-600 dark:text-blue-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-zinc-600 dark:text-zinc-400">Loading vehicle types...</p>
            </div>
        </flux:card>
    @endif

    <!-- Error State -->
    @if($error)
        <flux:card class="mb-6">
            <div class="p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-1">Error</h3>
                        <p class="text-zinc-600 dark:text-zinc-400">{{ $error }}</p>
                        <div class="mt-4">
                            <flux:button variant="outline" wire:click="loadRepairTimeTypes">
                                <flux:icon.arrow-path class="w-4 h-4 mr-2" />
                                Try Again
                            </flux:button>
                        </div>
                    </div>
                </div>
            </div>
        </flux:card>
    @endif

    <!-- Success Message -->
    @if(session('success'))
        <flux:card class="mb-6">
            <div class="p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-zinc-900 dark:text-zinc-100">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </flux:card>
    @endif

    <!-- Loading Nodes State -->
    @if($isLoadingNodes)
        <flux:card>
            <div class="flex flex-col items-center justify-center py-12">
                <svg class="animate-spin h-12 w-12 text-blue-600 dark:text-blue-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-zinc-600 dark:text-zinc-400">Loading repair times...</p>
            </div>
        </flux:card>
    @endif

    <!-- Repair Time Nodes Display -->
    @if($selectedRepairTimeType && !$isLoadingNodes && count($repairTimeNodes) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Left Column - Quote Builder (2/3 width) -->
            <div class="lg:col-span-2">
                <flux:card>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <flux:heading size="lg">Available Repair Times</flux:heading>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                    {{ $selectedRepairTimeType['make'] }} {{ $selectedRepairTimeType['model'] }} - {{ $selectedRepairTimeType['type'] }}
                                </p>
                            </div>
                            <flux:button variant="outline" wire:click="$set('selectedRepairTimeType', null)">
                                Change Vehicle Type
                            </flux:button>
                        </div>

                <div class="space-y-2">
                    @foreach($repairTimeNodes as $node)
                        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                            <!-- Node Header -->
                            <button 
                                wire:click="toggleNode('{{ $node['id'] ?? '' }}')"
                                class="w-full p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-left"
                                @if(!isset($node['id'])) disabled @endif
                            >
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-2 flex-1">
                                        @if(isset($node['hasSubnodes']) && $node['hasSubnodes'])
                                            <svg 
                                                class="w-5 h-5 text-zinc-500 transition-transform {{ isset($expandedNodes[$node['id']]) ? 'rotate-90' : '' }}"
                                                fill="none" 
                                                stroke="currentColor" 
                                                viewBox="0 0 24 24"
                                            >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        @else
                                            <div class="w-5 h-5"></div>
                                        @endif
                                        
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-zinc-900 dark:text-white">
                                                {{ $node['description'] ?? $node['name'] ?? 'Unknown' }}
                                            </h3>
                                            
                                            @if(isset($node['value']) && $node['value'] > 0)
                                                <div class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                                    <span class="font-semibold">Time:</span> {{ number_format($node['value'] / 100, 2) }} hrs
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        @if($loadingNodeId === ($node['id'] ?? null))
                                            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        @endif
                                        
                                        @if(isset($node['value']) && $node['value'] > 0)
                                            <flux:button 
                                                size="xs" 
                                                variant="primary"
                                                wire:click.stop="addToQuote('{{ $node['id'] }}', '{{ addslashes($node['description'] ?? $node['name'] ?? 'Unknown') }}', {{ $node['value'] }}, '{{ $node['awNumber'] ?? '' }}')"
                                                class="mr-2"
                                            >
                                                <flux:icon.plus class="w-3 h-3" />
                                            </flux:button>
                                        @endif
                                    </div>
                                </div>
                            </button>

                            <!-- Level 1 Subnodes (if expanded) -->
                            @if(isset($expandedNodes[$node['id']]) && count($expandedNodes[$node['id']]) > 0)
                                <div class="border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">
                                    <div class="p-4 space-y-2">
                                        @foreach($expandedNodes[$node['id']] as $subnode)
                                            <div class="border-l-2 border-zinc-300 dark:border-zinc-600">
                                                <!-- Level 1 Subnode Header -->
                                                <button 
                                                    wire:click="toggleNode('{{ $subnode['id'] ?? '' }}')"
                                                    class="w-full pl-7 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-left"
                                                    @if(!isset($subnode['id'])) disabled @endif
                                                >
                                                    <div class="flex items-center justify-between gap-4">
                                                        <div class="flex items-center gap-2 flex-1">
                                                            @if(isset($subnode['hasSubnodes']) && $subnode['hasSubnodes'])
                                                                <svg 
                                                                    class="w-4 h-4 text-zinc-500 transition-transform {{ isset($expandedNodes[$subnode['id']]) ? 'rotate-90' : '' }}"
                                                                    fill="none" 
                                                                    stroke="currentColor" 
                                                                    viewBox="0 0 24 24"
                                                                >
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                                </svg>
                                                            @else
                                                                <div class="w-4 h-4"></div>
                                                            @endif
                                                            
                                                            <div class="flex-1">
                                                                <div class="font-medium text-zinc-900 dark:text-white">
                                                                    {{ $subnode['description'] ?? $subnode['name'] ?? 'Unknown' }}
                                                                </div>
                                                                
                                                                @if(isset($subnode['value']) && $subnode['value'] > 0)
                                                                    <div class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                                                        <span class="font-semibold">Time:</span> {{ number_format($subnode['value'] / 100, 2) }} hrs
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="flex items-center gap-2">
                                                            @if($loadingNodeId === ($subnode['id'] ?? null))
                                                                <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                                </svg>
                                                            @endif
                                                            
                                                            @if(isset($subnode['value']) && $subnode['value'] > 0)
                                                                <flux:button 
                                                                    size="xs" 
                                                                    variant="primary"
                                                                    wire:click.stop="addToQuote('{{ $subnode['id'] }}', '{{ addslashes($subnode['description'] ?? $subnode['name'] ?? 'Unknown') }}', {{ $subnode['value'] }}, '{{ $subnode['awNumber'] ?? '' }}')"
                                                                    class="mr-2"
                                                                >
                                                                    <flux:icon.plus class="w-3 h-3" />
                                                                </flux:button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </button>

                                                <!-- Level 2 Subnodes (if expanded) -->
                                                @if(isset($expandedNodes[$subnode['id']]) && count($expandedNodes[$subnode['id']]) > 0)
                                                    <div class="bg-zinc-100 dark:bg-zinc-800">
                                                        <div class="space-y-1 py-2">
                                                            @foreach($expandedNodes[$subnode['id']] as $subsubnode)
                                                                <div class="pl-14 py-2 border-l-2 border-zinc-400 dark:border-zinc-500 ml-7">
                                                                    <div class="flex items-start justify-between">
                                                                        <div class="flex-1">
                                                                            <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                                                                {{ $subsubnode['description'] ?? $subsubnode['name'] ?? 'Unknown' }}
                                                                            </div>
                                                                            @if(isset($subsubnode['value']) && $subsubnode['value'] > 0)
                                                                                <div class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">
                                                                                    <span class="font-semibold">Time:</span> {{ number_format($subsubnode['value'] / 100, 2) }} hrs
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        @if(isset($subsubnode['value']) && $subsubnode['value'] > 0)
                                                                            <flux:button 
                                                                                size="xs" 
                                                                                variant="primary"
                                                                                wire:click="addToQuote('{{ $subsubnode['id'] }}', '{{ addslashes($subsubnode['description'] ?? $subsubnode['name'] ?? 'Unknown') }}', {{ $subsubnode['value'] }}, '{{ $subsubnode['awNumber'] ?? '' }}')"
                                                                                class="mr-2"
                                                                            >
                                                                                <flux:icon.plus class="w-3 h-3" />
                                                                            </flux:button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                    </div>
                </flux:card>
            </div>

            <!-- Right Column - Quote Basket (1/3 width) -->
            <div class="lg:col-span-1">
                <flux:card class="sticky top-6">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <flux:heading size="lg">Quote Basket</flux:heading>
                            @if(count($quoteItems) > 0)
                                <flux:button size="sm" variant="ghost" wire:click="clearQuote" wire:confirm="Clear all items from quote?">
                                    <flux:icon.trash class="w-4 h-4" />
                                </flux:button>
                            @endif
                        </div>

                        @if(count($quoteItems) === 0)
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">No items in quote</p>
                                <p class="text-xs text-zinc-500 mt-1">Add repair jobs to build a quote</p>
                            </div>
                        @else
                            <!-- Quote Items Summary -->
                            <div class="mb-6">
                                <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg text-center">
                                    <div class="text-2xl font-bold text-zinc-900 dark:text-white">
                                        {{ count($quoteItems) }}
                                    </div>
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ count($quoteItems) === 1 ? 'item' : 'items' }} in quote
                                    </div>
                                    <button 
                                        wire:click="$set('showQuoteModal', true)"
                                        class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline"
                                    >
                                        View items
                                    </button>
                                </div>
                            </div>

                            <!-- Quote Summary -->
                            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4 space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-zinc-600 dark:text-zinc-400">Labour Rate:</span>
                                    <span class="font-semibold text-zinc-900 dark:text-white">£{{ number_format($labourRate, 2) }}/hr</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-zinc-600 dark:text-zinc-400">Total Time:</span>
                                    <span class="font-semibold text-zinc-900 dark:text-white">{{ number_format($this->quoteTotalTime, 2) }} hrs</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-zinc-600 dark:text-zinc-400">Labour Cost:</span>
                                    <span class="font-semibold text-zinc-900 dark:text-white">£{{ number_format($this->quoteTotalLabour, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-zinc-600 dark:text-zinc-400">VAT ({{ $vatRate }}%):</span>
                                    <span class="font-semibold text-zinc-900 dark:text-white">£{{ number_format($this->quoteVat, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between text-lg font-bold pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                    <span class="text-zinc-900 dark:text-white">Total:</span>
                                    <span class="text-blue-600 dark:text-blue-400">£{{ number_format($this->quoteTotal, 2) }}</span>
                                </div>

                                <!-- Actions -->
                                <div class="pt-4">
                                    <flux:button variant="primary" class="w-full" wire:click="openCustomerSearch">
                                        <div class="flex items-center justify-center">
                                            <flux:icon.document-text class="w-4 h-4 mr-2" />
                                            <span>Finalize Quote</span>
                                        </div>
                                    </flux:button>
                                </div>
                            </div>
                        @endif
                    </div>
                </flux:card>
            </div>
        </div>
    @endif

    <!-- Vehicle Type Selection -->
    @if(!$isLoading && !$selectedRepairTimeType && count($repairTimeTypes) > 0)
        <flux:card>
            <div class="p-6">
                <flux:heading size="lg" class="mb-4">Select Vehicle Type</flux:heading>
                <p class="text-zinc-600 dark:text-zinc-400 mb-6">
                    Please select the vehicle configuration to view repair times:
                </p>

                <form wire:submit.prevent="selectRepairTimeType">
                    <div class="space-y-4">
                        <flux:field>
                            <flux:label>Vehicle Type</flux:label>
                            <flux:select wire:model="selectedRepairTimeTypeIndex">
                                <option value="">-- Select a vehicle type --</option>
                                @foreach($repairTimeTypes as $index => $type)
                                    <option value="{{ $index }}">
                                        {{ $type['make'] ?? 'Unknown' }} 
                                        {{ $type['model'] ?? 'Unknown' }} - 
                                        {{ $type['type'] ?? 'Unknown' }}
                                        @if(isset($type['output']))
                                            ({{ $type['output'] }} kW)
                                        @endif
                                        @if(isset($type['madeFrom']) || isset($type['madeUntil']))
                                            - {{ $type['madeFrom'] ?? '?' }} to {{ $type['madeUntil'] ?? 'present' }}
                                        @endif
                                    </option>
                                @endforeach
                            </flux:select>
                            <flux:description>
                                {{ count($repairTimeTypes) }} vehicle type{{ count($repairTimeTypes) !== 1 ? 's' : '' }} found
                            </flux:description>
                        </flux:field>

                        <flux:button type="submit" variant="primary">
                            Continue
                        </flux:button>
                    </div>
                </form>
            </div>
        </flux:card>
    @endif

    <!-- No Data State -->
    @if(!$isLoading && !$error && count($repairTimeTypes) === 0)
        <flux:card>
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Vehicle Types Found</h3>
                <p class="text-zinc-600 dark:text-zinc-400 mb-4">
                    No repair time types are available for this vehicle.
                </p>
                <flux:button variant="outline" wire:click="loadRepairTimeTypes">
                    <flux:icon.arrow-path class="w-4 h-4 mr-2" />
                    Reload
                </flux:button>
            </div>
        </flux:card>
    @endif

    <!-- Quote Items Modal -->
    <flux:modal wire:model="showQuoteModal" class="max-w-2xl">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <flux:heading size="lg">Quote Items</flux:heading>
                <flux:button 
                    size="sm" 
                    variant="ghost" 
                    wire:click="clearQuote" 
                    wire:confirm="Clear all items from quote?"
                >
                    <flux:icon.trash class="w-4 h-4 mr-1" />
                    Clear All
                </flux:button>
            </div>

            @if(count($quoteItems) > 0)
                <div class="space-y-3 max-h-[60vh] overflow-y-auto">
                    @foreach($quoteItems as $item)
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                            <div class="flex items-start justify-between mb-2">
                                <p class="text-sm font-medium text-zinc-900 dark:text-white flex-1 pr-2">
                                    {{ $item['description'] }}
                                </p>
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    wire:click="removeFromQuote('{{ $item['id'] }}')"
                                >
                                    <flux:icon.x-mark class="w-4 h-4" />
                                </flux:button>
                            </div>
                            <div class="flex items-center justify-between text-sm text-zinc-600 dark:text-zinc-400">
                                <div>
                                    <span class="font-semibold">Qty:</span> {{ $item['quantity'] }} 
                                    <span class="mx-2">|</span>
                                    <span class="font-semibold">Time:</span> {{ number_format($item['time'] * $item['quantity'], 2) }} hrs
                                </div>
                                <span class="font-semibold text-zinc-900 dark:text-white">
                                    £{{ number_format($item['labourCost'] * $item['quantity'], 2) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Quote Summary in Modal -->
                <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700 space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-600 dark:text-zinc-400">Labour Rate:</span>
                        <span class="font-semibold text-zinc-900 dark:text-white">£{{ number_format($labourRate, 2) }}/hr</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-600 dark:text-zinc-400">Total Time:</span>
                        <span class="font-semibold text-zinc-900 dark:text-white">{{ number_format($this->quoteTotalTime, 2) }} hrs</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-600 dark:text-zinc-400">Labour Cost:</span>
                        <span class="font-semibold text-zinc-900 dark:text-white">£{{ number_format($this->quoteTotalLabour, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-600 dark:text-zinc-400">VAT ({{ $vatRate }}%):</span>
                        <span class="font-semibold text-zinc-900 dark:text-white">£{{ number_format($this->quoteVat, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-lg font-bold pt-3 border-t border-zinc-200 dark:border-zinc-700">
                        <span class="text-zinc-900 dark:text-white">Total:</span>
                        <span class="text-blue-600 dark:text-blue-400">£{{ number_format($this->quoteTotal, 2) }}</span>
                    </div>
                </div>
            @endif
        </div>
    </flux:modal>

    <!-- Customer Search Modal -->
    <flux:modal wire:model="showCustomerSearchModal" class="max-w-5xl">
        <div class="p-6">
            <flux:heading size="lg" class="mb-4">
                @if($showCreateCustomer)
                    Create New Customer
                @elseif($showConfirmCustomer)
                    Confirm Customer
                @else
                    Select Customer
                @endif
            </flux:heading>
            
            @if($showCreateCustomer)
                <!-- Create Customer Form -->
                <div>
                    <div class="space-y-4 mb-6">
                        <div class="grid grid-cols-2 gap-4">
                            <flux:field>
                                <flux:label>First Name *</flux:label>
                                <flux:input wire:model="newCustomerFirstName" />
                                <flux:error name="newCustomerFirstName" />
                            </flux:field>
                            
                            <flux:field>
                                <flux:label>Last Name *</flux:label>
                                <flux:input wire:model="newCustomerLastName" />
                                <flux:error name="newCustomerLastName" />
                            </flux:field>
                        </div>
                        
                        <flux:field>
                            <flux:label>Organisation / Company</flux:label>
                            <flux:input wire:model="newCustomerOrganisation" placeholder="Optional" />
                            <flux:error name="newCustomerOrganisation" />
                        </flux:field>
                        
                        <flux:field>
                            <flux:label>Email</flux:label>
                            <flux:input type="email" wire:model="newCustomerEmail" />
                            <flux:error name="newCustomerEmail" />
                        </flux:field>
                        
                        <flux:field>
                            <flux:label>Phone</flux:label>
                            <flux:input type="tel" wire:model="newCustomerPhone" />
                            <flux:error name="newCustomerPhone" />
                        </flux:field>
                    </div>
                    
                    <div class="flex gap-3">
                        <flux:button type="button" variant="outline" class="flex-1" wire:click="backToSearch">
                            <div class="flex items-center justify-center">
                                <flux:icon.arrow-left class="w-4 h-4 mr-2" />
                                <span>Back</span>
                            </div>
                        </flux:button>
                        <flux:button type="button" variant="primary" class="flex-1" wire:click="saveNewCustomer">
                            <div class="flex items-center justify-center">
                                <flux:icon.check class="w-4 h-4 mr-2" />
                                <span>Create Customer</span>
                            </div>
                        </flux:button>
                    </div>
                </div>
            @elseif(!$showConfirmCustomer)
                <!-- Linked Customers (Pre-suggestions) -->
                @if(count($linkedCustomers) > 0 && strlen($customerSearchTerm) < 2)
                    <div class="mb-6">
                        <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">
                            Customers linked to this vehicle:
                        </p>
                        <div class="space-y-2">
                            @foreach($linkedCustomers as $customer)
                                <div 
                                    wire:click="selectCustomer('{{ $customer['id'] }}')"
                                    class="p-4 border-2 border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 cursor-pointer transition"
                                >
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p class="font-semibold text-zinc-900 dark:text-white">
                                                {{ $customer['first_name'] }} {{ $customer['last_name'] }}
                                            </p>
                                            @if(!empty($customer['organisation']))
                                                <p class="text-sm text-zinc-700 dark:text-zinc-300 font-medium">
                                                    {{ $customer['organisation'] }}
                                                </p>
                                            @endif
                                            @if(!empty($customer['email']))
                                                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                    {{ $customer['email'] }}
                                                </p>
                                            @endif
                                        </div>
                                        <flux:badge color="blue" size="sm">Linked</flux:badge>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">Or search for a different customer:</p>
                        </div>
                    </div>
                @endif
                
                <!-- Search Section -->
                <div class="mb-6">
                    <flux:field>
                        <flux:label>Search by name, organisation, email, or registration</flux:label>
                        <flux:input 
                            wire:model.live.debounce.300ms="customerSearchTerm" 
                            placeholder="Start typing to search..."
                            type="text"
                        />
                    </flux:field>
                </div>

                <!-- Search Results -->
                @if(strlen($customerSearchTerm) >= 2)
                    <div class="mb-6">
                        @if(count($searchResults) > 0)
                            <div class="space-y-2">
                                @foreach($searchResults as $customer)
                                    <div 
                                        wire:click="selectCustomer('{{ $customer->id }}')"
                                        class="p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer transition"
                                    >
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <p class="font-semibold text-zinc-900 dark:text-white">
                                                    {{ $customer->first_name }} {{ $customer->last_name }}
                                                </p>
                                                @if($customer->organisation)
                                                    <p class="text-sm text-zinc-700 dark:text-zinc-300 font-medium">
                                                        {{ $customer->organisation }}
                                                    </p>
                                                @endif
                                                @if($customer->email)
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                        {{ $customer->email }}
                                                    </p>
                                                @endif
                                                @if($customer->phone)
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                        {{ $customer->phone }}
                                                    </p>
                                                @endif
                                                @if($customer->vehicles && $customer->vehicles->count() > 0)
                                                    <div class="mt-2 flex flex-wrap gap-2">
                                                        @foreach($customer->vehicles as $vehicle)
                                                            <flux:badge size="sm" color="zinc">
                                                                {{ $vehicle->registration }}
                                                            </flux:badge>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <flux:icon.chevron-right class="w-5 h-5 text-zinc-400" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <flux:icon.magnifying-glass class="w-12 h-12 mx-auto text-zinc-300 dark:text-zinc-600 mb-3" />
                                <p class="text-zinc-600 dark:text-zinc-400">No customers found</p>
                                <flux:button 
                                    variant="primary" 
                                    size="sm" 
                                    class="mt-4"
                                    wire:click="createNewCustomer"
                                >
                                    <div class="flex items-center">
                                        <flux:icon.plus class="w-4 h-4 mr-2" />
                                        <span>Create New Customer</span>
                                    </div>
                                </flux:button>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8">
                        <flux:icon.magnifying-glass class="w-12 h-12 mx-auto text-zinc-300 dark:text-zinc-600 mb-3" />
                        <p class="text-zinc-600 dark:text-zinc-400">Type at least 2 characters to search</p>
                    </div>
                @endif

                <!-- Quick Action -->
                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button 
                        variant="outline" 
                        class="w-full"
                        wire:click="createNewCustomer"
                    >
                        <div class="flex items-center justify-center">
                            <flux:icon.plus class="w-4 h-4 mr-2" />
                            <span>Create New Customer</span>
                        </div>
                    </flux:button>
                </div>
            @else
                <!-- Confirm Customer -->
                <div class="mb-6">
                    <div class="p-6 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">Confirm customer details:</p>
                        <div class="space-y-2">
                            <div>
                                <p class="font-semibold text-lg text-zinc-900 dark:text-white">
                                    {{ $selectedCustomer->first_name }} {{ $selectedCustomer->last_name }}
                                </p>
                            </div>
                            @if($selectedCustomer->email)
                                <div class="flex items-center text-sm text-zinc-600 dark:text-zinc-400">
                                    <flux:icon.envelope class="w-4 h-4 mr-2" />
                                    {{ $selectedCustomer->email }}
                                </div>
                            @endif
                            @if($selectedCustomer->phone)
                                <div class="flex items-center text-sm text-zinc-600 dark:text-zinc-400">
                                    <flux:icon.phone class="w-4 h-4 mr-2" />
                                    {{ $selectedCustomer->phone }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <flux:button 
                        variant="outline" 
                        class="flex-1"
                        wire:click="$set('showConfirmCustomer', false)"
                    >
                        Back
                    </flux:button>
                    <flux:button 
                        variant="primary" 
                        class="flex-1"
                        wire:click="confirmCustomerAndProceed"
                    >
                        Continue to Quote
                    </flux:button>
                </div>
            @endif
        </div>
    </flux:modal>
</div>
