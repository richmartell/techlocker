<x-layouts.app :title="__('Vehicle Data')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-4">
                <h2 class="text-xl font-bold">Vehicle Technical Data</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Search Section -->
                    <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                        <h3 class="text-lg font-semibold mb-4">Find Vehicle Data</h3>
                        
                        <form class="space-y-4" action="{{ route('vehicle-details', ['registration' => 'placeholder']) }}" method="GET" onsubmit="event.preventDefault(); const reg = this.registration.value.trim(); if(reg) window.location.href = '{{ url('vehicle') }}/' + reg;">
                            <flux:field>
                                <flux:label for="registration">Registration Number</flux:label>
                                <flux:input 
                                    id="registration" 
                                    name="registration"
                                    type="text" 
                                    placeholder="e.g. AB12CDE"
                                    class="uppercase"
                                    oninput="this.value = this.value.toUpperCase()"
                                />
                            </flux:field>
                            
                            <div class="text-center">
                                <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">- or -</flux:text>
                            </div>
                            
                            <flux:field>
                                <flux:label for="make">Make</flux:label>
                                <flux:select id="make" name="make">
                                    <option value="">Select Make</option>
                                    <option value="audi">Audi</option>
                                    <option value="bmw">BMW</option>
                                    <option value="ford">Ford</option>
                                    <option value="land-rover">Land Rover</option>
                                    <option value="mercedes">Mercedes</option>
                                    <option value="toyota">Toyota</option>
                                    <option value="volkswagen">Volkswagen</option>
                                </flux:select>
                            </flux:field>
                            
                            <flux:field>
                                <flux:label for="model">Model</flux:label>
                                <flux:select id="model" name="model" disabled>
                                    <option value="">Select Model</option>
                                </flux:select>
                            </flux:field>
                            
                            <flux:field>
                                <flux:label for="year">Year</flux:label>
                                <flux:select id="year" name="year" disabled>
                                    <option value="">Select Year</option>
                                </flux:select>
                            </flux:field>
                            
                            <flux:field>
                                <flux:label for="engine">Engine</flux:label>
                                <flux:select id="engine" name="engine" disabled>
                                    <option value="">Select Engine</option>
                                </flux:select>
                            </flux:field>
                            
                            <div>
                                <flux:button type="submit" variant="primary" class="w-full">
                                    Search
                                </flux:button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Recent Searches -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Recent Searches</h3>
                        
                        <div class="space-y-3">
                            <flux:card class="p-3">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <flux:heading size="sm">Land Rover Defender 90 (2020)</flux:heading>
                                        <flux:text class="text-sm text-neutral-500">2.0L P300, 300hp</flux:text>
                                    </div>
                                    <a href="{{ url('vehicle/MS02 MUD') }}">
                                        <flux:button variant="primary" size="sm">View</flux:button>
                                    </a>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-3">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <flux:heading size="sm">Ford Focus (2020)</flux:heading>
                                        <flux:text class="text-sm text-neutral-500">1.5L EcoBoost, 150hp</flux:text>
                                    </div>
                                    <flux:button variant="primary" size="sm">View</flux:button>
                                </div>
                            </flux:card>
                            
                            <flux:card class="p-3">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <flux:heading size="sm">Audi A4 (2021)</flux:heading>
                                        <flux:text class="text-sm text-neutral-500">2.0L TFSI, 204hp</flux:text>
                                    </div>
                                    <flux:button variant="primary" size="sm">View</flux:button>
                                </div>
                            </flux:card>
                        </div>
                    </div>
                </div>
                
                <!-- Data Sources Section -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-4">Available Data Sources</h3>
                    
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 