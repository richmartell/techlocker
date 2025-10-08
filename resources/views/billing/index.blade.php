<x-layouts.app :title="'Billing'">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-6">
                <!-- Header -->
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold">Billing</h1>
                        <p class="text-lg text-neutral-600 dark:text-neutral-400">
                            Manage your subscription and billing information
                        </p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="p-4 rounded-lg bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-800">
                        <p class="text-green-800 dark:text-green-200">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 rounded-lg bg-red-100 dark:bg-red-900 border border-red-200 dark:border-red-800">
                        <p class="text-red-800 dark:text-red-200">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Trial Status Banner -->
                @if($isOnTrial)
                    <div class="p-6 rounded-xl border-2 border-lime-400 dark:border-lime-500 bg-gradient-to-r from-lime-50 to-emerald-50 dark:from-lime-900/20 dark:to-emerald-900/20">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-lime-600 dark:text-lime-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-lime-900 dark:text-lime-100 mb-2">
                                    Free Trial Active
                                </h3>
                                <div class="space-y-2">
                                    <p class="text-base text-lime-800 dark:text-lime-200">
                                        You have <span class="font-bold text-lg">{{ $trialDaysRemaining }} {{ Str::plural('day', $trialDaysRemaining) }}</span> remaining in your trial period.
                                    </p>
                                    @if($trialDaysRemaining <= 7)
                                        <p class="text-sm text-lime-700 dark:text-lime-300">
                                            ⚠️ Your trial is ending soon. Subscribe to a plan to continue using garageIQ without interruption.
                                        </p>
                                    @else
                                        <p class="text-sm text-lime-700 dark:text-lime-300">
                                            Enjoy full access to all features. Subscribe anytime to continue after your trial ends.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($hasReseller)
                    <!-- Reseller-Managed Billing Section -->
                    <div class="p-6 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            Your Billing is Managed by a Reseller
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Reseller Information -->
                            <div class="p-4 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                <h3 class="font-semibold text-lg mb-4">Reseller Contact</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm text-neutral-600 dark:text-neutral-400">Company Name</dt>
                                        <dd class="text-base font-medium text-neutral-900 dark:text-neutral-100">{{ $reseller->company_name }}</dd>
                                    </div>
                                    @if($reseller->contact_email)
                                    <div>
                                        <dt class="text-sm text-neutral-600 dark:text-neutral-400">Email</dt>
                                        <dd class="text-base font-medium text-neutral-900 dark:text-neutral-100">
                                            <a href="mailto:{{ $reseller->contact_email }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                                {{ $reseller->contact_email }}
                                            </a>
                                        </dd>
                                    </div>
                                    @endif
                                    @if($reseller->contact_phone)
                                    <div>
                                        <dt class="text-sm text-neutral-600 dark:text-neutral-400">Phone</dt>
                                        <dd class="text-base font-medium text-neutral-900 dark:text-neutral-100">
                                            <a href="tel:{{ $reseller->contact_phone }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                                {{ $reseller->contact_phone }}
                                            </a>
                                        </dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>

                            <!-- Current Plan -->
                            <div class="p-4 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                <h3 class="font-semibold text-lg mb-4">Your Current Plan</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm text-neutral-600 dark:text-neutral-400">Plan Name</dt>
                                        <dd class="text-base font-medium text-neutral-900 dark:text-neutral-100">{{ $plan->name ?? 'Not Set' }}</dd>
                                    </div>
                                    @if($plan && $plan->description)
                                    <div>
                                        <dt class="text-sm text-neutral-600 dark:text-neutral-400">Description</dt>
                                        <dd class="text-sm text-neutral-700 dark:text-neutral-300">{{ $plan->description }}</dd>
                                    </div>
                                    @endif
                                    <div>
                                        <dt class="text-sm text-neutral-600 dark:text-neutral-400">Account Status</dt>
                                        <dd>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $account->status_color }}-100 text-{{ $account->status_color }}-800 dark:bg-{{ $account->status_color }}-900 dark:text-{{ $account->status_color }}-200">
                                                {{ $account->status_label }}
                                            </span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="mt-6 p-4 rounded-lg bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400 mr-3 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h4 class="font-medium text-blue-900 dark:text-blue-200 mb-1">Need to Make Changes?</h4>
                                    <p class="text-sm text-blue-800 dark:text-blue-300">
                                        Your billing and subscription are managed by your reseller. Please contact them directly for any billing inquiries, plan changes, or invoices.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Direct Billing Section (No Reseller) -->
                    <div class="space-y-6">
                        <!-- Current Subscription Status -->
                        <div class="p-6 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                            <h2 class="text-xl font-semibold mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                Current Subscription
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="p-4 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                    <h3 class="font-semibold mb-3">Subscription Details</h3>
                                    <dl class="space-y-2">
                                        <div>
                                            <dt class="text-sm text-neutral-600 dark:text-neutral-400">Plan</dt>
                                            <dd class="text-base font-medium text-neutral-900 dark:text-neutral-100">{{ $plan->name ?? 'No Active Plan' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm text-neutral-600 dark:text-neutral-400">Status</dt>
                                            <dd>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $account->status_color }}-100 text-{{ $account->status_color }}-800 dark:bg-{{ $account->status_color }}-900 dark:text-{{ $account->status_color }}-200">
                                                    {{ $account->status_label }}
                                                </span>
                                            </dd>
                                        </div>
                                        @if($hasActiveSubscription && $subscription)
                                        <div>
                                            <dt class="text-sm text-neutral-600 dark:text-neutral-400">Billing Cycle</dt>
                                            <dd class="text-base text-neutral-900 dark:text-neutral-100">
                                                {{ ucfirst($subscription->stripe_price) }}
                                            </dd>
                                        </div>
                                        @endif
                                    </dl>
                                </div>

                                <div class="p-4 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                                    <h3 class="font-semibold mb-3">Manage Billing</h3>
                                    @if($hasActiveSubscription)
                                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                                            Manage your subscription, update payment methods, view invoices, and more through the Stripe Customer Portal.
                                        </p>
                                        <form action="{{ route('billing.portal') }}" method="POST">
                                            @csrf
                                            <flux:button type="submit" variant="primary" class="w-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                                </svg>
                                                Manage in Stripe Portal
                                            </flux:button>
                                        </form>
                                    @else
                                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                                            You don't have an active subscription. Subscribe to a plan below to get started.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Available Plans (if no active subscription) -->
                        @if(!$hasActiveSubscription)
                        <div class="p-6 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
                            <h2 class="text-xl font-semibold mb-4">Available Plans</h2>
                            <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                                Choose a plan that best fits your workshop needs. You can change or cancel anytime.
                            </p>

                            <div class="p-6 rounded-lg bg-white dark:bg-neutral-800 border-2 border-primary-500 text-center">
                                <h3 class="text-2xl font-bold mb-2">Start Your Subscription</h3>
                                <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                                    Click below to view available plans and start your subscription through Stripe.
                                </p>
                                <form action="{{ route('billing.checkout') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="price_id" value="{{ env('STRIPE_PRICE_ID', 'price_xxxx') }}">
                                    <flux:button type="submit" variant="primary" class="h-12 px-6 text-base">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                        </svg>
                                        View Plans & Subscribe
                                    </flux:button>
                                </form>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-4">
                                    You'll be redirected to Stripe to complete your subscription
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>

