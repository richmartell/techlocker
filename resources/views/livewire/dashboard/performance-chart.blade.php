<div>
    <flux:card>
        <flux:chart class="grid gap-6" wire:model="chartData">
            <flux:chart.summary class="flex gap-12">
                <div>
                    <flux:text>Revenue</flux:text>
                    <flux:heading size="xl" class="mt-2 tabular-nums">
                        <flux:chart.summary.value field="revenue" :format="['style' => 'currency', 'currency' => 'GBP']" />
                    </flux:heading>
                    <flux:text class="mt-2 tabular-nums">
                        <flux:chart.summary.value field="date" :format="['month' => 'long', 'year' => 'numeric']" />
                    </flux:text>
                </div>
                <div>
                    <flux:text>Profit</flux:text>
                    <flux:heading size="lg" class="mt-2 tabular-nums">
                        <flux:chart.summary.value field="profit" :format="['style' => 'currency', 'currency' => 'GBP']" />
                    </flux:heading>
                </div>
                <div>
                    <flux:text>Jobs Completed</flux:text>
                    <flux:heading size="lg" class="mt-2 tabular-nums">
                        <flux:chart.summary.value field="jobs" />
                    </flux:heading>
                </div>
            </flux:chart.summary>
            
            <flux:chart.viewport class="aspect-[3/1]">
                <flux:chart.svg>
                    <flux:chart.line field="revenue" class="text-primary-500 dark:text-primary-400" curve="smooth" />
                    <flux:chart.area field="revenue" class="text-primary-200/50 dark:text-primary-400/30" curve="smooth" />
                    
                    <flux:chart.line field="expenses" class="text-red-500 dark:text-red-400" curve="smooth" stroke-dasharray="4 4" />
                    
                    <flux:chart.line field="profit" class="text-green-500 dark:text-green-400" curve="smooth" />
                    
                    <flux:chart.axis axis="x" field="date">
                        <flux:chart.axis.grid />
                        <flux:chart.axis.tick :format="['month' => 'short']" />
                        <flux:chart.axis.line />
                    </flux:chart.axis>
                    
                    <flux:chart.axis axis="y" position="left" :format="['style' => 'currency', 'currency' => 'GBP', 'notation' => 'compact']">
                        <flux:chart.axis.grid />
                        <flux:chart.axis.tick />
                    </flux:chart.axis>
                    
                    <flux:chart.cursor />
                </flux:chart.svg>
            </flux:chart.viewport>
            
            <div class="flex justify-center gap-4 pt-4">
                <flux:chart.legend label="Revenue">
                    <flux:chart.legend.indicator class="bg-primary-400" />
                </flux:chart.legend>
                <flux:chart.legend label="Expenses">
                    <flux:chart.legend.indicator class="bg-red-400" />
                </flux:chart.legend>
                <flux:chart.legend label="Profit">
                    <flux:chart.legend.indicator class="bg-green-400" />
                </flux:chart.legend>
            </div>
        </flux:chart>
    </flux:card>
    
    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <!-- Revenue Card -->
        <flux:card class="overflow-hidden">
            <flux:text>Total Revenue (YTD)</flux:text>
            <flux:heading size="xl" class="mt-2 tabular-nums">
                £{{ number_format(array_sum(array_column($chartData, 'revenue')), 0) }}
            </flux:heading>
            <flux:chart class="-mx-8 -mb-8 h-[3rem]" :value="array_column($chartData, 'revenue')">
                <flux:chart.svg gutter="0">
                    <flux:chart.line class="text-primary-200 dark:text-primary-400" />
                    <flux:chart.area class="text-primary-100 dark:text-primary-400/30" />
                </flux:chart.svg>
            </flux:chart>
        </flux:card>
        
        <!-- Profit Card -->
        <flux:card class="overflow-hidden">
            <flux:text>Total Profit (YTD)</flux:text>
            <flux:heading size="xl" class="mt-2 tabular-nums">
                £{{ number_format(array_sum(array_column($chartData, 'profit')), 0) }}
            </flux:heading>
            <flux:chart class="-mx-8 -mb-8 h-[3rem]" :value="array_column($chartData, 'profit')">
                <flux:chart.svg gutter="0">
                    <flux:chart.line class="text-green-200 dark:text-green-400" />
                    <flux:chart.area class="text-green-100 dark:text-green-400/30" />
                </flux:chart.svg>
            </flux:chart>
        </flux:card>
        
        <!-- Jobs Card -->
        <flux:card class="overflow-hidden">
            <flux:text>Total Jobs (YTD)</flux:text>
            <flux:heading size="xl" class="mt-2 tabular-nums">
                {{ array_sum(array_column($chartData, 'jobs')) }}
            </flux:heading>
            <flux:chart class="-mx-8 -mb-8 h-[3rem]" :value="array_column($chartData, 'jobs')">
                <flux:chart.svg gutter="0">
                    <flux:chart.line class="text-blue-200 dark:text-blue-400" />
                    <flux:chart.area class="text-blue-100 dark:text-blue-400/30" />
                </flux:chart.svg>
            </flux:chart>
        </flux:card>
    </div>
</div>