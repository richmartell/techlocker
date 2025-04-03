<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-primary-600">GarageIQ</a>
            </div>
            <flux:heading level="2" class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Create your account
            </flux:heading>
            <flux:text class="mt-2 text-center text-sm text-gray-600">
                Or
                <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                    sign in to your existing account
                </a>
            </flux:text>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md" style="font-family: 'Inter', sans-serif !important;">
            <div class="bg-white px-4 py-8 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" action="#" method="POST">
                    @csrf

                    <flux:field>
                        <flux:label for="name">Full Name</flux:label>
                        <flux:input 
                            id="name" 
                            name="name" 
                            type="text" 
                            autocomplete="name" 
                            required 
                        />
                        <flux:error name="name" />
                    </flux:field>

                    <flux:field>
                        <flux:label for="email">Email address</flux:label>
                        <flux:input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required 
                        />
                        <flux:error name="email" />
                    </flux:field>

                    <flux:field>
                        <flux:label for="company">Company Name</flux:label>
                        <flux:input 
                            id="company" 
                            name="company" 
                            type="text" 
                            autocomplete="organization" 
                            required 
                        />
                        <flux:error name="company" />
                    </flux:field>

                    <flux:field>
                        <flux:label for="phone">Phone Number</flux:label>
                        <flux:input 
                            id="phone" 
                            name="phone" 
                            type="tel" 
                            autocomplete="tel" 
                        />
                        <flux:error name="phone" />
                    </flux:field>

                    <flux:field>
                        <flux:label for="password">Password</flux:label>
                        <flux:input 
                            id="password" 
                            name="password" 
                            type="password" 
                            autocomplete="new-password" 
                            required 
                        />
                        <flux:error name="password" />
                    </flux:field>

                    <flux:field>
                        <flux:label for="password_confirmation">Confirm Password</flux:label>
                        <flux:input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            autocomplete="new-password" 
                            required 
                        />
                        <flux:error name="password_confirmation" />
                    </flux:field>

                    <div class="flex items-center">
                        <flux:checkbox id="terms" name="terms" required />
                        <label for="terms" class="ml-2 block text-sm text-gray-900">
                            I agree to the 
                            <a href="#" class="font-medium text-primary-600 hover:text-primary-500">Terms of Service</a>
                            and
                            <a href="#" class="font-medium text-primary-600 hover:text-primary-500">Privacy Policy</a>
                        </label>
                    </div>

                    <div>
                        <flux:button type="submit" variant="primary" class="w-full">
                            Register
                        </flux:button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="bg-white px-2 text-gray-500">Or continue with</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div>
                            <a href="#" class="inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                <span class="sr-only">Sign in with Google</span>
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                                </svg>
                            </a>
                        </div>

                        <div>
                            <a href="#" class="inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                <span class="sr-only">Sign in with Microsoft</span>
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M11.4 24H0V12.6h11.4V24zM24 24H12.6V12.6H24V24zM11.4 11.4H0V0h11.4v11.4zM24 11.4H12.6V0H24v11.4z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout> 