<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DiagnosticsController;

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

// Add Vehicle Data route
Route::view('vehicle-data', 'vehicle-data')
    ->middleware(['auth', 'verified'])
    ->name('vehicle-data');

// Add Vehicle Details route
Route::get('vehicle/{registration}', function ($registration) {
    // For now, we're hardcoding data for the Land Rover example
    return view('vehicle-details', [
        'make' => 'Land Rover',
        'model' => 'Defender 90',
        'year' => '2020',
        'registration' => $registration,
        'engine' => '2.0L P300 Ingenium',
        'power' => '300 hp (224 kW)',
        'torque' => '400 Nm (295 lb-ft)',
        'transmission' => '8-speed Automatic',
        'length' => '4,583 mm (180.4 in)',
        'width' => '2,105 mm (82.9 in)',
        'height' => '1,974 mm (77.7 in)',
        'wheelbase' => '2,587 mm (101.9 in)',
        'acceleration' => '7.1 seconds',
        'topSpeed' => '191 km/h (119 mph)',
        'fuelEconomy' => '9.6 L/100km (29.4 mpg)',
        'features' => [
            'Terrain Response 2',
            'Air Suspension',
            'Wade Sensing',
            'ClearSight Ground View'
        ]
    ]);
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

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
