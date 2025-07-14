<x-layouts.app :title="'Vehicle Details - ' . $vehicle->registration">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-6">
                <!-- Header -->
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold">{{ $vehicle->registration }}</h1>
                        <p class="text-lg text-neutral-600 dark:text-neutral-400">
                            {{ $vehicle->make?->name ?? 'Unknown Make' }} {{ $vehicle->model?->name ?? 'Unknown Model' }}
                            @if($vehicle->haynes_model_variant_description)
                                - {{ $vehicle->haynes_model_variant_description }}
                            @endif
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('vehicle-data') }}">
                            <flux:button variant="ghost" size="sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Back to Search
                            </flux:button>
                        </a>
                        <a href="{{ route('vehicle-diagnostics', $vehicle->registration) }}">
                            <flux:button variant="primary" size="sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Diagnostics AI
                            </flux:button>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Basic Vehicle Information -->
                    <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                            Basic Information
                        </h3>
                        <dl class="grid grid-cols-1 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Registration Number</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100 font-mono bg-neutral-100 dark:bg-neutral-800 px-2 py-1 rounded">{{ $vehicle->registration }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Make</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->make?->name ?? 'Not Available' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Model</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->model?->name ?? 'Not Available' }}</dd>
                            </div>
                            @if($vehicle->haynes_model_variant_description)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Model Variant</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->haynes_model_variant_description }}</dd>
                            </div>
                            @endif
                            @if($vehicle->combined_vin)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">VIN Number</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100 font-mono bg-neutral-100 dark:bg-neutral-800 px-2 py-1 rounded">{{ $vehicle->combined_vin }}</dd>
                            </div>
                            @endif
                            @if($vehicle->colour)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Colour</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ ucwords(strtolower($vehicle->colour)) }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Technical Specifications -->
                    <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                            Technical Specifications
                        </h3>
                        <dl class="grid grid-cols-1 gap-4">
                            @if($vehicle->engine_capacity)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Engine Capacity</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ number_format($vehicle->engine_capacity) }} cc</dd>
                            </div>
                            @endif
                            @if($vehicle->fuel_type)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Fuel Type</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ ucwords(strtolower($vehicle->fuel_type)) }}</dd>
                            </div>
                            @endif
                            @if($vehicle->transmission)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Transmission</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ ucwords(strtolower($vehicle->transmission)) }}</dd>
                            </div>
                            @endif
                            @if($vehicle->forward_gears)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Forward Gears</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->forward_gears }}</dd>
                            </div>
                            @endif
                            @if($vehicle->haynes_maximum_power_at_rpm)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Maximum Power RPM</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ number_format($vehicle->haynes_maximum_power_at_rpm) }} RPM</dd>
                            </div>
                            @endif
                            @if($vehicle->tecdoc_ktype)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">TecdocKtype</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100 font-mono bg-neutral-100 dark:bg-neutral-800 px-2 py-1 rounded">{{ $vehicle->tecdoc_ktype }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    <!-- DVLA Information -->
                    <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 100-2H7a1 1 0 100 2h6zm-6 4a1 1 0 100-2h6a1 1 0 100 2H7z" clip-rule="evenodd" />
                            </svg>
                            DVLA Information
                        </h3>
                        <dl class="grid grid-cols-1 gap-4">
                            @if($vehicle->dvla_date_of_manufacture)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Date of Manufacture</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->dvla_date_of_manufacture }}</dd>
                            </div>
                            @endif
                            @if($vehicle->dvla_last_mileage)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Last Recorded Mileage</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ number_format($vehicle->dvla_last_mileage) }} miles</dd>
                            </div>
                            @endif
                            @if($vehicle->dvla_last_mileage_date)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Mileage Date</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->dvla_last_mileage_date }}</dd>
                            </div>
                            @endif
                            @if($vehicle->year_of_manufacture)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Year of Manufacture</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ $vehicle->year_of_manufacture }}</dd>
                            </div>
                            @endif
                            @if($vehicle->mot_status)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">MOT Status</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ ucwords(strtolower($vehicle->mot_status)) }}</dd>
                            </div>
                            @endif
                            @if($vehicle->tax_status)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Tax Status</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">{{ ucwords(strtolower($vehicle->tax_status)) }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Data Sources & Sync Information -->
                    <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Data Sources
                        </h3>
                        <dl class="grid grid-cols-1 gap-4">
                            @if($vehicle->last_haynespro_sync_at)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">HaynesPro VRM API</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Synced {{ $vehicle->last_haynespro_sync_at->diffForHumans() }}
                                    </span>
                                </dd>
                            </div>
                            @endif
                            @if($vehicle->last_dvla_sync_at)
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">DVLA API (Legacy)</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                                        Last synced {{ $vehicle->last_dvla_sync_at->diffForHumans() }}
                                    </span>
                                </dd>
                            </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Database Record</dt>
                                <dd class="mt-1 text-sm text-neutral-900 dark:text-neutral-100">
                                    Created {{ $vehicle->created_at->diffForHumans() }}
                                    @if($vehicle->updated_at != $vehicle->created_at)
                                        <br>Updated {{ $vehicle->updated_at->diffForHumans() }}
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Actions Section -->
                <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                    <h3 class="text-lg font-semibold mb-4">Available Actions</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('vehicle-diagnostics', $vehicle->registration) }}">
                            <flux:button variant="primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                AI Diagnostics
                            </flux:button>
                        </a>
                        @if($vehicle->combined_vin || $vehicle->tecdoc_ktype)
                            <a href="{{ route('technical-information.index', $vehicle->registration) }}">
                                <flux:button variant="outline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    View Technical Information
                                </flux:button>
                            </a>
                        @endif
                        <a href="{{ route('haynes-inspector.index', $vehicle->registration) }}">
                            <flux:button variant="outline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                                </svg>
                                Haynes Inspector
                            </flux:button>
                        </a>
                        <flux:button variant="ghost" onclick="refreshVehicleData('{{ $vehicle->registration }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Refresh Data
                        </flux:button>
                        <a href="{{ route('vehicle-data') }}">
                            <flux:button variant="ghost">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                Search Another Vehicle
                            </flux:button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function refreshVehicleData(registration) {
            if (confirm('This will fetch the latest data from HaynesPro VRM API. Continue?')) {
                // Create a form and submit it to force refresh
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("vehicle-data.lookup") }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const regInput = document.createElement('input');
                regInput.type = 'hidden';
                regInput.name = 'registration';
                regInput.value = registration;
                
                form.appendChild(csrfToken);
                form.appendChild(regInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-layouts.app> 