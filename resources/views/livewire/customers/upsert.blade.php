<div>
<flux:modal name="customer-upsert" wire:model="showModal" class="w-full max-w-2xl" x-init="console.log('Upsert modal element initialized')">
    <form wire:submit="save" x-on:submit="console.log('Form submitted')">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $isEditing ? 'Edit Customer' : 'Add New Customer' }}</flux:heading>
                <flux:text class="mt-2">
                    {{ $isEditing ? 'Update customer information and settings' : 'Enter customer details to add them to your database' }}
                </flux:text>
            </div>
        <div class="p-6 space-y-6">
            {{-- Basic Information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:field>
                        <flux:label>First Name *</flux:label>
                        <flux:input 
                            wire:model="first_name" 
                            placeholder="e.g. John"
                            :error="$errors->first('first_name')"
                        />
                        <flux:error name="first_name" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Last Name *</flux:label>
                        <flux:input 
                            wire:model="last_name" 
                            placeholder="e.g. Smith"
                            :error="$errors->first('last_name')"
                        />
                        <flux:error name="last_name" />
                    </flux:field>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:field>
                        <flux:label>Email</flux:label>
                        <flux:input 
                            wire:model="email" 
                            type="email"
                            placeholder="e.g. john.smith@example.com"
                            icon="at-symbol"
                            :error="$errors->first('email')"
                        />
                        <flux:error name="email" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Phone Number</flux:label>
                        <flux:input 
                            wire:model="phone" 
                            type="tel"
                            placeholder="e.g. 01234 567890"
                            icon="phone"
                            :error="$errors->first('phone')"
                        />
                        <flux:error name="phone" />
                        <flux:description>UK phone numbers are automatically formatted</flux:description>
                    </flux:field>
                </div>
            </div>

            {{-- Tags --}}
            <div>
                <flux:field>
                    <flux:label>Tags</flux:label>
                    <div class="space-y-3">
                        {{-- Tag Input --}}
                        <div class="flex gap-2">
                            <flux:input 
                                wire:model="newTag" 
                                wire:keydown.enter.prevent="addTag"
                                placeholder="Add a tag and press Enter"
                                class="flex-1"
                                icon="tag"
                            />
                            <flux:button 
                                type="button"
                                wire:click="addTag" 
                                variant="ghost"
                                icon="plus"
                                size="sm"
                            >
                                Add
                            </flux:button>
                        </div>
                        
                        {{-- Current Tags --}}
                        @if(count($tags) > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($tags as $index => $tag)
                                    <flux:badge color="blue" class="flex items-center gap-1">
                                        {{ $tag }}
                                        <button 
                                            type="button"
                                            wire:click="removeTag({{ $index }})"
                                            class="ml-1 hover:text-red-600 transition-colors"
                                        >
                                            <flux:icon.x-mark class="w-3 h-3" />
                                        </button>
                                    </flux:badge>
                                @endforeach
                            </div>
                        @endif
                        
                        {{-- Suggested Tags --}}
                        <div class="flex flex-wrap gap-2">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Suggested:</span>
                            @foreach(['VIP', 'Regular', 'Trade', 'Fleet', 'New'] as $suggestedTag)
                                @if(!in_array($suggestedTag, $tags))
                                    <button 
                                        type="button"
                                        wire:click="addSuggestedTag('{{ $suggestedTag }}')"
                                        class="text-xs px-2 py-1 rounded-full border border-zinc-300 dark:border-zinc-600 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                                    >
                                        + {{ $suggestedTag }}
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </flux:field>
            </div>

            {{-- Source --}}
            <div>
                <flux:field>
                    <flux:label>How did they find you?</flux:label>
                    <flux:select wire:model="source" placeholder="Select source">
                        <flux:select.option value="">Not specified</flux:select.option>
                        <flux:select.option value="web">Website</flux:select.option>
                        <flux:select.option value="phone">Phone call</flux:select.option>
                        <flux:select.option value="walk-in">Walk-in</flux:select.option>
                        <flux:select.option value="referral">Referral</flux:select.option>
                    </flux:select>
                </flux:field>
            </div>

            {{-- Notes --}}
            <div>
                <flux:field>
                    <flux:label>Notes</flux:label>
                    <flux:textarea 
                        wire:model="notes" 
                        placeholder="Any additional notes about this customer..."
                        rows="4"
                        :error="$errors->first('notes')"
                    />
                    <flux:error name="notes" />
                    <flux:description>Internal notes visible only to your team</flux:description>
                </flux:field>
            </div>
        </div>

            <div class="flex gap-2">
                <flux:spacer />
                
                <flux:button wire:click="closeModal" variant="ghost">
                    Cancel
                </flux:button>
                
                <flux:button type="submit" variant="primary" loading="save">
                    {{ $isEditing ? 'Update Customer' : 'Add Customer' }}
                </flux:button>
            </div>
        </div>
    </form>
</flux:modal>

{{-- Success/Error Messages --}}
@if (session()->has('success'))
    <flux:toast type="success" :text="session('success')" />
@endif

@if (session()->has('error'))
    <flux:toast type="error" :text="session('error')" />
@endif
</div>
