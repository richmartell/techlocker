<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DiagnosticsController;
use App\Http\Controllers\ApiSettingsController;
use App\Http\Controllers\VehicleLookupController;
use App\Services\HaynesPro;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\TechnicalInformationController;
use App\Http\Controllers\HaynesInspectorController;

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
    
    // Fetch vehicle image from HaynesPro API if car_type_id is available
    $vehicleImage = null;
    if ($vehicle->car_type_id) {
        try {
            $haynesPro = app(HaynesPro::class);
            $vehicleDetails = $haynesPro->getVehicleDetails($vehicle->car_type_id);
            $vehicleImage = $vehicleDetails['image'] ?? null;
        } catch (\Exception $e) {
            Log::warning('Failed to fetch vehicle image', [
                'registration' => $registration,
                'car_type_id' => $vehicle->car_type_id,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    return view('vehicle-details', [
        'vehicle' => $vehicle,
        'vehicleImage' => $vehicleImage
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

Route::get('/vehicle-data/adjustments/{carType}/{carTypeGroup}', function ($carType, $carTypeGroup) {
    try {
        $haynesPro = app(HaynesPro::class);
        $adjustments = $haynesPro->getAdjustments($carType, $carTypeGroup);
        
        if (empty($adjustments)) {
            return back()->with('error', 'No adjustments found for the selected type and group.');
        }
        
        return view('vehicle-adjustments', [
            'adjustments' => $adjustments,
            'carType' => $carType,
            'carTypeGroup' => $carTypeGroup
        ]);
    } catch (\Exception $e) {
        Log::error('Failed to load vehicle adjustments', [
            'carType' => $carType,
            'carTypeGroup' => $carTypeGroup,
            'error' => $e->getMessage()
        ]);
        return back()->with('error', 'Failed to load vehicle adjustments: ' . $e->getMessage());
    }
})->middleware(['auth', 'verified'])->name('vehicle-adjustments');

Route::get('/vehicle-information/{carType}/{carTypeGroup}/{subject}', function($carType, $carTypeGroup, $subject){
    return 1;
})->middleware(['auth', 'verified'])->name('vehicle-information');

Route::get('/vehicle-data/lubricants/{carType}/{carTypeGroup}', function ($carType, $carTypeGroup) {
    try {
        $haynesPro = app(HaynesPro::class);
        $lubricants = $haynesPro->getLubricants($carType, $carTypeGroup);
        
        if (empty($lubricants)) {
            return 'No lubricant information found for this vehicle.';
        }
        
        return view('vehicle-lubricants', [
            'lubricants' => $lubricants,
            'carType' => $carType,
            'carTypeGroup' => $carTypeGroup
        ]);
    } catch (\Exception $e) {
        Log::error('Failed to load vehicle lubricants', [
            'carType' => $carType,
            'carTypeGroup' => $carTypeGroup,
            'error' => $e->getMessage()
        ]);
        // Instead of redirecting back, show a view with an error message
        return view('vehicle-lubricants', [
            'error' => 'Failed to load vehicle lubricants: ' . $e->getMessage(),
            'carType' => $carType,
            'carTypeGroup' => $carTypeGroup,
            'lubricants' => []
        ]);
    }
})->middleware(['auth', 'verified'])->name('vehicle-lubricants');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    
    // API Settings Routes
    Route::get('settings/api', [ApiSettingsController::class, 'show'])->name('settings.api');
    Route::post('settings/api', [ApiSettingsController::class, 'save'])->name('settings.api.save');
    
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
    
    // Haynes Inspector Routes
    Route::prefix('vehicle/{registration}/haynes-inspector')->group(function () {
        Route::get('/', [HaynesInspectorController::class, 'index'])->name('haynes-inspector.index');
        Route::post('/execute/{method}', [HaynesInspectorController::class, 'executeMethod'])->name('haynes-inspector.execute');
    });
});

require __DIR__.'/auth.php';
