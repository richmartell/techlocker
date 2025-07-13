<div>
    <!-- Status Button -->
    <button 
        wire:click="showStatus"
        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors"
    >
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Haynes API Status
    </button>

    <!-- Status Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div class="relative w-full max-w-4xl bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden">
                <!-- Modal Header -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-neutral-700 border-b border-gray-200 dark:border-neutral-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Haynes API Status Check
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                Checking connectivity and functionality of the Haynes API integration
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if(!$isRunningChecks)
                                <button 
                                    wire:click="refreshStatus"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-neutral-600 border border-gray-300 dark:border-neutral-500 rounded-md hover:bg-gray-50 dark:hover:bg-neutral-500 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Refresh
                                </button>
                            @endif
                            <button 
                                wire:click="closeModal"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 max-h-96 overflow-y-auto">
                    @if($isRunningChecks)
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full mb-4">
                                <svg class="w-8 h-8 text-primary-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Running Status Checks</h3>
                            <p class="text-gray-600 dark:text-gray-300">Please wait while we test the API connection...</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($statusChecks as $key => $check)
                                <div class="border border-gray-200 dark:border-neutral-600 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $check['name'] }}
                                        </h3>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            @if($check['status'] === 'success') 
                                                bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @elseif($check['status'] === 'failed') 
                                                bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @else 
                                                bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                            @endif
                                        ">
                                            @if($check['status'] === 'success')
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                DONE
                                            @elseif($check['status'] === 'failed')
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                FAILED
                                            @else
                                                <svg class="w-4 h-4 mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                PENDING
                                            @endif
                                        </span>
                                    </div>
                                    
                                    @if($check['message'])
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                                            {{ $check['message'] }}
                                        </p>
                                    @endif

                                    @if(!empty($check['details']))
                                        <div class="bg-gray-50 dark:bg-neutral-700 rounded-md p-3">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Details:</h4>
                                            <dl class="grid grid-cols-1 gap-2 text-sm">
                                                @foreach($check['details'] as $label => $value)
                                                    <div class="flex justify-between">
                                                        <dt class="text-gray-500 dark:text-gray-400 font-medium">{{ $label }}:</dt>
                                                        <dd class="text-gray-900 dark:text-white text-right max-w-xs truncate" title="{{ $value }}">{{ $value }}</dd>
                                                    </div>
                                                @endforeach
                                            </dl>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Overall Status Summary -->
                        <div class="mt-6 p-4 rounded-lg border-2 
                            @php
                                $overallStatus = 'success';
                                foreach($statusChecks as $check) {
                                    if($check['status'] === 'failed') {
                                        $overallStatus = 'failed';
                                        break;
                                    } elseif($check['status'] === 'pending') {
                                        $overallStatus = 'pending';
                                    }
                                }
                            @endphp
                            @if($overallStatus === 'success') 
                                border-green-200 bg-green-50 dark:border-green-700 dark:bg-green-900/20
                            @elseif($overallStatus === 'failed') 
                                border-red-200 bg-red-50 dark:border-red-700 dark:bg-red-900/20
                            @else 
                                border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700
                            @endif
                        ">
                            <div class="flex items-center">
                                @if($overallStatus === 'success')
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h3 class="text-lg font-medium text-green-800 dark:text-green-200">API Status: Online</h3>
                                        <p class="text-sm text-green-700 dark:text-green-300">All Haynes API connections are working properly.</p>
                                    </div>
                                @elseif($overallStatus === 'failed')
                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h3 class="text-lg font-medium text-red-800 dark:text-red-200">API Status: Issues Detected</h3>
                                        <p class="text-sm text-red-700 dark:text-red-300">Some Haynes API connections are experiencing problems. Check the details above.</p>
                                    </div>
                                @else
                                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-400 mr-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">API Status: Checking...</h3>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">Status check in progress.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-neutral-700 border-t border-gray-200 dark:border-neutral-600">
                    <div class="flex justify-end">
                        <button 
                            wire:click="closeModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-neutral-600 border border-gray-300 dark:border-neutral-500 rounded-md hover:bg-gray-50 dark:hover:bg-neutral-500 transition-colors"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
