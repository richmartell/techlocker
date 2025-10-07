<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Services\DVLA;
use App\Services\HaynesPro;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    /**
     * The DVLA service instance.
     */
    protected DVLA $dvla;

    /**
     * The HaynesPro service instance.
     */
    protected HaynesPro $haynesPro;

    /**
     * Create a new controller instance.
     */
    public function __construct(DVLA $dvla, HaynesPro $haynesPro)
    {
        $this->dvla = $dvla;
        $this->haynesPro = $haynesPro;
    }

    /**
     * Show vehicle details page
     *
     * @param string $registration
     * @return \Illuminate\View\View
     */
    public function show(string $registration)
    {
        $vehicle = Vehicle::with(['make', 'model'])
            ->where('registration', $registration)
            ->firstOrFail();
        
        // Get vehicle image
        $vehicleImage = $this->getVehicleImage($vehicle);
        
        return view('vehicle-details', [
            'vehicle' => $vehicle,
            'vehicleImage' => $vehicleImage
        ]);
    }

    /**
     * Get vehicle image for a given vehicle
     */
    private function getVehicleImage(Vehicle $vehicle)
    {
        try {
            $carTypeId = $vehicle->car_type_id;
            
            if (!$carTypeId) {
                return null;
            }
            
            $vehicleDetails = $this->haynesPro->getVehicleDetails($carTypeId);
            return $vehicleDetails['image'] ?? null;
        } catch (\Exception $e) {
            Log::warning('Failed to fetch vehicle image', [
                'registration' => $vehicle->registration,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get vehicle details from the DVLA API.
     *
     * @param Request $request
     * @param string $registration
     * @return JsonResponse
     */
    public function getDetails(Request $request, string $registration): JsonResponse
    {
        try {
            $vehicleDetails = $this->dvla->getVehicleDetails($registration);
            
            return response()->json([
                'success' => true,
                'data' => $vehicleDetails,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
} 