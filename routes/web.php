<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DiagnosticsController;
use App\Http\Controllers\ApiSettingsController;
use App\Http\Controllers\VehicleLookupController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleDataController;
use App\Http\Controllers\TechnicalInformationController;
use App\Http\Controllers\HaynesInspectorController;
use App\Http\Controllers\AdjustmentsController;
use App\Http\Controllers\BillingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
})->name('home');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/diagnostics-ai', [DiagnosticsController::class, 'index'])->middleware(['auth', 'verified'])->name('diagnostics-ai');

Route::post('/diagnostics-ai/submit', [DiagnosticsController::class, 'submit'])->middleware(['auth', 'verified'])->name('diagnostics-ai.submit');

Route::get('/vehicle-lookup', [VehicleLookupController::class, 'index'])->middleware(['auth', 'verified'])->name('vehicle-lookup');

Route::post('/vehicle-lookup/search', [VehicleLookupController::class, 'search'])->middleware(['auth', 'verified'])->name('vehicle-lookup.search');

Route::post('/vehicle-lookup/save', [VehicleLookupController::class, 'save'])->middleware(['auth', 'verified'])->name('vehicle-lookup.save');

Route::get('/dvla-lookup', \App\Livewire\Vehicles\DvlaLookup::class)->middleware(['auth', 'verified'])->name('dvla-lookup');

Route::get('/vehicle/{registration}', [VehicleController::class, 'show'])->middleware(['auth', 'verified'])->name('vehicle-details');

Route::get('/vehicle-data/makes', [VehicleDataController::class, 'makes'])->middleware(['auth', 'verified'])->name('vehicle-data.makes');

Route::get('/vehicle-data/models/{makeId}', [VehicleDataController::class, 'models'])->middleware(['auth', 'verified'])->name('vehicle-data.models');

Route::get('/vehicle-data/types/{modelId}', [VehicleDataController::class, 'types'])->middleware(['auth', 'verified'])->name('vehicle-data.types');

Route::get('/vehicle-data/type/{typeId}', [VehicleDataController::class, 'typeDetails'])->middleware(['auth', 'verified'])->name('vehicle-type');

Route::get('/vehicle-data/adjustments/{carType}/{carTypeGroup}', [VehicleDataController::class, 'adjustments'])->middleware(['auth', 'verified'])->name('vehicle-adjustments');

Route::get('/vehicle-information/{carType}/{carTypeGroup}/{subject}', [VehicleDataController::class, 'information'])->middleware(['auth', 'verified'])->name('vehicle-information');

Route::get('/vehicle-data/lubricants/{carType}/{carTypeGroup}', [VehicleDataController::class, 'lubricants'])->middleware(['auth', 'verified'])->name('vehicle-lubricants');

