<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Services\DVLA;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VehicleController extends Controller
{
    /**
     * The DVLA service instance.
     */
    protected DVLA $dvla;

    /**
     * Create a new controller instance.
     */
    public function __construct(DVLA $dvla)
    {
        $this->dvla = $dvla;
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
        
        return view('vehicle-details', ['vehicle' => $vehicle]);
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