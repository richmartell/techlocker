@php
    $hasContent = !empty($line['name']) || !empty($line['text']) || !empty($line['remark']) || !empty($line['paragraphContent']);
    $isHeader = $line['sentenceStyle'] === 'HEADER_STYLE';
    $isNote = $line['sentenceStyle'] === 'NOTE_STYLE';
    $isWarning = $line['sentenceGroupType'] === 'WARNING';
    $isGroup = $line['isGroup'] ?? false; // Section headers (like "Warnings and recommendations", "Removal")
@endphp

@if($hasContent)
    <div class="story-line-item" style="margin-left: {{ $line['level'] * 1.5 }}rem;">
        @if($isGroup)
            <!-- Group/Section Header - No numbering, just bold -->
            <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100 mb-3 mt-6">
                {{ $line['name'] }}
            </h3>
        @elseif($isHeader)
            <!-- Header Style - No numbering -->
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 mt-6">
                {{ $line['name'] }}
            </h3>
        @elseif($isWarning)
            <!-- Warning Style -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4 mb-3">
                <div class="flex items-start gap-3">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 flex-shrink-0" />
                    <div class="flex-1">
                        @if(!empty($line['name']))
                            <p class="font-semibold text-yellow-800 dark:text-yellow-200">{{ $line['name'] }}</p>
                        @endif
                        @if(!empty($line['text']))
                            <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">{{ $line['text'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @elseif($isNote)
            <!-- Note Style -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4 mb-3">
                <div class="flex items-start gap-3">
                    <flux:icon.information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" />
                    <div class="flex-1">
                        @if(!empty($line['name']))
                            <p class="font-semibold text-blue-800 dark:text-blue-200">{{ $line['name'] }}</p>
                        @endif
                        @if(!empty($line['text']))
                            <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">{{ $line['text'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <!-- Regular Content - Numbered items -->
            <div class="mb-3">
                @if(!empty($line['name']))
                    <div class="flex items-baseline gap-2">
                        <span class="font-semibold text-blue-600 dark:text-blue-400 flex-shrink-0">{{ $index + 1 }}.</span>
                        <div class="flex-1">
                            <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $line['name'] }}</span>
                            
                            @if(!empty($line['text']))
                                <span class="text-zinc-700 dark:text-zinc-300 ml-2">{{ $line['text'] }}</span>
                            @endif
                            
                            @if(!empty($line['remark']))
                                <span class="text-zinc-600 dark:text-zinc-400 italic ml-2">({{ $line['remark'] }})</span>
                            @endif
                        </div>
                    </div>
                @elseif(!empty($line['text']))
                    <p class="text-zinc-700 dark:text-zinc-300">{{ $line['text'] }}</p>
                @endif
                
                @if(!empty($line['paragraphContent']))
                    <div class="mt-2 text-sm text-zinc-600 dark:text-zinc-400 whitespace-pre-wrap">{{ $line['paragraphContent'] }}</div>
                @endif
            </div>
        @endif
        
        <!-- Display image inline if present -->
        @if(!empty($line['image']))
            <div class="mt-3 mb-4">
                <div class="bg-white dark:bg-zinc-100 rounded-lg border border-zinc-200 dark:border-zinc-300 p-4 cursor-pointer hover:shadow-lg transition-shadow"
                     onclick="openImageModal('{{ $line['image'] }}', '{{ addslashes($line['name']) }}')">
                    <img 
                        src="{{ $line['image'] }}" 
                        alt="{{ $line['name'] }}"
                        class="w-full h-auto max-h-96 object-contain"
                        onerror="this.parentElement.innerHTML='<div class=\'p-8 text-center text-zinc-500\'>Image unavailable</div>'"
                    />
                    <div class="flex items-center justify-center gap-2 mt-3 text-sm text-zinc-500 hover:text-zinc-700">
                        <flux:icon.magnifying-glass-plus class="w-4 h-4" />
                        <span>Click to enlarge</span>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Render children recursively -->
        @if(!empty($line['children']))
            <div class="ml-0 space-y-4">
                @foreach($line['children'] as $childIndex => $child)
                    @include('maintenance.partials.story-line', ['line' => $child, 'index' => $childIndex])
                @endforeach
            </div>
        @endif
    </div>
@endif
