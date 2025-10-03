<?php

use App\Livewire\Admin\Accounts\Index as AccountsIndex;
use App\Livewire\Admin\Accounts\Show as AccountsShow;
use App\Livewire\Admin\Auth\Login as AdminLogin;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Admin Login (Guest)
Route::get('/admin/login', AdminLogin::class)->name('admin.login');

// Admin Logout
Route::post('/admin/logout', function () {
    Auth::guard('admin')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('admin.logout');

// Admin Protected Routes
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    
    // Accounts
    Route::get('/accounts', AccountsIndex::class)->name('accounts.index');
    Route::get('/accounts/{account}', AccountsShow::class)->name('accounts.show');
    
    // Plans
    Route::get('/plans', \App\Livewire\Admin\Plans\Index::class)->name('plans.index');
    Route::get('/plans/create', \App\Livewire\Admin\Plans\Upsert::class)->name('plans.create');
    Route::get('/plans/{plan}/edit', \App\Livewire\Admin\Plans\Upsert::class)->name('plans.edit');
    
    // Invoices
    Route::get('/invoices', \App\Livewire\Admin\Invoices\Index::class)->name('invoices.index');
});

