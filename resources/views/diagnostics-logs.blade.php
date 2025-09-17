@extends('layouts.app')

@section('title', 'Diagnostics AI Logs')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Diagnostics AI Logs</h1>
        <p class="text-gray-600">Debug and analyze AI interactions</p>
    </div>

    <!-- Performance Statistics -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Performance Statistics</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_interactions']) }}</div>
                <div class="text-sm text-gray-600">Total Interactions</div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ round($stats['average_response_time'], 0) }}ms</div>
                <div class="text-sm text-gray-600">Avg Response Time</div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ round($stats['success_rate'], 1) }}%</div>
                <div class="text-sm text-gray-600">Success Rate</div>
            </div>
            <div class="bg-yellow-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600">{{ round($stats['haynes_data_usage'], 1) }}%</div>
                <div class="text-sm text-gray-600">With Haynes Data</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Filters</h3>
        <form method="GET" class="flex flex-wrap gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Registration</label>
                <input type="text" name="vehicle" value="{{ request('vehicle') }}" 
                       class="border border-gray-300 rounded-md px-3 py-2 w-40" placeholder="e.g., ABC123">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="border border-gray-300 rounded-md px-3 py-2">
                    <option value="">All</option>
                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success</option>
                    <option value="error" {{ request('status') === 'error' ? 'selected' : '' }}>Error</option>
                    <option value="fallback" {{ request('status') === 'fallback' ? 'selected' : '' }}>Fallback</option>
                </select>
            </div>
            <div class="flex items-end">
                <label class="flex items-center">
                    <input type="checkbox" name="recent" value="1" {{ request('recent') ? 'checked' : '' }}
                           class="mr-2">
                    <span class="text-sm">Last 24h only</span>
                </label>
            </div>
            <div class="flex items-end">
                <label class="flex items-center">
                    <input type="checkbox" name="errors" value="1" {{ request('errors') ? 'checked' : '' }}
                           class="mr-2">
                    <span class="text-sm">Errors only</span>
                </label>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Logs -->
    <div class="space-y-4">
        @forelse($logs as $log)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 
                @if($log->status === 'success') bg-green-50 border-l-4 border-green-400
                @elseif($log->status === 'error') bg-red-50 border-l-4 border-red-400
                @else bg-yellow-50 border-l-4 border-yellow-400
                @endif">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="
                                @if($log->status === 'success') bg-green-100 text-green-800
                                @elseif($log->status === 'error') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif
                                px-2 py-1 rounded-full text-xs font-medium uppercase">
                                {{ $log->status }}
                            </span>
                            <span class="text-sm font-medium">{{ $log->vehicle_registration }}</span>
                            <span class="text-sm text-gray-500">{{ $log->created_at->format('M j, Y H:i:s') }}</span>
                        </div>
                        
                        @if($log->vehicle_data)
                        <div class="mt-1 text-sm text-gray-600">
                            {{ $log->vehicle_data['year'] ?? 'Unknown' }} 
                            {{ $log->vehicle_data['make'] ?? 'Unknown' }} 
                            {{ $log->vehicle_data['model'] ?? 'Unknown' }}
                            ({{ $log->vehicle_data['engine'] ?? 'Unknown Engine' }})
                        </div>
                        @endif
                    </div>
                    
                    <div class="text-right text-sm text-gray-500">
                        @if($log->response_time_ms)
                        <div>{{ $log->response_time_ms }}ms</div>
                        @endif
                        @if($log->ai_model)
                        <div>{{ $log->ai_model }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 py-4">
                <!-- Haynes Pro Info -->
                @if($log->haynes_data_available)
                <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                    <div class="text-sm font-medium text-blue-900">
                        Haynes Pro Data Available
                    </div>
                    <div class="text-sm text-blue-700">
                        Car Type ID: {{ $log->haynes_car_type_id }} | 
                        {{ count($log->haynes_data_sections ?? []) }} data sections
                        @if($log->haynes_last_fetch)
                        | Last fetch: {{ $log->haynes_last_fetch->diffForHumans() }}
                        @endif
                    </div>
                </div>
                @endif

                <!-- User Message -->
                <div class="mb-4">
                    <div class="text-sm font-medium text-gray-900 mb-2">User Message:</div>
                    <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded border-l-4 border-blue-400">
                        {{ $log->user_message }}
                    </div>
                </div>

                <!-- AI Response -->
                <div class="mb-4">
                    <div class="text-sm font-medium text-gray-900 mb-2">AI Response:</div>
                    <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded border-l-4 border-green-400">
                        {{ Str::limit($log->ai_response, 500) }}
                        @if(strlen($log->ai_response) > 500)
                        <button onclick="toggleFullResponse(this)" class="text-blue-600 hover:text-blue-800 ml-2">
                            Show full response
                        </button>
                        <div class="hidden mt-2">
                            {{ $log->ai_response }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Error/Fallback Info -->
                @if($log->error_message || $log->fallback_reason)
                <div class="mt-4 p-3 bg-red-50 rounded-lg">
                    @if($log->error_message)
                    <div class="text-sm">
                        <span class="font-medium text-red-900">Error:</span>
                        <span class="text-red-700">{{ $log->error_message }}</span>
                    </div>
                    @endif
                    @if($log->fallback_reason)
                    <div class="text-sm">
                        <span class="font-medium text-red-900">Fallback Reason:</span>
                        <span class="text-red-700">{{ $log->fallback_reason }}</span>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Session Info -->
                <div class="mt-4 text-xs text-gray-500">
                    Session: {{ Str::limit($log->session_id ?? 'Unknown', 20) }}
                    @if($log->ip_address)
                    | IP: {{ $log->ip_address }}
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-500">
            No logs found matching the current filters.
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $logs->withQueryString()->links() }}
    </div>
</div>

<script>
function toggleFullResponse(button) {
    const hiddenDiv = button.nextElementSibling;
    if (hiddenDiv.classList.contains('hidden')) {
        hiddenDiv.classList.remove('hidden');
        button.textContent = 'Show less';
    } else {
        hiddenDiv.classList.add('hidden');
        button.textContent = 'Show full response';
    }
}
</script>
@endsection
