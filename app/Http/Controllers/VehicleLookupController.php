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

            // If we have the vehicle with recent car type identification, return it
            if ($vehicle && $vehicle->hasRecentCarTypeIdentification()) {
                Log::info('Found cached vehicle with recent identification', ['vehicle' => $vehicle->toArray()]);
                return redirect()->route('vehicle-details', $vehicle->registration);
            }

            // Otherwise, perform complete vehicle identification using HaynesPro APIs
            try {
                Log::info('Vehicle Lookup: Starting complete vehicle identification', [
                    'registration' => $registration
                ]);

                $haynesProService = app(HaynesPro::class);
                $identificationData = $haynesProService->identifyVehicleComplete($registration);

                // Handle cases where no vehicle data is found
                if (empty($identificationData['vehicle_data']) || 
                    $identificationData['identification_method'] === 'not_found') {
                    
                    $errorMessage = $identificationData['error'] ?? 'No vehicle found with registration ' . $registration;
                    
                    Log::warning('Vehicle Lookup: No vehicle information found', [
                        'registration' => $registration,
                        'identification_method' => $identificationData['identification_method'] ?? 'unknown'
                    ]);
                    
                    return back()->with('error', $errorMessage);
                }

                $vehicleInfo = $identificationData['vehicle_data'];
                $carTypeId = $identificationData['car_type_id'];
                $availableSubjects = $identificationData['available_subjects'];

                Log::info('Vehicle Lookup: Successfully identified vehicle', [
                    'registration' => $registration,
                    'car_type_id' => $carTypeId,
                    'subjects_count' => count($availableSubjects),
                    'identification_method' => $identificationData['identification_method']
                ]);

                // Create or update the vehicle record
                if (!$vehicle) {
                    $vehicle = new Vehicle();
                    $vehicle->registration = $registration;
                }

                // Map VRM API data to vehicle model
                $vehicle->engine_capacity = !empty($vehicleInfo['CombinedEngineCapacity']) ? intval($vehicleInfo['CombinedEngineCapacity']) : null;
                $vehicle->fuel_type = $vehicleInfo['CombinedFuelType'] ?? null;
                $vehicle->transmission = $vehicleInfo['CombinedTransmission'] ?? null;
                $vehicle->forward_gears = !empty($vehicleInfo['CombinedForwardGears']) ? intval($vehicleInfo['CombinedForwardGears']) : null;
                $vehicle->combined_vin = $vehicleInfo['CombinedVin'] ?? null;
                $vehicle->haynes_model_variant_description = $vehicleInfo['HaynesModelVariantDescription'] ?? null;
                $vehicle->dvla_date_of_manufacture = $vehicleInfo['DvlaDateofManufacture'] ?? null;
                $vehicle->dvla_last_mileage = !empty($vehicleInfo['DvlaLastMileage']) ? intval($vehicleInfo['DvlaLastMileage']) : null;
                $vehicle->dvla_last_mileage_date = $vehicleInfo['DvlaLastMileageDate'] ?? null;
                $vehicle->haynes_maximum_power_at_rpm = $vehicleInfo['HaynesMaximumPowerAtRpm'] ?? null;
                $vehicle->tecdoc_ktype = $vehicleInfo['TecdocKType'] ?? $vehicleInfo['TecDocKType'] ?? null;
                
                // Set new car type identification fields
                $vehicle->car_type_id = $carTypeId;
                $vehicle->setAvailableSubjectsFromArray($availableSubjects);
                $vehicle->car_type_identified_at = now();
                $vehicle->last_haynespro_sync_at = now();

                // Handle vehicle make and model
                if (!empty($vehicleInfo['CombinedMake'])) {
                    $makeName = $vehicleInfo['CombinedMake'];
                    $make = VehicleMake::firstOrCreate(['name' => $makeName]);
                    $vehicle->vehicle_make_id = $make->id;

                    if (!empty($vehicleInfo['CombinedModel'])) {
                        $modelName = $vehicleInfo['CombinedModel'];
                        $model = VehicleModel::firstOrCreate([
                            'name' => $modelName,
                            'vehicle_make_id' => $make->id
                        ]);
                        $vehicle->vehicle_model_id = $model->id;
                    }
                }

                $vehicle->save();

                Log::info('Vehicle Lookup: Vehicle saved successfully with car type identification', [
                    'registration' => $registration,
                    'vehicle_id' => $vehicle->id,
                    'car_type_id' => $carTypeId,
                    'subjects_count' => count($availableSubjects)
                ]);

                return redirect()->route('vehicle-details', $vehicle->registration);

            } catch (Exception $e) {
                Log::error('Vehicle Lookup: Exception during vehicle identification', [
                    'registration' => $registration,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return back()->with('error', 'Failed to identify vehicle: ' . $e->getMessage());
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