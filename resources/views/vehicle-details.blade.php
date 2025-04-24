<x-layouts.app :title="__('Vehicle Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <div class="flex flex-col gap-4">
                    <h2 class="text-xl font-bold">{{ $registration }} - {{ $make }} {{ $model }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Vehicle Information Card -->
                        <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                            <h3 class="text-lg font-semibold mb-4">Vehicle Information</h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-neutral-500 dark:text-neutral-400">Registration:</span>
                                    <span class="font-medium">{{ $registration }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-neutral-500 dark:text-neutral-400">Make:</span>
                                    <span class="font-medium">{{ $make }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-neutral-500 dark:text-neutral-400">Model:</span>
                                    <span class="font-medium">{{ $model }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-neutral-500 dark:text-neutral-400">Year:</span>
                                    <span class="font-medium">{{ $year }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-neutral-500 dark:text-neutral-400">Engine:</span>
                                    <span class="font-medium">{{ $engine }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-neutral-500 dark:text-neutral-400">Power:</span>
                                    <span class="font-medium">{{ $power }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-neutral-500 dark:text-neutral-400">Transmission:</span>
                                    <span class="font-medium">{{ $transmission }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Vehicle Image Card -->
                        <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                            <h3 class="text-lg font-semibold mb-4">Vehicle Image</h3>
                            <div class="flex items-center justify-center h-full">
                                <img 
                                    src="{{ asset('images/defender.jpeg') }}" 
                                    alt="{{ $make }} {{ $model }}"
                                    class="w-full h-auto object-cover rounded-lg shadow-sm"
                                    onerror="this.src='{{ asset('images/defender.jpeg') }}'; this.onerror=null;"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Data Sources Section -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4">Resources</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Technical Specifications</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Engine specs, dimensions, weights, and performance data</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Service Procedures</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Step-by-step repair guides and maintenance procedures</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Wiring Diagrams</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Electrical system diagrams and component locations</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Adjustments</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Calibration and adjustment specifications for vehicle systems</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Technical Drawings</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Detailed technical illustrations and exploded views</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">EOBD Locations</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Diagnostic connector locations and pin assignments</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Guided Diagnostics</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Step-by-step diagnostic procedures for troubleshooting</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Lubricants</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Recommended oils, fluids, and capacities</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Repair Time</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Standard repair times for common service operations</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Maintenance</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Scheduled maintenance intervals and procedures</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Engine Management</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">ECU data, sensor values, and control strategies</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Procedures</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Detailed repair and service procedures with illustrations</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Fuse Locations</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Fuse box diagrams and circuit protection information</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">Common Problems</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Known issues, recalls, and technical service bulletins</flux:text>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-4">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <flux:heading size="sm">MOT History</flux:heading>
                                    <flux:text class="text-sm text-neutral-500 mt-2">Complete MOT test history and advisory notices</flux:text>
                                </div>
                            </flux:card>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
    </div>
</x-layouts.app> 