<x-layouts.app :title="'Haynes Inspector - ' . $vehicle->registration">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-6">
                <!-- Header -->
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold">🔍 Haynes Inspector</h1>
                        <p class="text-lg text-neutral-600 dark:text-neutral-400">
                            {{ $vehicle->registration }} - {{ $vehicle->make?->name ?? 'Unknown Make' }} {{ $vehicle->model?->name ?? 'Unknown Model' }}
                            @if($vehicle->haynes_model_variant_description)
                                - {{ $vehicle->haynes_model_variant_description }}
                            @endif
                        </p>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                            Debug and explore all available HaynesPro API calls for this vehicle
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('vehicle-details', $vehicle->registration) }}">
                            <flux:button variant="ghost" size="sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Back to Vehicle Details
                            </flux:button>
                        </a>
                    </div>
                </div>

                <!-- Vehicle Information Summary -->
                <div class="p-4 rounded-xl border border-blue-200 dark:border-blue-700 bg-blue-50 dark:bg-blue-900/20">
                    <h3 class="text-lg font-semibold mb-3 text-blue-800 dark:text-blue-200">Vehicle Context</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-blue-600 dark:text-blue-400 font-medium">Registration:</span>
                            <span class="ml-2 font-mono">{{ $vehicle->registration }}</span>
                        </div>
                        @if($vehicle->car_type_id)
                        <div>
                            <span class="text-blue-600 dark:text-blue-400 font-medium">Car Type ID:</span>
                            <span class="ml-2 font-mono text-green-600 dark:text-green-400">{{ $vehicle->car_type_id }}</span>
                        </div>
                        @endif
                        @if($vehicle->combined_vin)
                        <div>
                            <span class="text-blue-600 dark:text-blue-400 font-medium">VIN:</span>
                            <span class="ml-2 font-mono text-xs">{{ $vehicle->combined_vin }}</span>
                        </div>
                        @endif
                        @if($vehicle->tecdoc_ktype)
                        <div>
                            <span class="text-blue-600 dark:text-blue-400 font-medium">TecDoc KType:</span>
                            <span class="ml-2 font-mono">{{ $vehicle->tecdoc_ktype }}</span>
                        </div>
                        @endif
                        @if($vehicle->car_type_identified_at)
                        <div>
                            <span class="text-blue-600 dark:text-blue-400 font-medium">Identified:</span>
                            <span class="ml-2 text-xs">{{ $vehicle->car_type_identified_at->diffForHumans() }}</span>
                        </div>
                        @endif
                        @if($vehicle->hasCarTypeIdentification() && $vehicle->available_subjects_array)
                        <div>
                            <span class="text-blue-600 dark:text-blue-400 font-medium">Available Subjects:</span>
                            <span class="ml-2 text-xs">{{ count($vehicle->available_subjects_array) }} subjects</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- API Methods by Category -->
                @foreach($apiMethods as $category => $methods)
                    @if(count($methods) > 0)
                        <div class="p-6 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                            <h3 class="text-lg font-semibold mb-4 flex items-center">
                                @if($category === 'General Information')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($category === 'Vehicle Identification')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($category === 'Technical Information')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-orange-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                                {{ $category }}
                                <span class="ml-auto text-sm text-neutral-500 dark:text-neutral-400">({{ count($methods) }} methods)</span>
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($methods as $method)
                                    <div class="p-4 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 hover:shadow-md transition-shadow">
                                        <div class="flex flex-col h-full">
                                            <h4 class="font-medium text-sm mb-2">{{ $method['name'] }}</h4>
                                            <p class="text-xs text-neutral-600 dark:text-neutral-400 mb-3 flex-1">{{ $method['description'] }}</p>
                                            
                                            <div class="mb-3">
                                                <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Method:</div>
                                                <div class="text-xs font-mono bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 p-2 rounded border border-blue-200 dark:border-blue-800">
                                                    {{ $method['method'] }}
                                                </div>
                                            </div>
                                            
                                            @if(count($method['parameters']) > 0)
                                                <div class="mb-3">
                                                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Parameters:</div>
                                                    <div class="text-xs font-mono bg-neutral-100 dark:bg-neutral-700 p-2 rounded">
                                                        @foreach($method['parameters'] as $param => $value)
                                                            <div>{{ $param }}: {{ is_string($value) ? $value : json_encode($value) }}</div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if(in_array($method['method'], ['getAdjustmentsV7', 'getLubricantsV5']))
                                                <div class="flex gap-2">
                                                    <flux:button 
                                                        size="sm" 
                                                        variant="primary" 
                                                        class="flex-1"
                                                        onclick="executeApiMethod('{{ $method['method'] }}', '{{ $method['name'] }}', {{ json_encode($method['parameters']) }})"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                        </svg>
                                                        Execute (JSON)
                                                    </flux:button>
                                                    <flux:button 
                                                        size="sm" 
                                                        variant="outline" 
                                                        class="flex-1"
                                                        onclick="executeApiMethodFormatted('{{ $method['method'] }}', '{{ $method['name'] }}', {{ json_encode($method['parameters']) }})"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Execute (List)
                                                    </flux:button>
                                                </div>
                                            @else
                                                <flux:button 
                                                    size="sm" 
                                                    variant="primary" 
                                                    class="w-full"
                                                    onclick="executeApiMethod('{{ $method['method'] }}', '{{ $method['name'] }}', {{ json_encode($method['parameters']) }})"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                    </svg>
                                                    Execute
                                                </flux:button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                @if(empty($apiMethods) || array_sum(array_map('count', $apiMethods)) === 0)
                    <div class="text-center py-12">
                        <div class="text-neutral-400 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.485 0-4.751.919-6.479 2.43l2.75 2.75-.671.671C8.546 19.896 10.183 20 12 20a8 8 0 108-8v1.081c0 .795-.316 1.557-.879 2.121l-.707-.707-.707.707c.563.563.879 1.326.879 2.121V17" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-neutral-600 dark:text-neutral-400 mb-2">No API Methods Available</h3>
                        <p class="text-neutral-500 dark:text-neutral-400">
                            This vehicle may need additional information (like VIN or TecDoc KType) to access technical API methods.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Response Modal -->
    <div id="responseModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-2xl w-full max-w-4xl mx-4 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-neutral-200 dark:border-neutral-700">
                <div>
                    <h3 class="text-lg font-semibold" id="modalTitle">API Response</h3>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400" id="modalMethod">Method: </p>
                </div>
                <button onclick="closeModal()" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="flex-1 overflow-hidden">
                <div class="p-6 h-full">
                    <div class="h-full bg-neutral-50 dark:bg-neutral-900 rounded-lg overflow-hidden">
                        <pre id="responseContent" class="text-xs font-mono p-4 h-full overflow-auto whitespace-pre-wrap"></pre>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-between p-6 border-t border-neutral-200 dark:border-neutral-700">
                <div class="text-sm text-neutral-500 dark:text-neutral-400" id="responseTimestamp"></div>
                <div class="flex gap-2">
                    <flux:button variant="outline" size="sm" onclick="copyResponse()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 2a1 1 0 000 2h2a1 1 0 100-2H8z" />
                            <path d="M3 5a2 2 0 012-2 3 3 0 003 3h6a3 3 0 003-3 2 2 0 012 2v6h-4.586l1.293-1.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L14.586 13H19v3a2 2 0 01-2 2H5a2 2 0 01-2-2V5zM15 11h2V5h-2v6z" />
                        </svg>
                        Copy JSON
                    </flux:button>
                    <flux:button variant="ghost" size="sm" onclick="closeModal()">Close</flux:button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-40">
        <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 shadow-2xl">
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                <span class="text-lg">Executing API call...</span>
            </div>
        </div>
    </div>

    <script>
        let currentResponse = null;

        function executeApiMethod(method, name, parameters) {
            // Show loading overlay
            document.getElementById('loadingOverlay').classList.remove('hidden');
            document.getElementById('loadingOverlay').classList.add('flex');
            
            // Prepare the request
            const url = `{{ route('haynes-inspector.execute', ['registration' => $vehicle->registration, 'method' => '__METHOD__']) }}`.replace('__METHOD__', method);
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(parameters)
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading overlay
                document.getElementById('loadingOverlay').classList.add('hidden');
                document.getElementById('loadingOverlay').classList.remove('flex');
                
                // Store response for copying
                currentResponse = data;
                
                // Show modal with response
                showResponseModal(name, method, data);
            })
            .catch(error => {
                // Hide loading overlay
                document.getElementById('loadingOverlay').classList.add('hidden');
                document.getElementById('loadingOverlay').classList.remove('flex');
                
                console.error('Error:', error);
                
                // Show error in modal
                const errorData = {
                    success: false,
                    error: 'Network error: ' + error.message,
                    method: method,
                    timestamp: new Date().toISOString()
                };
                currentResponse = errorData;
                showResponseModal(name, method, errorData);
            });
        }

        function executeApiMethodFormatted(method, name, parameters) {
            // Show loading overlay
            document.getElementById('loadingOverlay').classList.remove('hidden');
            document.getElementById('loadingOverlay').classList.add('flex');
            
            // Prepare the request
            const url = `{{ route('haynes-inspector.execute', ['registration' => $vehicle->registration, 'method' => '__METHOD__']) }}`.replace('__METHOD__', method);
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(parameters)
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading overlay
                document.getElementById('loadingOverlay').classList.add('hidden');
                document.getElementById('loadingOverlay').classList.remove('flex');
                
                // Store response for copying
                currentResponse = data;
                
                // Format the response for adjustments/lubricants
                const formattedContent = formatAdjustmentsLubricants(data, method);
                
                // Show modal with formatted response
                showFormattedResponseModal(name, method, formattedContent, data);
            })
            .catch(error => {
                // Hide loading overlay
                document.getElementById('loadingOverlay').classList.add('hidden');
                document.getElementById('loadingOverlay').classList.remove('flex');
                
                console.error('Error:', error);
                
                // Show error in modal
                const errorData = {
                    success: false,
                    error: 'Network error: ' + error.message,
                    method: method,
                    timestamp: new Date().toISOString()
                };
                currentResponse = errorData;
                showResponseModal(name, method, errorData);
            });
        }

        function formatAdjustmentsLubricants(data, method) {
            if (!data.success || !data.data) {
                return 'No data available or API call failed.';
            }

            let formatted = '';
            
            // Function to recursively extract name-value pairs from subAdjustments/subLubricants
            function extractItems(items, level = 0) {
                let result = '';
                const indent = '  '.repeat(level);
                
                if (Array.isArray(items)) {
                    items.forEach(item => {
                        if (item.name && item.value !== null && item.value !== undefined) {
                            result += `${indent}• ${item.name}: ${item.value}\n`;
                        } else if (item.name) {
                            result += `${indent}• ${item.name}\n`;
                        }
                        
                        // Recursively process nested items
                        if (item.subAdjustments && Array.isArray(item.subAdjustments)) {
                            result += extractItems(item.subAdjustments, level + 1);
                        }
                        if (item.subLubricants && Array.isArray(item.subLubricants)) {
                            result += extractItems(item.subLubricants, level + 1);
                        }
                    });
                }
                
                return result;
            }

            // Process the response data
            if (Array.isArray(data.data)) {
                data.data.forEach((group, groupIndex) => {
                    if (group.name) {
                        formatted += `\n=== ${group.name} ===\n`;
                    }
                    
                    // Check for subAdjustments
                    if (group.subAdjustments && Array.isArray(group.subAdjustments)) {
                        formatted += extractItems(group.subAdjustments);
                    }
                    
                    // Check for subLubricants
                    if (group.subLubricants && Array.isArray(group.subLubricants)) {
                        formatted += extractItems(group.subLubricants);
                    }
                    
                    // Check for direct items in case the structure is different
                    if (group.name && group.value !== null && group.value !== undefined) {
                        formatted += `• ${group.name}: ${group.value}\n`;
                    }
                });
            } else if (data.data.subAdjustments || data.data.subLubricants) {
                // Handle single object response
                if (data.data.subAdjustments) {
                    formatted += extractItems(data.data.subAdjustments);
                }
                if (data.data.subLubricants) {
                    formatted += extractItems(data.data.subLubricants);
                }
            }

            return formatted || 'No name-value pairs found in the response.';
        }

        function showFormattedResponseModal(name, method, formattedContent, originalData) {
            document.getElementById('modalTitle').textContent = name + ' (Formatted)';
            document.getElementById('modalMethod').textContent = `Method: ${method}`;
            document.getElementById('responseContent').textContent = formattedContent;
            document.getElementById('responseTimestamp').textContent = `Executed at: ${originalData.timestamp || 'Unknown'}`;
            
            document.getElementById('responseModal').classList.remove('hidden');
            document.getElementById('responseModal').classList.add('flex');
        }

        function showResponseModal(name, method, data) {
            document.getElementById('modalTitle').textContent = name;
            document.getElementById('modalMethod').textContent = `Method: ${method}`;
            document.getElementById('responseContent').textContent = JSON.stringify(data, null, 2);
            document.getElementById('responseTimestamp').textContent = `Executed at: ${data.timestamp || 'Unknown'}`;
            
            document.getElementById('responseModal').classList.remove('hidden');
            document.getElementById('responseModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('responseModal').classList.add('hidden');
            document.getElementById('responseModal').classList.remove('flex');
        }

        function copyResponse() {
            if (currentResponse) {
                navigator.clipboard.writeText(JSON.stringify(currentResponse, null, 2)).then(() => {
                    // Show success feedback
                    const button = event.target.closest('button');
                    const originalText = button.innerHTML;
                    button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>Copied!';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                    }, 2000);
                });
            }
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Close modal on backdrop click
        document.getElementById('responseModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });
    </script>
</x-layouts.app> 