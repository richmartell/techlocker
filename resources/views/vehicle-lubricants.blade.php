<x-layouts.app :title="'Vehicle Lubricants - ' . str_replace('_', ' ', $carTypeGroup)">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-6">
                <!-- Header -->
                <div>
                    <h2 class="text-2xl font-bold">{{ str_replace('_', ' ', $carTypeGroup) }} Lubricants</h2>
                </div>

                <!-- Lubricants List -->
                <div class="space-y-8">
                    @foreach($lubricants as $lubricant)
                        <div class="rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                            <!-- Lubricant Group Header -->
                            <div class="bg-neutral-50 dark:bg-neutral-900 p-4">
                                <h3 class="text-lg font-semibold">{{ $lubricant['name'] }}</h3>
                            </div>

                            <!-- Lubricant Items -->
                            @if(isset($lubricant['lubricantItems']) && !empty($lubricant['lubricantItems']))
                                <div class="p-4">
                                    <div class="space-y-4">
                                        @foreach($lubricant['lubricantItems'] as $item)
                                            <div class="p-4 rounded-lg border border-neutral-200 dark:border-neutral-700">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <h4 class="font-medium text-lg mb-2">{{ $item['name'] }}</h4>
                                                        
                                                        @if(isset($item['quality']) && $item['quality'] !== null)
                                                            <div class="flex items-center gap-2 text-sm mb-2">
                                                                <span class="text-neutral-500">Quality:</span>
                                                                <span class="font-medium">{{ $item['quality'] }}</span>
                                                            </div>
                                                        @endif

                                                        @if(isset($item['viscosity']) && $item['viscosity'] !== null)
                                                            <div class="flex items-center gap-2 text-sm mb-2">
                                                                <span class="text-neutral-500">Viscosity:</span>
                                                                <span class="font-medium">{{ $item['viscosity'] }}</span>
                                                            </div>
                                                        @endif

                                                        @if(isset($item['temperature']) && $item['temperature'] !== null)
                                                            <div class="flex items-center gap-2 text-sm">
                                                                <span class="text-neutral-500">Temperature:</span>
                                                                <span class="font-medium">{{ $item['temperature'] }}</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if(isset($item['generalArticles']) && !empty($item['generalArticles']))
                                                        <div class="border-l border-neutral-200 dark:border-neutral-700 pl-4">
                                                            <h5 class="font-medium mb-2">Related Articles</h5>
                                                            <ul class="space-y-1">
                                                                @foreach($item['generalArticles'] as $article)
                                                                    <li class="text-sm">
                                                                        {{ $article['description'] }}
                                                                        @if($article['mandatory'])
                                                                            <span class="text-primary-600 ml-1">(Required)</span>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Smart Links -->
                            @if(isset($lubricant['smartLinks']) && !empty($lubricant['smartLinks']))
                                <div class="border-t border-neutral-200 dark:border-neutral-700">
                                    <div class="p-4">
                                        <h4 class="font-medium mb-3">Specifications & Diagrams</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Specifications -->
                                            <div class="space-y-4">
                                                @foreach($lubricant['smartLinks'] as $link)
                                                    @if($link['operation'] !== 'IMAGE' && $link['text'][0] !== null)
                                                        <div class="p-3 rounded-lg bg-neutral-50 dark:bg-neutral-900">
                                                            <div class="text-sm">
                                                                <div class="font-medium mb-1">{{ $link['text'][0] }}</div>
                                                                @if($link['text'][1] !== null)
                                                                    <div class="flex items-center gap-1">
                                                                        <span class="text-neutral-500">{{ $link['text'][1] }}</span>
                                                                        @if($link['text'][2] !== null)
                                                                            <span class="text-neutral-500">{{ $link['text'][2] }}</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>

                                            <!-- Images -->
                                            <div class="space-y-4">
                                                @foreach($lubricant['smartLinks'] as $link)
                                                    @if($link['operation'] === 'IMAGE' && $link['id2'] !== null)
                                                        <div class="p-3 rounded-lg bg-neutral-50 dark:bg-neutral-900">
                                                            <img src="{{ $link['id2'] }}" alt="Technical diagram" class="max-w-full h-auto">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 