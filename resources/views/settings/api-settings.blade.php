<x-layouts.app :title="__('API Settings')">
    <section class="w-full">
        @include('partials.settings-heading')

        <x-settings.layout :heading="__('API Settings')" :subheading="__('Manage your API keys and integrations.')">

    <div class="grid gap-6">
        <div>
            <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow sm:rounded-lg">
                <h2 class="text-lg font-semibold mb-4">{{ __('OpenAI API Configuration') }}</h2>
                
                <p class="mb-4 text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('Configure your OpenAI API key to enable AI-powered diagnostics. If not configured, the system will use built-in responses.') }}
                </p>
                
                @if(session('api_settings_saved'))
                    <div class="mb-4 p-4 rounded-md bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 text-sm">
                        {{ session('api_settings_saved') }}
                    </div>
                @endif
                
                <form action="{{ route('settings.api.save') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="openai_api_key" class="block font-medium text-sm text-neutral-700 dark:text-neutral-300">
                            {{ __('OpenAI API Key') }}
                        </label>
                        <input
                            id="openai_api_key"
                            name="openai_api_key"
                            type="password"
                            class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm"
                            value="{{ old('openai_api_key', config('services.openai.api_key')) }}"
                        >
                        @error('openai_api_key')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="openai_model" class="block font-medium text-sm text-neutral-700 dark:text-neutral-300">
                            {{ __('OpenAI Model') }}
                        </label>
                        <select
                            id="openai_model"
                            name="openai_model"
                            class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm"
                        >
                            <option value="gpt-3.5-turbo" {{ old('openai_model', config('services.openai.model')) === 'gpt-3.5-turbo' ? 'selected' : '' }}>GPT-3.5 Turbo</option>
                            <option value="gpt-4" {{ old('openai_model', config('services.openai.model')) === 'gpt-4' ? 'selected' : '' }}>GPT-4</option>
                            <option value="gpt-4-turbo" {{ old('openai_model', config('services.openai.model')) === 'gpt-4-turbo' ? 'selected' : '' }}>GPT-4 Turbo</option>
                        </select>
                        @error('openai_model')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="openai_organization" class="block font-medium text-sm text-neutral-700 dark:text-neutral-300">
                            {{ __('OpenAI Organization ID (Optional)') }}
                        </label>
                        <input
                            id="openai_organization"
                            name="openai_organization"
                            type="text"
                            class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm"
                            value="{{ old('openai_organization', config('services.openai.organization')) }}"
                        >
                        @error('openai_organization')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Save Settings') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Haynes API Configuration -->
        <div>
            <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow sm:rounded-lg">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold">{{ __('Haynes API Configuration') }}</h2>
                    <livewire:haynes-api-status />
                </div>
                
                <p class="mb-4 text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('The Haynes API provides access to comprehensive vehicle technical data, repair procedures, and diagnostic information. Configure your credentials to access vehicle data services.') }}
                </p>

                <div class="space-y-4">
                    <div>
                        <label class="block font-medium text-sm text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('Distributor Username') }}
                        </label>
                        <input
                            type="text"
                            class="block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 bg-gray-100 dark:bg-gray-800 cursor-not-allowed"
                            value="{{ config('services.haynespro.distributor_username') ? '***' . substr(config('services.haynespro.distributor_username'), -3) : 'Not configured' }}"
                            readonly
                        >
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                            Configure via environment variables (HAYNESPRO_DISTRIBUTOR_USERNAME)
                        </p>
                    </div>
                    
                    <div>
                        <label class="block font-medium text-sm text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('Distributor Password') }}
                        </label>
                        <input
                            type="password"
                            class="block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 bg-gray-100 dark:bg-gray-800 cursor-not-allowed"
                            value="{{ config('services.haynespro.distributor_password') ? '***********' : 'Not configured' }}"
                            readonly
                        >
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                            Configure via environment variables (HAYNESPRO_DISTRIBUTOR_PASSWORD)
                        </p>
                    </div>

                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-md border border-blue-200 dark:border-blue-700">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Configuration Note</h3>
                                <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                    Haynes API credentials are configured via environment variables for security. 
                                    Contact your system administrator to update these credentials.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </x-settings.layout>
    </section>
</x-layouts.app> 