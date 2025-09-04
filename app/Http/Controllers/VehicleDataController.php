<?php

namespace App\Http\Controllers;

use App\Services\HaynesPro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleDataController extends Controller
{
    protected $haynesPro;

    public function __construct(HaynesPro $haynesPro)
    {
        $this->haynesPro = $haynesPro;
    }

    /**
     * Get all vehicle makes
     */
    public function makes()
    {
        try {
            $makes = $this->haynesPro->getVehicleMakes();
            return response()->json(['makes' => $makes]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get vehicle models for a specific make
     */
    public function models($makeId)
    {
        try {
            $models = $this->haynesPro->getVehicleModels($makeId);
            return response()->json(['models' => $models]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get vehicle types for a specific make and model
     */
    public function types($makeId, $modelId)
    {
        try {
            $types = $this->haynesPro->getVehicleTypes($makeId);
            return response()->json(['types' => $types]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get vehicle type details
     */
    public function typeDetails($typeId)
    {
        try {
            $details = $this->haynesPro->getVehicleDetails($typeId);
            
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
    }

    /**
     * Get vehicle adjustments
     */
    public function adjustments($carType, $carTypeGroup)
    {
        try {
            $adjustments = $this->haynesPro->getAdjustments($carType, $carTypeGroup);
            
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
    }

    /**
     * Get vehicle information (placeholder)
     */
    public function information($carType, $carTypeGroup, $subject)
    {
        return 1;
    }

    /**
     * Get vehicle lubricants
     */
    public function lubricants($carType, $carTypeGroup)
    {
        try {
            $lubricants = $this->haynesPro->getLubricants($carType, $carTypeGroup);
            
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
    }
}
