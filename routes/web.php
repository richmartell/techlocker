<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DiagnosticsController;
use App\Http\Controllers\ApiSettingsController;
use App\Http\Controllers\VehicleLookupController;
use App\Services\HaynesPro;
use Illuminate\Support\Facades\Log;

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

// Vehicle Data routes
Route::get('vehicle-data', [VehicleLookupController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('vehicle-data');

Route::post('vehicle-data/lookup', [VehicleLookupController::class, 'lookup'])
    ->middleware(['auth', 'verified'])
    ->name('vehicle-data.lookup');

// Add Vehicle Details route
Route::get('vehicle/{registration}', function ($registration) {
    $vehicle = \App\Models\Vehicle::with(['make', 'model'])
        ->where('registration', $registration)
        ->firstOrFail();
    return view('vehicle-details', ['vehicle' => $vehicle]);
})->middleware(['auth', 'verified'])
  ->name('vehicle-details');

// Add DiagnosticsAI route
Route::get('vehicle/{registration}/diagnostics', [DiagnosticsController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('vehicle-diagnostics');

// Add DiagnosticsAI message processing route
Route::post('vehicle/{registration}/diagnostics/process', [DiagnosticsController::class, 'processMessage'])
    ->middleware(['auth', 'verified'])
    ->name('process-diagnostics');

// Add route to test OpenAI API connection
Route::get('diagnostics/test-api', [DiagnosticsController::class, 'testApiConnection'])
    ->middleware(['auth', 'verified'])
    ->name('test-diagnostics-api');

// Add route to fetch models for a make
Route::get('/vehicle-data/models/{makeId}', function ($makeId) {
    try {
        $haynesPro = app(HaynesPro::class);
        $models = $haynesPro->getVehicleModels($makeId);
        return response()->json(['models' => $models]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->middleware(['auth', 'verified'])->name('vehicle-data.models');

Route::get('/vehicle-data/types/{makeId}', function ($makeId) {
    try {
        $haynesPro = app(HaynesPro::class);
        $types = $haynesPro->getVehicleTypes($makeId);
        return response()->json(['types' => $types]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->middleware(['auth', 'verified'])->name('vehicle-data.types');

Route::get('/vehicle-data/type/{typeId}', function ($typeId) {
    try {
        $haynesPro = app(HaynesPro::class);
        $details = $haynesPro->getVehicleDetails($typeId);
        
        if (empty($details)) {
            return back()->with('error', 'No vehicle details found for the selected type.');
        }
        
        return view('vehicle-type', ['details' => $details]);
    } catch (\Exception $e) {
        Log::error('Failed to load vehicle details', [
            'typeId' => $typeId,
            'error' => $e->getMessage()
        ]);
        return back()->with('error', 'Failed to load vehicle details: ' . $e->getMessage());
    }
})->middleware(['auth', 'verified'])->name('vehicle-type');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    
    // API Settings Routes
    Route::get('settings/api', [ApiSettingsController::class, 'show'])->name('settings.api');
    Route::post('settings/api', [ApiSettingsController::class, 'save'])->name('settings.api.save');
});

require __DIR__.'/auth.php';
