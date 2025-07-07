<div>
    @if($showModal)
        <!-- Modal Backdrop -->
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
            <!-- Modal Container -->
            <div class="relative w-full max-w-2xl bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden">
                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 dark:bg-neutral-700 h-1">
                    <div class="h-1 bg-primary-600 transition-all duration-300 ease-out" 
                         style="width: {{ ($currentSlide / $totalSlides) * 100 }}%"></div>
                </div>

                <!-- Modal Content -->
                <div class="p-8">
                    <!-- Slide 1: Welcome -->
                    @if($currentSlide === 1)
                        <div class="text-center">
                            <div class="mx-auto w-20 h-20 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                Welcome to TechLocker! 🎉
                            </h2>
                            <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                                Let's take a quick tour to help you get started with your workshop management platform.
                            </p>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                This will only take a minute
                            </div>
                        </div>
                    @endif

                    <!-- Slide 2: Dashboard Overview -->
                    @if($currentSlide === 2)
                        <div class="text-center">
                            <div class="mx-auto w-20 h-20 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                Your Dashboard
                            </h2>
                            <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                                Get a complete overview of your workshop's performance with real-time metrics, revenue tracking, and customer insights.
                            </p>
                            <div class="bg-gray-50 dark:bg-neutral-700 rounded-lg p-4 text-left">
                                <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Monthly revenue tracking
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Customer analytics
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Performance charts
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Slide 3: Vehicle Data Access -->
                    @if($currentSlide === 3)
                        <div class="text-center">
                            <div class="mx-auto w-20 h-20 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                Vehicle Data Access
                            </h2>
                            <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                                Access comprehensive vehicle technical data, repair procedures, and diagnostic information all in one place.
                            </p>
                            <div class="bg-gray-50 dark:bg-neutral-700 rounded-lg p-4 text-left">
                                <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Technical specifications
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Repair procedures
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Diagnostic information
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Maintenance schedules
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Slide 4: Get Started -->
                    @if($currentSlide === 4)
                        <div class="text-center">
                            <div class="mx-auto w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                You're All Set!
                            </h2>
                            <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                                You're ready to start managing your workshop more efficiently with TechLocker. Explore the features and let us know if you need any help!
                            </p>
                            <div class="bg-gradient-to-r from-primary-50 to-blue-50 dark:from-primary-900 dark:to-blue-900 rounded-lg p-6">
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Quick Start Tips:</h3>
                                <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                    <li>• Start by exploring the Vehicle Data section</li>
                                    <li>• Check your dashboard for key metrics</li>
                                    <li>• Access help documentation anytime</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="px-8 py-6 bg-gray-50 dark:bg-neutral-700 flex items-center justify-between">
                    <!-- Slide Indicators -->
                    <div class="flex space-x-2">
                        @for($i = 1; $i <= $totalSlides; $i++)
                            <button 
                                wire:click="goToSlide({{ $i }})"
                                class="w-2 h-2 rounded-full transition-all duration-200 {{ $currentSlide === $i ? 'bg-primary-600' : 'bg-gray-300 dark:bg-gray-600' }}"
                            ></button>
                        @endfor
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center space-x-3">
                        @if($currentSlide > 1)
                            <button 
                                wire:click="previousSlide"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors"
                            >
                                Previous
                            </button>
                        @endif

                        @if($currentSlide < $totalSlides)
                            <button 
                                wire:click="nextSlide"
                                class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors"
                            >
                                Next
                            </button>
                        @else
                            <button 
                                wire:click="completeTour"
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors"
                            >
                                Get Started
                            </button>
                        @endif

                        <button 
                            wire:click="skipTour"
                            class="px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
                        >
                            Skip Tour
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
