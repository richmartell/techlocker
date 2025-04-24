<x-settings.layout>
    <x-slot:title>
        {{ __('API Settings') }}
    </x-slot:title>

    <x-slot:description>
        {{ __('Manage your API keys and integrations.') }}
    </x-slot:description>

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
    </div>
</x-settings.layout> 