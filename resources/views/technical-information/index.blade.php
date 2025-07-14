<x-layouts.app :title="'Technical Information - ' . $vehicle->registration">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-6">
                <!-- Header -->
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold">Technical Information</h1>
                        <p class="text-lg text-neutral-600 dark:text-neutral-400">
                            {{ $vehicle->registration }} - {{ $vehicle->make?->name ?? 'Unknown Make' }} {{ $vehicle->model?->name ?? 'Unknown Model' }}
                            @if($vehicle->haynes_model_variant_description)
                                - {{ $vehicle->haynes_model_variant_description }}
                            @endif
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

                @if(!$carTypeId)
                    <!-- No Technical Information Available -->
                    <div class="p-6 rounded-xl border border-amber-200 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/20">
                        <h3 class="text-lg font-semibold mb-2 text-amber-800 dark:text-amber-200">Technical Information Not Available</h3>
                        <p class="text-amber-700 dark:text-amber-300">
                            Technical information is not available for this vehicle. This may be because:
                        </p>
                        <ul class="mt-2 list-disc list-inside text-amber-700 dark:text-amber-300">
                            <li>The vehicle doesn't have a TecdocKtype identifier</li>
                            <li>The vehicle is not found in the HaynesPro database</li>
                            <li>The vehicle data needs to be refreshed</li>
                        </ul>
                    </div>
                @else
                    <!-- Technical Information Available -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Maintenance Information -->
                        @if(in_array('MAINTENANCE', $availableSubjects))
                            <div class="p-6 rounded-xl border border-blue-200 dark:border-blue-700 bg-blue-50 dark:bg-blue-900/20">
                                <h3 class="text-lg font-semibold mb-4 text-blue-800 dark:text-blue-200 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Maintenance Information
                                </h3>
                                <div class="space-y-3">
                                    <a href="{{ route('technical-information.maintenance-systems', $vehicle->registration) }}">
                                        <flux:button variant="outline" class="w-full justify-start">
                                            Maintenance Systems & Schedules
                                        </flux:button>
                                    </a>
                                    <a href="{{ route('technical-information.maintenance-tasks', $vehicle->registration) }}">
                                        <flux:button variant="outline" class="w-full justify-start">
                                            Maintenance Tasks
                                        </flux:button>
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- System-Based Information -->
                        @if(!empty($subjectsByGroup))
                            @foreach($subjectsByGroup as $group)
                                @php
                                    $groupKey = $group['key'];
                                    $groupSubjects = explode(',', $group['value']);
                                @endphp
                                <div class="p-6 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                                        @if($groupKey === 'ENGINE')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($groupKey === 'TRANSMISSION')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($groupKey === 'BRAKES')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($groupKey === 'ELECTRONICS')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-neutral-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                        {{ ucfirst(strtolower(str_replace('_', ' ', $groupKey))) }}
                                    </h3>
                                    <div class="space-y-2">
                                        @if(in_array('ADJUSTMENTS', $groupSubjects))
                                            <a href="{{ route('technical-information.adjustments', [$vehicle->registration, $groupKey]) }}">
                                                <flux:button variant="outline" size="sm" class="w-full justify-start">
                                                    Adjustments & Specifications
                                                </flux:button>
                                            </a>
                                        @endif
                                        @if(in_array('LUBRICANTS', $groupSubjects))
                                            <a href="{{ route('technical-information.lubricants', [$vehicle->registration, $groupKey]) }}">
                                                <flux:button variant="outline" size="sm" class="w-full justify-start">
                                                    Lubricants & Capacities
                                                </flux:button>
                                            </a>
                                        @endif
                                        @if(in_array('DRAWINGS', $groupSubjects))
                                            <a href="{{ route('technical-information.technical-drawings', [$vehicle->registration, $groupKey]) }}">
                                                <flux:button variant="outline" size="sm" class="w-full justify-start">
                                                    Technical Drawings
                                                </flux:button>
                                            </a>
                                        @endif
                                        @if(in_array('REPAIR_TIMES', $groupSubjects))
                                            <a href="{{ route('technical-information.repair-times', [$vehicle->registration, $groupKey]) }}">
                                                <flux:button variant="outline" size="sm" class="w-full justify-start">
                                                    Repair Times
                                                </flux:button>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- General Technical Information -->
                        <div class="p-6 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                            <h3 class="text-lg font-semibold mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                General Information
                            </h3>
                            <div class="space-y-2">
                                @if(in_array('WIRING_DIAGRAMS', $availableSubjects))
                                    <a href="{{ route('technical-information.wiring-diagrams', $vehicle->registration) }}">
                                        <flux:button variant="outline" size="sm" class="w-full justify-start">
                                            Wiring Diagrams
                                        </flux:button>
                                    </a>
                                @endif
                                @if(in_array('FUSE_LOCATIONS', $availableSubjects))
                                    <a href="{{ route('technical-information.fuse-locations', $vehicle->registration) }}">
                                        <flux:button variant="outline" size="sm" class="w-full justify-start">
                                            Fuse Locations
                                        </flux:button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Debug Information (only in development) -->
                    @if(config('app.debug'))
                        <div class="mt-6 p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                            <h3 class="text-sm font-semibold mb-2">Debug Information</h3>
                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                <p><strong>CarTypeId:</strong> {{ $carTypeId }}</p>
                                <p><strong>TecdocKtype:</strong> {{ $vehicle->tecdoc_ktype }}</p>
                                <p><strong>Available Subjects:</strong> {{ implode(', ', $availableSubjects) }}</p>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-layouts.app> 