<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Branding')" :subheading="__('Customize your account branding for quotes and reports')">
        <form wire:submit="save" class="my-6 w-full space-y-6">
            
            <!-- Logo Upload -->
            <div>
                <flux:field>
                    <flux:label>Logo</flux:label>
                    <flux:description>Upload your company logo (PNG or JPEG, max 2MB)</flux:description>
                    
                    <!-- Dropzone -->
                    <div 
                        x-data="{ dragging: false }"
                        @dragover.prevent="dragging = true"
                        @dragleave.prevent="dragging = false"
                        @drop.prevent="dragging = false; $refs.fileInput.files = $event.dataTransfer.files; $refs.fileInput.dispatchEvent(new Event('change', { bubbles: true }))"
                        :class="dragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/10' : 'border-zinc-300 dark:border-zinc-600'"
                        class="mt-2 flex flex-col items-center justify-center w-full rounded-lg border-2 border-dashed transition-colors cursor-pointer hover:border-zinc-400 dark:hover:border-zinc-500"
                    >
                        <label for="logo-file-input" class="flex flex-col items-center justify-center w-full py-8 cursor-pointer">
                            <svg class="w-10 h-10 mb-3 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mb-1 text-sm font-semibold text-zinc-700 dark:text-zinc-300">Drop logo here or click to browse</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">PNG or JPEG, max 2MB</p>
                        </label>
                        <input 
                            id="logo-file-input"
                            x-ref="fileInput"
                            type="file" 
                            wire:model="logo" 
                            accept="image/png,image/jpeg,image/jpg"
                            class="hidden"
                        />
                    </div>

                    <flux:error name="logo" />
                    
                    <!-- Loading State -->
                    <div wire:loading wire:target="logo" class="mt-3">
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-sm">Uploading...</p>
                        </div>
                    </div>

                    <!-- File Preview -->
                    <div class="mt-3 space-y-2">
                        @if($existingLogo && !$logo)
                            <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                <img src="{{ Storage::url($existingLogo) }}" alt="Current logo" class="h-12 w-12 rounded object-cover">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">Current Logo</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Uploaded logo</p>
                                </div>
                                <flux:button 
                                    type="button" 
                                    size="sm"
                                    variant="ghost"
                                    icon="x-mark"
                                    wire:click="removeLogo"
                                    wire:confirm="Are you sure you want to remove the logo?"
                                />
                            </div>
                        @endif

                        @if($logo)
                            <div class="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-700">
                                <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="h-12 w-12 rounded object-cover">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-green-900 dark:text-green-100 truncate">{{ $logo->getClientOriginalName() }}</p>
                                    <p class="text-xs text-green-700 dark:text-green-300">{{ number_format($logo->getSize() / 1024, 1) }} KB</p>
                                </div>
                                <flux:button 
                                    type="button" 
                                    size="sm"
                                    variant="ghost"
                                    icon="x-mark"
                                    wire:click="$set('logo', null)"
                                />
                            </div>
                        @endif
                    </div>
                </flux:field>
            </div>

            <!-- Company Name -->
            <div>
                <flux:label>Company Name</flux:label>
                <flux:description>Your legal company name</flux:description>
                <flux:input 
                    wire:model="companyName" 
                    type="text" 
                    required 
                    placeholder="e.g., Main Street Motors Ltd"
                    class="mt-2"
                />
                @error('companyName')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Trading Name -->
            <div>
                <flux:label>Trading Name</flux:label>
                <flux:description>Optional trading name if different from company name</flux:description>
                <flux:input 
                    wire:model="tradingName" 
                    type="text" 
                    placeholder="e.g., Main Street Garage"
                    class="mt-2"
                />
                @error('tradingName')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <flux:label>Address</flux:label>
                <flux:description>Business address for quotes and reports</flux:description>
                <flux:textarea 
                    wire:model="address" 
                    rows="4"
                    placeholder="e.g., 123 Main Street&#10;London&#10;EC1A 1BB&#10;United Kingdom"
                    class="mt-2"
                />
                @error('address')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- VAT Number -->
            <div>
                <flux:label>VAT Number</flux:label>
                <flux:description>Your VAT registration number (if applicable)</flux:description>
                <flux:input 
                    wire:model="vatNumber" 
                    type="text" 
                    placeholder="e.g., GB123456789"
                    class="mt-2"
                />
                @error('vatNumber')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Submit Button -->
            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit" class="w-full">
                    Save Branding
                </flux:button>
            </div>
        </form>
    </x-settings.layout>
</section>