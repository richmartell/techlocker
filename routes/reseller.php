<?php

use App\Livewire\Reseller\Auth\Login as ResellerLogin;
use App\Livewire\Reseller\Dashboard as ResellerDashboard;
use App\Livewire\Reseller\Customers\Index as CustomersIndex;
use App\Livewire\Reseller\Customers\Show as CustomersShow;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Reseller Routes
|--------------------------------------------------------------------------
|
| Here is where you can register reseller routes for your application.
|
*/

// Reseller Login (Guest)
Route::get('/reseller/login', ResellerLogin::class)->name('reseller.login');

// Reseller Logout
Route::post('/reseller/logout', function () {
    Auth::guard('reseller')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('reseller.login');
})->name('reseller.logout');

// Reseller Protected Routes
Route::middleware('reseller')->prefix('reseller')->name('reseller.')->group(function () {
    Route::get('/dashboard', ResellerDashboard::class)->name('dashboard');
    Route::get('/customers', CustomersIndex::class)->name('customers');
    Route::get('/customers/create', \App\Livewire\Reseller\Customers\Create::class)->name('customers.create');
    Route::get('/customers/{account}', CustomersShow::class)->name('customers.show');
});

