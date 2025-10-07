@php
    $title = 'Service Schedule Details - ' . ($vehicle->make?->name ?? 'Unknown') . ' ' . ($vehicle->model?->name ?? 'Unknown');
@endphp

<x-layouts.app :title="$title" :vehicle="$vehicle">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                <a href="{{ route('maintenance.schedules', $vehicle->registration) }}" 
                   class="hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors"
                   wire:navigate>
                    Maintenance Schedules
                </a>
                <flux:icon.chevron-right class="w-4 h-4" />
                <span class="text-zinc-900 dark:text-zinc-100">Service Details</span>
            </nav>

            <div class="flex items-center gap-3 mb-2">
                <flux:icon.cog-6-tooth class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                    @if($intervalInfo)
                        Service Schedule: 
                        @if(($intervalInfo['intervalMileage'] ?? 0) > 0)
                            {{ number_format($intervalInfo['intervalMileage']) }} miles
                        @endif
                        @if(($intervalInfo['intervalMileage'] ?? 0) > 0 && ($intervalInfo['intervalMonths'] ?? 0) > 0)
                            /
                        @endif
                        @if(($intervalInfo['intervalMonths'] ?? 0) > 0)
                            {{ $intervalInfo['intervalMonths'] }} months
                        @endif
                        <span class="text-lg font-normal text-zinc-500 dark:text-zinc-400 ml-3">
                            (Service ID: {{ $periodId }})
                        </span>
                    @else
                        Maintenance Schedule Details
                        <span class="text-lg font-normal text-zinc-500 dark:text-zinc-400 ml-3">
                            (Service ID: {{ $periodId }})
                        </span>
                    @endif
                </h1>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">
                Maintenance tasks and parts for {{ $vehicle->make?->name ?? 'Unknown' }} {{ $vehicle->model?->name ?? 'Unknown' }} ({{ $vehicle->registration }})
            </p>
        </div>

        @if(!empty($maintenanceTasks))
            <!-- Service Tasks Checklist -->
            <div class="space-y-6">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <flux:icon.clipboard-document-list class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Service Checklist</h2>
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                            {{ count($maintenanceTasks) }} tasks
                        </span>
                    </div>
                    
                    <!-- Checklist Container -->
                    <flux:card>
                        <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @php 
                                $currentCategory = null; 
                                $taskCounter = 0;
                            @endphp
                            @foreach($maintenanceTasks as $index => $task)
                                {{-- Show category header when category changes --}}
                                @if($currentCategory !== ($task['category'] ?? 'General'))
                                    @php $currentCategory = $task['category'] ?? 'General'; @endphp
                                    @if($index > 0)
                                        {{-- Add extra spacing between categories --}}
                                        <div class="border-t-2 border-zinc-300 dark:border-zinc-600"></div>
                                    @endif
                                    <div class="bg-zinc-50 dark:bg-zinc-800 px-4 py-3 border-b border-zinc-200 dark:border-zinc-700">
                                        <div class="flex items-center gap-2">
                                            <flux:icon.wrench-screwdriver class="w-5 h-5 text-zinc-600 dark:text-zinc-400" />
                                            <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $currentCategory }}</h3>
                                            <span class="px-2 py-1 text-xs font-medium bg-zinc-200 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300 rounded-full">
                                                {{ collect($maintenanceTasks)->where('category', $currentCategory)->count() }} tasks
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @php $taskCounter++; @endphp
                                <div class="flex items-start gap-4 p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                    <!-- Task Number -->
                                    <div class="flex-shrink-0 w-7 h-7 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 rounded-full flex items-center justify-center text-xs font-medium mt-1">
                                        {{ $taskCounter }}
                                    </div>
                                    <!-- Checkbox -->
                                    <div class="flex-shrink-0 mt-1">
                                        <input 
                                            type="checkbox" 
                                            id="task-{{ $index }}"
                                            class="w-5 h-5 text-blue-600 bg-zinc-100 border-zinc-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600"
                                        >
                                    </div>
                                    
                                    <!-- Task Content -->
                                    <div class="flex-1 min-w-0">
                                        <label for="task-{{ $index }}" class="cursor-pointer">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <!-- Task Name -->
                                                    <h3 class="font-medium text-zinc-900 dark:text-zinc-100 leading-5">
                                                        @php
                                                            $taskName = $task['name'] ?? $task['description'] ?? $task['title'] ?? 'Maintenance Task';
                                                            if (is_array($taskName)) {
                                                                $taskName = implode(', ', array_filter($taskName));
                                                            }
                                                        @endphp
                                                        {{ $taskName }}
                                                    </h3>
                                                    
                                                    
                                                    <!-- Task Description -->
                                                    @if(isset($task['procedure']) || isset($task['instructions']) || isset($task['steps']))
                                                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2">
                                                            @php
                                                                $procedure = $task['procedure'] ?? $task['instructions'] ?? $task['steps'] ?? '';
                                                                if (is_array($procedure)) {
                                                                    $procedure = implode('. ', array_filter($procedure));
                                                                }
                                                            @endphp
                                                            {{ $procedure }}
                                                        </p>
                                                    @elseif(isset($task['description']) && $task['description'] !== ($task['name'] ?? $task['title'] ?? ''))
                                                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2">
                                                            @php
                                                                $description = $task['description'] ?? '';
                                                                if (is_array($description)) {
                                                                    $description = implode('. ', array_filter($description));
                                                                }
                                                            @endphp
                                                            {{ $description }}
                                                        </p>
                                                    @endif
                                                </div>
                                                
                                                <!-- Service Time -->
                                                @if(isset($task['serviceTime']) || isset($task['time']) || isset($task['duration']))
                                                    <div class="flex-shrink-0 ml-4">
                                                        <div class="flex items-center gap-1 text-sm text-zinc-500 dark:text-zinc-400">
                                                            <flux:icon.clock class="w-4 h-4" />
                                                            <span>
                                                                @php
                                                                    $serviceTime = $task['serviceTime'] ?? $task['time'] ?? $task['duration'] ?? 'N/A';
                                                                    if (is_array($serviceTime)) {
                                                                        $serviceTime = implode(', ', array_filter($serviceTime)) ?: 'N/A';
                                                                    }
                                                                    $timeUnit = $task['timeUnit'] ?? 'min';
                                                                    if (is_array($timeUnit)) {
                                                                        $timeUnit = implode(', ', array_filter($timeUnit)) ?: 'min';
                                                                    }
                                                                @endphp
                                                                {{ $serviceTime }}
                                                                @if(isset($task['timeUnit']))
                                                                    {{ $timeUnit }}
                                                                @else
                                                                    min
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </flux:card>
                    
                    <!-- Summary -->
                    <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center gap-2">
                            <flux:icon.information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                            <span class="text-sm font-medium text-blue-900 dark:text-blue-100">
                                Service Interval Summary
                            </span>
                        </div>
                        <p class="mt-1 text-sm text-blue-700 dark:text-blue-200">
                            Complete all {{ count($maintenanceTasks) }} tasks listed above for this service interval.
                            @if($intervalInfo)
                                This service is due every {{ number_format($intervalInfo['intervalMileage'] ?? 0) }} miles or {{ $intervalInfo['intervalMonths'] ?? 0 }} months, whichever comes first.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- No Tasks Available -->
            <flux:card>
                <div class="p-8 text-center">
                    <flux:icon.exclamation-triangle class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Tasks Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-4">
                        We couldn't find specific maintenance tasks for this service interval. This could be due to:
                    </p>
                    <ul class="text-sm text-zinc-500 dark:text-zinc-400 text-left max-w-md mx-auto space-y-1">
                        <li>• Service data not available in the database</li>
                        <li>• API connection issue</li>
                        <li>• Service interval may require manual consultation</li>
                    </ul>
                    <div class="mt-6">
                        <flux:button variant="outline" href="{{ route('maintenance.schedules', $vehicle->registration) }}" wire:navigate>
                            <flux:icon.arrow-left class="w-4 h-4 mr-2" />
                            Back to Service Intervals
                        </flux:button>
                    </div>
                </div>
            </flux:card>
        @endif

        @if(isset($rawApiData))
            <!-- API Output -->
            <div class="mt-8">
                <div class="flex items-center gap-3 mb-4">
                    <flux:icon.code-bracket class="w-6 h-6 text-zinc-500 dark:text-zinc-400" />
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">API Output</h2>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full">
                        Debug Data
                    </span>
                </div>
                
                <flux:card>
                    <div class="p-6">
                        <div class="mb-4">
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                                Raw JSON data returned from the HaynesPro API for this maintenance schedule:
                            </p>
                            
                            <!-- Copy Button -->
                            <div class="flex justify-end mb-2">
                                <flux:button 
                                    size="sm" 
                                    variant="outline" 
                                    onclick="copyApiData()"
                                    id="copyButton"
                                >
                                    <flux:icon.clipboard class="w-4 h-4 mr-2" />
                                    Copy JSON
                                </flux:button>
                            </div>
                            
                            <!-- JSON Output -->
                            <div class="bg-zinc-900 dark:bg-zinc-950 rounded-lg overflow-hidden">
                                <div class="bg-zinc-800 dark:bg-zinc-900 px-4 py-2 border-b border-zinc-700">
                                    <span class="text-sm font-medium text-zinc-300">JSON Response</span>
                                </div>
                                <pre id="apiData" class="p-4 text-sm text-zinc-100 overflow-x-auto whitespace-pre-wrap max-h-96 overflow-y-auto"><code>{{ json_encode($rawApiData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                            </div>
                        </div>
                        
                        <!-- Data Summary -->
                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center gap-2 mb-2">
                                <flux:icon.information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                <span class="text-sm font-medium text-blue-900 dark:text-blue-100">
                                    API Data Summary
                                </span>
                            </div>
                            <div class="text-sm text-blue-700 dark:text-blue-200 space-y-1">
                                <div>• Maintenance Tasks: {{ count($rawApiData['maintenanceTasks'] ?? []) }} items</div>
                                <div>• Maintenance Parts: {{ count($rawApiData['maintenanceParts'] ?? []) }} items</div>
                                <div>• System ID: {{ $systemId }}</div>
                                <div>• Period ID: {{ $periodId }}</div>
                                <div>• Car Type ID: {{ $carTypeId }}</div>
                            </div>
                        </div>
                    </div>
                </flux:card>
            </div>
        @endif

        @if(empty($maintenanceTasks) && empty($maintenanceParts))
            <!-- No Data State -->
            <flux:card>
                <div class="p-8 text-center">
                    <flux:icon.wrench-screwdriver class="w-12 h-12 text-zinc-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">No Service Details Available</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-4">
                        No detailed service tasks found for this interval. This could be due to:
                    </p>
                    <ul class="text-sm text-zinc-600 dark:text-zinc-400 space-y-1 max-w-md mx-auto text-left">
                        <li>• Invalid system or period ID</li>
                        <li>• Data not available in HaynesPro database</li>
                        <li>• Service details may be available in other sections</li>
                    </ul>
                    
                    <div class="mt-6">
                        <flux:button 
                            variant="outline" 
                            href="{{ route('maintenance.schedules', $vehicle->registration) }}"
                            wire:navigate
                        >
                            Back to Schedules
                        </flux:button>
                    </div>
                </div>
            </flux:card>
        @endif

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(!empty($maintenanceTasks))
                // Load saved checklist state from localStorage
                const checklistId = 'maintenance-checklist-{{ $vehicle->registration }}-{{ $systemId }}-{{ $periodId }}';
                const savedState = localStorage.getItem(checklistId);
                
                if (savedState) {
                    const checkedItems = JSON.parse(savedState);
                    checkedItems.forEach(index => {
                        const checkbox = document.getElementById('task-' + index);
                        if (checkbox) {
                            checkbox.checked = true;
                            updateTaskAppearance(checkbox);
                        }
                    });
                }
                
                // Add event listeners to all checkboxes
                document.querySelectorAll('input[type="checkbox"][id^="task-"]').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateTaskAppearance(this);
                        saveChecklistState();
                    });
                });
                
                function updateTaskAppearance(checkbox) {
                    const taskContainer = checkbox.closest('.flex');
                    const label = checkbox.nextElementSibling;
                    if (checkbox.checked) {
                        taskContainer.classList.add('opacity-60');
                        label.querySelector('h3').classList.add('line-through');
                    } else {
                        taskContainer.classList.remove('opacity-60');
                        label.querySelector('h3').classList.remove('line-through');
                    }
                }
                
                function saveChecklistState() {
                    const checkedItems = [];
                    document.querySelectorAll('input[type="checkbox"][id^="task-"]:checked').forEach(checkbox => {
                        const index = checkbox.id.replace('task-', '');
                        checkedItems.push(index);
                    });
                    localStorage.setItem(checklistId, JSON.stringify(checkedItems));
                }
            @endif
        });
        
        // Copy API data function
        function copyApiData() {
            const apiData = document.getElementById('apiData');
            const copyButton = document.getElementById('copyButton');
            
            if (apiData) {
                const text = apiData.textContent;
                navigator.clipboard.writeText(text).then(function() {
                    // Update button text temporarily
                    const originalText = copyButton.innerHTML;
                    copyButton.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Copied!';
                    
                    setTimeout(function() {
                        copyButton.innerHTML = originalText;
                    }, 2000);
                }).catch(function(err) {
                    console.error('Failed to copy: ', err);
                    alert('Failed to copy to clipboard');
                });
            }
        }
    </script>
    @endpush
</x-layouts.app> 