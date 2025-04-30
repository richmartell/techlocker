<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VehicleLookupController extends Controller
{
    public function index()
    {
        return view('vehicle-data');
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
            if ($vehicle && $vehicle->last_dvla_sync_at && $vehicle->last_dvla_sync_at->diffInHours(now()) < 24) {
                Log::info('Found cached vehicle', ['vehicle' => $vehicle->toArray()]);
                return redirect()->route('vehicle-details', $vehicle->registration);
            }

            // Otherwise, fetch from DVLA API
            try {
                Log::info('Fetching from DVLA API', ['registration' => $registration]);
                
                $response = Http::withHeaders([
                    'x-api-key' => config('services.dvla.api_key'),
                    'Accept' => 'application/json',
                ])->post(config('services.dvla.endpoint'), [
                    'registrationNumber' => $registration
                ]);

                Log::info('DVLA API response', [
                    'status' => $response->status(),
                    'body' => $response->json()
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    // Handle make and model relationships
                    $vehicleMakeId = null;
                    $vehicleModelId = null;

                    if (!empty($data['make'])) {
                        // Find or create the make
                        $make = VehicleMake::firstOrCreate(
                            ['name' => $data['make']]
                        );
                        $vehicleMakeId = $make->id;

                    }

                    // Create or update the vehicle
                    $vehicle = Vehicle::updateOrCreate(
                        ['registration' => $registration],
                        [
                            'vehicle_make_id' => $vehicleMakeId,
                            'colour' => $data['colour'] ?? null,
                            'engine_capacity' => $data['engineCapacity'] ?? null,
                            'fuel_type' => $data['fuelType'] ?? null,
                            'year_of_manufacture' => $data['yearOfManufacture'] ?? null,
                            'co2_emissions' => $data['co2Emissions'] ?? null,
                            'marked_for_export' => $data['markedForExport'] ?? null,
                            'month_of_first_registration' => $data['monthOfFirstRegistration'] ?? null,
                            'mot_status' => $data['motStatus'] ?? null,
                            'revenue_weight' => $data['revenueWeight'] ?? null,
                            'tax_due_date' => $data['taxDueDate'] ?? null,
                            'tax_status' => $data['taxStatus'] ?? null,
                            'type_approval' => $data['typeApproval'] ?? null,
                            'wheelplan' => $data['wheelplan'] ?? null,
                            'euro_status' => $data['euroStatus'] ?? null,
                            'real_driving_emissions' => $data['realDrivingEmissions'] ?? null,
                            'date_of_last_v5c_issued' => $data['dateOfLastV5CIssued'] ?? null,
                            'last_dvla_sync_at' => now(),
                        ]
                    );

                    Log::info('Vehicle created/updated', ['vehicle' => $vehicle->toArray()]);
                    return redirect()->route('vehicle-details', $vehicle->registration);
                }

                Log::warning('Vehicle not found in DVLA', ['registration' => $registration]);
                return back()->withErrors(['registration' => 'Vehicle not found']);
            } catch (\Exception $e) {
                Log::error('DVLA API error', [
                    'registration' => $registration,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
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