Route::middleware(['auth', 'verified'])->group(function () {
    // Customer Management Routes
    Route::get('/customers', \App\Livewire\Customers\Index::class)->name('customers.index');
    Route::get('/customers/{customer}', \App\Livewire\Customers\Show::class)->name('customers.show');
    Route::post('/customers/{customer}/restore', function (\App\Models\Customer $customer) {
        $customer->restore();
        return redirect()->route('customers.show', $customer)->with('success', 'Customer restored successfully.');
    })->name('customers.restore');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    
    // Branding Settings Route
    Route::get('settings/branding', \App\Livewire\Settings\Branding::class)->name('settings.branding');
    
    // Labour Settings Route
    Route::get('settings/labour', \App\Livewire\Settings\Labour::class)->name('settings.labour');
    
    // API Settings Routes
    Route::get('settings/api', [ApiSettingsController::class, 'show'])->name('settings.api');
    Route::post('settings/api', [ApiSettingsController::class, 'save'])->name('settings.api.save');

    // Billing Routes
    Route::get('billing', [BillingController::class, 'index'])->name('billing.index');
    Route::post('billing/portal', [BillingController::class, 'portal'])->name('billing.portal');
    Route::post('billing/checkout', [BillingController::class, 'checkout'])->name('billing.checkout');
    Route::get('billing/success', [BillingController::class, 'success'])->name('billing.success');
    
    // Technical Information Routes
    Route::prefix('vehicle/{registration}/technical')->group(function () {
        Route::get('/', [TechnicalInformationController::class, 'index'])->name('technical-information.index');
        Route::get('/maintenance-systems', [TechnicalInformationController::class, 'maintenanceSystems'])->name('technical-information.maintenance-systems');
        Route::get('/maintenance-tasks', [TechnicalInformationController::class, 'maintenanceTasks'])->name('technical-information.maintenance-tasks');
        Route::get('/adjustments/{systemGroup}', [TechnicalInformationController::class, 'adjustments'])->name('technical-information.adjustments');
        Route::get('/lubricants/{systemGroup}', [TechnicalInformationController::class, 'lubricants'])->name('technical-information.lubricants');
        Route::get('/technical-drawings/{systemGroup}', [TechnicalInformationController::class, 'technicalDrawings'])->name('technical-information.technical-drawings');
        Route::get('/wiring-diagrams', [TechnicalInformationController::class, 'wiringDiagrams'])->name('technical-information.wiring-diagrams');
        Route::get('/fuse-locations', [TechnicalInformationController::class, 'fuseLocations'])->name('technical-information.fuse-locations');
        Route::get('/repair-times/{systemGroup?}', [TechnicalInformationController::class, 'repairTimes'])->name('technical-information.repair-times');
    });
    
    // Adjustments Routes
    Route::prefix('vehicle/{registration}/adjustments')->group(function () {
        Route::get('/engine-general', [AdjustmentsController::class, 'engineGeneral'])->name('adjustments.engine-general');
        Route::get('/engine-specifications', [AdjustmentsController::class, 'engineSpecifications'])->name('adjustments.engine-specifications');
        Route::get('/emissions', [AdjustmentsController::class, 'emissions'])->name('adjustments.emissions');
        Route::get('/cooling-system', [AdjustmentsController::class, 'coolingSystem'])->name('adjustments.cooling-system');
        Route::get('/electrical', [AdjustmentsController::class, 'electrical'])->name('adjustments.electrical');
        Route::get('/brakes', [AdjustmentsController::class, 'brakes'])->name('adjustments.brakes');
        Route::get('/steering', [AdjustmentsController::class, 'steering'])->name('adjustments.steering');
        Route::get('/wheels-tyres', [AdjustmentsController::class, 'wheelsTyres'])->name('adjustments.wheels-tyres');
        Route::get('/capacities', [AdjustmentsController::class, 'capacities'])->name('adjustments.capacities');
        Route::get('/torque-settings', [AdjustmentsController::class, 'torqueSettings'])->name('adjustments.torque-settings');
    });
    
    // Vehicle Diagnostics Routes
    Route::get('/vehicle/{registration}/diagnostics', [DiagnosticsController::class, 'show'])->middleware(['auth', 'verified'])->name('vehicle-diagnostics');
    Route::post('/vehicle/{registration}/diagnostics/process', [DiagnosticsController::class, 'processMessage'])->middleware(['auth', 'verified'])->name('vehicle-diagnostics.process');
    
    // Diagnostics Logs (Debug only)
    Route::get('/diagnostics/logs', [DiagnosticsController::class, 'showLogs'])->name('diagnostics.logs');
    
    // Haynes Inspector Routes
    Route::prefix('vehicle/{registration}/haynes-inspector')->group(function () {
        Route::get('/', [HaynesInspectorController::class, 'index'])->name('haynes-inspector.index');
        Route::post('/execute/{method}', [HaynesInspectorController::class, 'executeMethod'])->name('haynes-inspector.execute');
    });
    
    // Maintenance Routes
    Route::prefix('vehicle/{registration}/maintenance')->group(function () {
        Route::get('/schedules', [TechnicalInformationController::class, 'schedules'])->name('maintenance.schedules');
        Route::get('/schedules/{systemId}/{periodId}', [TechnicalInformationController::class, 'scheduleDetails'])->name('maintenance.schedule-details');
        
        // Procedures listing page
        Route::get('/procedures', [TechnicalInformationController::class, 'procedures'])->name('maintenance.procedures');
        
        // Lubricants page
        Route::get('/lubricants', [TechnicalInformationController::class, 'maintenanceLubricants'])->name('maintenance.lubricants');
        
        // Generic route for any maintenance story
        Route::get('/story/{storyId}', [TechnicalInformationController::class, 'maintenanceStory'])->name('maintenance.story');
        
    // Keep legacy route for backwards compatibility
    Route::get('/service-indicator-reset', [TechnicalInformationController::class, 'serviceIndicatorReset'])->name('maintenance.service-indicator-reset');
    });

    // Drawings Routes
    Route::prefix('vehicle/{registration}/drawings')->group(function () {
        Route::get('/', [TechnicalInformationController::class, 'drawingsIndex'])->name('drawings.index');
    });

    // Repair Times Routes
    Route::prefix('vehicle/{registration}/repair-times')->group(function () {
        Route::get('/', \App\Livewire\RepairTimes\Index::class)->name('repair-times.index');
    });

    // Quotes Routes
    Route::prefix('quotes')->group(function () {
        Route::get('/create/{quote?}', \App\Livewire\Quotes\Create::class)->name('quotes.create');
        Route::get('/{quote}', \App\Livewire\Quotes\Show::class)->name('quotes.show');
        Route::get('/{quote}/pdf', [\App\Http\Controllers\QuoteController::class, 'downloadPdf'])->name('quotes.pdf');
    });

    // Jobs routes  
    Route::get('/jobs', \App\Livewire\Jobs\Index::class)->name('workshop.jobs.index');
    Route::get('/jobs/create', \App\Livewire\Jobs\Upsert::class)->name('workshop.jobs.create');
    Route::get('/jobs/{job}/edit', \App\Livewire\Jobs\Upsert::class)
        ->whereUlid('job')
        ->name('workshop.jobs.edit');
    Route::get('/jobs/{job}', \App\Livewire\Jobs\Show::class)
        ->whereUlid('job')
        ->name('workshop.jobs.show');

    // Technicians (under settings)
    Route::get('/settings/technicians', \App\Livewire\Settings\Technicians\Index::class)->name('settings.technicians.index');
    Route::get('/settings/technicians/create', \App\Livewire\Settings\Technicians\Upsert::class)->name('settings.technicians.create');
    Route::get('/settings/technicians/{technician}', \App\Livewire\Settings\Technicians\Show::class)->name('settings.technicians.show');
    Route::get('/settings/technicians/{technician}/edit', \App\Livewire\Settings\Technicians\Upsert::class)->name('settings.technicians.edit');
});

require __DIR__.'/auth.php';
