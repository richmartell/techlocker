<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\HaynesPro;
use Exception;

class VehicleLookupController extends Controller
{
    public function index()
    {
        try {
            $makes = app(HaynesPro::class)->getVehicleMakes();
        } catch (\Exception $e) {
            Log::error('Failed to fetch vehicle makes', [
                'error' => $e->getMessage()
            ]);
            $makes = [];
        }

        return view('vehicle-data', [
            'makes' => $makes
        ]);
    }

    public function lookup(Request $request)
    {
        try {
            $request->validate([
                'registration' => 'required|string|max:8'
            ]);

            $registration = strtoupper(preg_replace('/\s+/', '', $request->registration));
            Log::info('Looking up vehicle', ['registration' => $registration]);

            // Check if we already have this vehicle in our database
            $vehicle = Vehicle::where('registration', $registration)->first();

            // If we have the vehicle and it was synced recently (within last 24 hours), return it
            if ($vehicle && $vehicle->last_haynespro_sync_at && $vehicle->last_haynespro_sync_at->diffInHours(now()) < 24) {
                Log::info('Found cached vehicle', ['vehicle' => $vehicle->toArray()]);
                return redirect()->route('vehicle-details', $vehicle->registration);
            }

            // Otherwise, fetch from HaynesPro VRM API
            try {
                Log::info('Vehicle Lookup: Fetching from HaynesPro VRM API', [
                    'registration' => $registration,
                    'haynespro_endpoint' => config('services.haynespro.vrm_token') ? 'configured' : 'not configured'
                ]);
                
                $haynesPro = app(HaynesPro::class);
                $response = $haynesPro->getVehicleDetailsByVrm($registration);

                Log::info('Vehicle Lookup: HaynesPro VRM API response received', [
                    'registration' => $registration,
                    'response_keys' => array_keys($response ?? []),
                    'vehicle_info' => $response['VehicleInfo'] ?? null
                ]);

                if (!empty($response['VehicleInfo'])) {
                    $data = $response['VehicleInfo'];

                    Log::info('Vehicle Lookup: Processing HaynesPro VRM response data', [
                        'registration' => $registration,
                        'available_fields' => array_keys($data ?? []),
                        'make_field' => isset($data['CombinedMake']) ? $data['CombinedMake'] : 'MISSING',
                        'model_field' => isset($data['CombinedModel']) ? $data['CombinedModel'] : 'MISSING', 
                        'fuel_type_field' => isset($data['CombinedFuelType']) ? $data['CombinedFuelType'] : 'MISSING',
                        'engine_capacity_field' => isset($data['CombinedEngineCapacity']) ? $data['CombinedEngineCapacity'] : 'MISSING'
                    ]);

                    // Handle make and model relationships
                    $vehicleMakeId = null;
                    $vehicleModelId = null;

                    if (!empty($data['CombinedMake'])) {
                        Log::info('Vehicle Lookup: Processing make data', [
                            'registration' => $registration,
                            'make_value' => $data['CombinedMake']
                        ]);
                        
                        // Find or create the make
                        $make = VehicleMake::firstOrCreate(
                            ['name' => $data['CombinedMake']]
                        );
                        $vehicleMakeId = $make->id;
                        
                        Log::info('Vehicle Lookup: Make processed', [
                            'registration' => $registration,
                            'make_id' => $vehicleMakeId,
                            'make_name' => $make->name,
                            'was_created' => $make->wasRecentlyCreated
                        ]);
                    } else {
                        Log::warning('Vehicle Lookup: No make field in HaynesPro VRM response', [
                            'registration' => $registration,
                            'response_keys' => array_keys($data ?? [])
                        ]);
                    }

                    if (!empty($data['CombinedModel'])) {
                        Log::info('Vehicle Lookup: Processing model data', [
                            'registration' => $registration,
                            'model_value' => $data['CombinedModel'],
                            'make_id' => $vehicleMakeId
                        ]);
                        
                        // Find or create the model
                        $model = VehicleModel::firstOrCreate([
                            'name' => $data['CombinedModel'],
                            'vehicle_make_id' => $vehicleMakeId
                        ]);
                        $vehicleModelId = $model->id;
                        
                        Log::info('Vehicle Lookup: Model processed', [
                            'registration' => $registration,
                            'model_id' => $vehicleModelId,
                            'model_name' => $model->name,
                            'was_created' => $model->wasRecentlyCreated
                        ]);
                    } else {
                        Log::warning('Vehicle Lookup: No model field in HaynesPro VRM response', [
                            'registration' => $registration,
                            'response_keys' => array_keys($data ?? [])
                        ]);
                    }

                    // Try to get TecdocKtype from VRM API response
                    $tecdocKtype = $data['TecdocKType'] ?? $data['TecdocID'] ?? $data['TecdocKtype'] ?? $data['TecDocKType'] ?? $data['TecDocID'] ?? $data['TecdocNType'] ?? null;
                    
                    // If TecdocKtype is not available from VRM API but we have a VIN, try to get it from the identification API
                    if (!$tecdocKtype && !empty($data['CombinedVin'])) {
                        try {
                            Log::info('Vehicle Lookup: Attempting to get TecdocKtype using VIN', [
                                'registration' => $registration,
                                'vin' => $data['CombinedVin']
                            ]);
                            
                            $identificationResponse = $haynesPro->getIdentificationByVin($data['CombinedVin']);
                            
                            if (!empty($identificationResponse) && is_array($identificationResponse)) {
                                // The response should contain vehicle identification data
                                foreach ($identificationResponse as $identificationData) {
                                    if (isset($identificationData['id'])) {
                                        $tecdocKtype = $identificationData['id'];
                                        Log::info('Vehicle Lookup: Found TecdocKtype from VIN lookup', [
                                            'registration' => $registration,
                                            'vin' => $data['CombinedVin'],
                                            'tecdoc_ktype' => $tecdocKtype
                                        ]);
                                        break; // Use the first match
                                    }
                                }
                            }
                        } catch (\Exception $e) {
                            Log::warning('Vehicle Lookup: Could not get TecdocKtype from VIN', [
                                'registration' => $registration,
                                'vin' => $data['CombinedVin'],
                                'error' => $e->getMessage()
                            ]);
                        }
                    }

                    // Prepare vehicle data for database
                    $vehicleData = [
                        'vehicle_make_id' => $vehicleMakeId,
                        'vehicle_model_id' => $vehicleModelId,
                        'engine_capacity' => $data['CombinedEngineCapacity'] ?? null,
                        'fuel_type' => $data['CombinedFuelType'] ?? null,
                        'transmission' => $data['CombinedTransmission'] ?? null,
                        'forward_gears' => $data['CombinedForwardGears'] ?? null,
                        'combined_vin' => $data['CombinedVin'] ?? null,
                        'haynes_model_variant_description' => $data['HaynesModelVariantDescription'] ?? null,
                        'dvla_date_of_manufacture' => $data['DvlaDateofManufacture'] ?? null,
                        'dvla_last_mileage' => $data['DvlaLastMileage'] ?? null,
                        'dvla_last_mileage_date' => $data['DvlaLastMileageDate'] ?? null,
                        'haynes_maximum_power_at_rpm' => $data['HaynesMaximumPowerAtRpm'] ?? null,
                        'tecdoc_ktype' => $tecdocKtype,
                        'last_haynespro_sync_at' => now(),
                    ];

                    Log::info('Vehicle Lookup: Creating/updating vehicle in database', [
                        'registration' => $registration,
                        'vehicle_data' => $vehicleData,
                        'haynespro_response_fields' => array_keys($data ?? [])
                    ]);
                    
                    // Create or update the vehicle
                    $vehicle = Vehicle::updateOrCreate(
                        ['registration' => $registration],
                        $vehicleData
                    );

                    Log::info('Vehicle Lookup: Vehicle successfully created/updated', [
                        'registration' => $registration,
                        'vehicle_id' => $vehicle->id,
                        'was_recently_created' => $vehicle->wasRecentlyCreated,
                        'final_vehicle_data' => $vehicle->toArray()
                    ]);
                    
                    return redirect()->route('vehicle-details', $vehicle->registration);
                }

                Log::warning('Vehicle Lookup: Vehicle not found in HaynesPro VRM database', [
                    'registration' => $registration,
                    'response_keys' => array_keys($response ?? [])
                ]);
                return back()->withErrors(['registration' => 'Vehicle not found in HaynesPro VRM database. Please check the registration number.']);
            } catch (\Exception $e) {
                Log::error('Vehicle Lookup: HaynesPro VRM API error', [
                    'registration' => $registration,
                    'error_message' => $e->getMessage(),
                    'error_type' => get_class($e),
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'haynespro_config' => [
                        'vrm_token_configured' => !empty(config('services.haynespro.vrm_token')),
                        'vrm_username_configured' => !empty(config('services.haynespro.vrm_username'))
                    ]
                ]);
                return back()->withErrors(['registration' => 'Error looking up vehicle: ' . $e->getMessage()]);
            }
        } catch (\Exception $e) {
            Log::error('Vehicle lookup error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['registration' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }
} 