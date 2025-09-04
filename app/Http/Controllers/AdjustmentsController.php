<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Services\HaynesPro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdjustmentsController extends Controller
{
    protected $haynesPro;

    public function __construct(HaynesPro $haynesPro)
    {
        $this->haynesPro = $haynesPro;
    }

    /**
     * Get vehicle image for a given vehicle
     */
    private function getVehicleImage($registration, $carTypeId)
    {
        try {
            $vehicleDetails = $this->haynesPro->getVehicleDetails($carTypeId);
            return $vehicleDetails['image'] ?? null;
        } catch (\Exception $e) {
            Log::warning('Failed to fetch vehicle image', [
                'registration' => $registration,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get vehicle by registration
     */
    private function getVehicle($registration)
    {
        return Vehicle::with(['make', 'model'])
            ->where('registration', $registration)
            ->firstOrFail();
    }

    /**
     * Engine general adjustments
     */
    public function engineGeneral($registration)
    {
        $vehicle = $this->getVehicle($registration);
        $vehicleImage = null;
        $engineAdjustments = [];
        $error = null;

        if ($vehicle->car_type_id) {
            try {
                $vehicleImage = $this->getVehicleImage($registration, $vehicle->car_type_id);

                // Get engine adjustments
                $adjustments = $this->haynesPro->getAdjustmentsV7($vehicle->car_type_id, 'ENGINE');

                // Parse the engine general adjustments
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Engine (general)' && isset($adjustment['subAdjustments'])) {
                        foreach ($adjustment['subAdjustments'] as $subAdjustment) {
                            if ($subAdjustment['name'] === 'Engine' && isset($subAdjustment['subAdjustments'])) {
                                $engineAdjustments = $subAdjustment['subAdjustments'];
                                break 2;
                            }
                        }
                    }
                }

            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error('Failed to fetch engine adjustments', [
                    'registration' => $registration,
                    'car_type_id' => $vehicle->car_type_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('adjustments.engine-general', [
            'vehicle' => $vehicle,
            'vehicleImage' => $vehicleImage,
            'engineAdjustments' => $engineAdjustments,
            'error' => $error
        ]);
    }

    /**
     * Engine specifications adjustments
     */
    public function engineSpecifications($registration)
    {
        $vehicle = $this->getVehicle($registration);
        $vehicleImage = null;
        $engineSpecifications = [];
        $error = null;

        if ($vehicle->car_type_id) {
            try {
                $vehicleImage = $this->getVehicleImage($registration, $vehicle->car_type_id);

                // Get engine adjustments
                $adjustments = $this->haynesPro->getAdjustmentsV7($vehicle->car_type_id, 'ENGINE');

                // Parse the engine specifications
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Engine (specifications)' && isset($adjustment['subAdjustments'])) {
                        foreach ($adjustment['subAdjustments'] as $subAdjustment) {
                            if ($subAdjustment['name'] === 'Engine' && isset($subAdjustment['subAdjustments'])) {
                                $engineSpecifications = $subAdjustment['subAdjustments'];
                                break 2;
                            }
                        }
                    }
                }

            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error('Failed to fetch engine specifications', [
                    'registration' => $registration,
                    'car_type_id' => $vehicle->car_type_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('adjustments.engine-specifications', [
            'vehicle' => $vehicle,
            'vehicleImage' => $vehicleImage,
            'engineSpecifications' => $engineSpecifications,
            'error' => $error
        ]);
    }

    /**
     * Emissions adjustments
     */
    public function emissions($registration)
    {
        $vehicle = $this->getVehicle($registration);
        $vehicleImage = null;
        $emissionsData = [];
        $error = null;

        if ($vehicle->car_type_id) {
            try {
                $vehicleImage = $this->getVehicleImage($registration, $vehicle->car_type_id);

                // Get emissions adjustments from ENGINE system group
                $adjustments = $this->haynesPro->getAdjustmentsV7($vehicle->car_type_id, 'ENGINE');

                // Find the "Emissions" adjustment group within ENGINE adjustments
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Emissions' && isset($adjustment['subAdjustments'])) {
                        $emissionsData = $adjustment['subAdjustments'];
                        break;
                    }
                }

            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error('Failed to fetch emissions data', [
                    'registration' => $registration,
                    'car_type_id' => $vehicle->car_type_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('adjustments.emissions', [
            'vehicle' => $vehicle,
            'vehicleImage' => $vehicleImage,
            'emissionsData' => $emissionsData,
            'error' => $error
        ]);
    }

    /**
     * Cooling system adjustments
     */
    public function coolingSystem($registration)
    {
        $vehicle = $this->getVehicle($registration);
        $vehicleImage = null;
        $coolingSystemData = [];
        $error = null;

        if ($vehicle->car_type_id) {
            try {
                $vehicleImage = $this->getVehicleImage($registration, $vehicle->car_type_id);

                // Get cooling system adjustments from ENGINE system group
                $adjustments = $this->haynesPro->getAdjustmentsV7($vehicle->car_type_id, 'ENGINE');

                // Find the "Cooling system" adjustment group within ENGINE adjustments
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Cooling system' && isset($adjustment['subAdjustments'])) {
                        foreach ($adjustment['subAdjustments'] as $subAdjustment) {
                            if ($subAdjustment['name'] === 'Engine' && isset($subAdjustment['subAdjustments'])) {
                                $coolingSystemData = $subAdjustment['subAdjustments'];
                                break 2;
                            }
                        }
                    }
                }

            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error('Failed to fetch cooling system data', [
                    'registration' => $registration,
                    'car_type_id' => $vehicle->car_type_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('adjustments.cooling-system', [
            'vehicle' => $vehicle,
            'vehicleImage' => $vehicleImage,
            'coolingSystemData' => $coolingSystemData,
            'error' => $error
        ]);
    }

    /**
     * Electrical system adjustments
     */
    public function electrical($registration)
    {
        $vehicle = $this->getVehicle($registration);
        $vehicleImage = null;
        $electricalData = [];
        $error = null;

        if ($vehicle->car_type_id) {
            try {
                $vehicleImage = $this->getVehicleImage($registration, $vehicle->car_type_id);

                // Get electrical data from QUICKGUIDES system group
                $adjustments = $this->haynesPro->getAdjustmentsV7($vehicle->car_type_id, 'QUICKGUIDES');

                // Look for electrical system in QUICKGUIDES adjustments
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Electrical' && isset($adjustment['subAdjustments'])) {
                        $electricalData = $adjustment['subAdjustments'];
                        break;
                    }
                }

            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error('Failed to fetch electrical data', [
                    'registration' => $registration,
                    'car_type_id' => $vehicle->car_type_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('adjustments.electrical', [
            'vehicle' => $vehicle,
            'vehicleImage' => $vehicleImage,
            'electricalData' => $electricalData,
            'error' => $error
        ]);
    }

    /**
     * Brakes adjustments
     */
    public function brakes($registration)
    {
        $vehicle = $this->getVehicle($registration);
        $vehicleImage = null;
        $brakesData = [];
        $error = null;

        if ($vehicle->car_type_id) {
            try {
                $vehicleImage = $this->getVehicleImage($registration, $vehicle->car_type_id);

                // Get brakes adjustments from BRAKES system group
                $adjustments = $this->haynesPro->getAdjustmentsV7($vehicle->car_type_id, 'BRAKES');

                // Extract the main "Brakes" section which contains all the brake specifications
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Brakes' && isset($adjustment['subAdjustments'])) {
                        $brakesData = $adjustment['subAdjustments'];
                        break;
                    }
                }

            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error('Failed to fetch brakes data', [
                    'registration' => $registration,
                    'car_type_id' => $vehicle->car_type_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('adjustments.brakes', [
            'vehicle' => $vehicle,
            'vehicleImage' => $vehicleImage,
            'brakesData' => $brakesData,
            'error' => $error
        ]);
    }

    /**
     * Steering, suspension and wheel alignment adjustments
     */
    public function steering($registration)
    {
        $vehicle = $this->getVehicle($registration);
        $vehicleImage = null;
        $steeringData = [];
        $error = null;

        if ($vehicle->car_type_id) {
            try {
                $vehicleImage = $this->getVehicleImage($registration, $vehicle->car_type_id);

                // Get all steering/suspension adjustments from STEERING system group
                $steeringData = $this->haynesPro->getAdjustmentsV7($vehicle->car_type_id, 'STEERING');

            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error('Failed to fetch steering data', [
                    'registration' => $registration,
                    'car_type_id' => $vehicle->car_type_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('adjustments.steering', [
            'vehicle' => $vehicle,
            'vehicleImage' => $vehicleImage,
            'steeringData' => $steeringData,
            'error' => $error
        ]);
    }

    /**
     * Wheels and tyres adjustments
     */
    public function wheelsTyres($registration)
    {
        $vehicle = $this->getVehicle($registration);
        $vehicleImage = null;
        $wheelsData = [];
        $error = null;

        if ($vehicle->car_type_id) {
            try {
                $vehicleImage = $this->getVehicleImage($registration, $vehicle->car_type_id);

                // Search for wheels/tyres specific data across multiple system groups
                $searchGroups = ['WHEELS', 'EXTERIOR'];

                foreach ($searchGroups as $groupName) {
                    try {
                        $adjustments = $this->haynesPro->getAdjustmentsV7($vehicle->car_type_id, $groupName);

                        foreach ($adjustments as $section) {
                            // Look for specific wheel/tyre keywords but exclude general suspension terms
                            $isWheelsRelated = false;
                            $name = strtolower($section['name']);

                            // Specific wheel/tyre keywords
                            if (stripos($name, 'wheel') !== false ||
                                stripos($name, 'tyre') !== false ||
                                stripos($name, 'tire') !== false ||
                                stripos($name, 'rim') !== false) {

                                // Exclude suspension-related terms that might contain "wheel"
                                if (stripos($name, 'wheelbase') === false &&
                                    stripos($name, 'alignment') === false &&
                                    stripos($name, 'suspension') === false &&
                                    stripos($name, 'castor') === false &&
                                    stripos($name, 'camber') === false &&
                                    stripos($name, 'toe') === false) {
                                    $isWheelsRelated = true;
                                }
                            }

                            // Also check subsection names with same logic
                            if (!$isWheelsRelated && isset($section['subAdjustments'])) {
                                foreach ($section['subAdjustments'] as $subsection) {
                                    $subName = strtolower($subsection['name']);
                                    if ((stripos($subName, 'wheel') !== false ||
                                         stripos($subName, 'tyre') !== false ||
                                         stripos($subName, 'tire') !== false ||
                                         stripos($subName, 'rim') !== false) &&
                                        stripos($subName, 'wheelbase') === false &&
                                        stripos($subName, 'alignment') === false &&
                                        stripos($subName, 'suspension') === false &&
                                        stripos($subName, 'castor') === false &&
                                        stripos($subName, 'camber') === false &&
                                        stripos($subName, 'toe') === false) {
                                        $isWheelsRelated = true;
                                        break;
                                    }
                                }
                            }

                            if ($isWheelsRelated) {
                                $wheelsData[] = $section;
                            }
                        }

                    } catch (\Exception $e) {
                        Log::info("Failed to get wheels data from {$groupName} group", ['error' => $e->getMessage()]);
                    }
                }

                // Log what we found for debugging
                Log::info('Wheels/tyres data search results', [
                    'registration' => $registration,
                    'sections_found' => count($wheelsData),
                    'section_names' => array_map(function($section) { return $section['name']; }, $wheelsData)
                ]);

            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error('Failed to fetch wheels/tyres data', [
                    'registration' => $registration,
                    'car_type_id' => $vehicle->car_type_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('adjustments.wheels-tyres', [
            'vehicle' => $vehicle,
            'vehicleImage' => $vehicleImage,
            'wheelsData' => $wheelsData,
            'error' => $error
        ]);
    }
}
