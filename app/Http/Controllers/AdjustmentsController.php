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
                $adjustments = $this->haynesPro->getAdjustmentsBySystemGroup($vehicle->car_type_id, 'ENGINE');

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
                $adjustments = $this->haynesPro->getAdjustmentsBySystemGroup($vehicle->car_type_id, 'ENGINE');

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

                // Get all adjustments from cache (this is much more efficient than the old API calls)
                $adjustments = $this->haynesPro->getAllAdjustmentsWithCache($vehicle->car_type_id);

                // Find the "Emissions" adjustment group and process its structure
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Emissions' && isset($adjustment['subAdjustments'])) {
                        // Parse the nested emissions structure
                        foreach ($adjustment['subAdjustments'] as $section) {
                            if (isset($section['subAdjustments'])) {
                                $emissionsData[] = [
                                    'section_name' => $section['name'],
                                    'visible' => $section['visible'] ?? true,
                                    'items' => $section['subAdjustments']
                                ];
                            }
                        }
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

                // Get all adjustments from cache (this is much more efficient than the old API calls)
                $adjustments = $this->haynesPro->getAllAdjustmentsWithCache($vehicle->car_type_id);

                // Find the "Cooling system" adjustment group and extract Engine section
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Cooling system' && isset($adjustment['subAdjustments'])) {
                        foreach ($adjustment['subAdjustments'] as $section) {
                            if ($section['name'] === 'Engine' && isset($section['subAdjustments'])) {
                                // Extract the items directly for the view (view expects array of items)
                                $coolingSystemData = $section['subAdjustments'];
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

                // Get all adjustments from cache (this is much more efficient than the old API calls)
                $adjustments = $this->haynesPro->getAllAdjustmentsWithCache($vehicle->car_type_id);

                // Find the "Electrical" adjustment group and extract Electrical system section
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Electrical' && isset($adjustment['subAdjustments'])) {
                        foreach ($adjustment['subAdjustments'] as $section) {
                            if ($section['name'] === 'Electrical system' && isset($section['subAdjustments'])) {
                                // Process the electrical data to flatten nested items for display
                                $electricalData = $this->processElectricalData($section['subAdjustments']);
                                break 2;
                            }
                        }
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
     * Process electrical data to handle nested battery specifications and locations
     */
    private function processElectricalData($items)
    {
        $processedData = [];
        
        foreach ($items as $item) {
            // Add the main item
            $processedData[] = $item;
            
            // If the item has sub-adjustments (like battery details), add them as separate items
            if (isset($item['subAdjustments']) && !empty($item['subAdjustments'])) {
                foreach ($item['subAdjustments'] as $subItem) {
                    // Indent sub-items for visual hierarchy
                    $subItem['is_sub_item'] = true;
                    $processedData[] = $subItem;
                }
            }
        }
        
        return $processedData;
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

                // Get all adjustments from cache (this is much more efficient than the old API calls)
                $adjustments = $this->haynesPro->getAllAdjustmentsWithCache($vehicle->car_type_id);

                // Find the "Brakes" adjustment group and process its structure
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Brakes' && isset($adjustment['subAdjustments'])) {
                        // Process the brakes data to create sections with flattened items
                        $brakesData = $this->processBrakesData($adjustment['subAdjustments']);
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
     * Process brakes data to handle complex nested structures and create sections
     */
    private function processBrakesData($sections)
    {
        $processedData = [];
        
        foreach ($sections as $section) {
            $processedSection = [
                'section_name' => $section['name'],
                'items' => []
            ];
            
            if (isset($section['subAdjustments']) && !empty($section['subAdjustments'])) {
                foreach ($section['subAdjustments'] as $item) {
                    // Add the main item
                    $processedSection['items'][] = $item;
                    
                    // If this item has sub-adjustments (like rear disc brakes), add them as separate items
                    if (isset($item['subAdjustments']) && !empty($item['subAdjustments'])) {
                        foreach ($item['subAdjustments'] as $subItem) {
                            // Mark as sub-item and add parent context
                            $subItem['is_sub_item'] = true;
                            $subItem['parent_remark'] = $item['remark'] ?? null;
                            $processedSection['items'][] = $subItem;
                        }
                    }
                }
            }
            
            $processedData[] = $processedSection;
        }
        
        return $processedData;
    }

    /**
     * Capacities adjustments
     */
    public function capacities($registration)
    {
        $vehicle = $this->getVehicle($registration);
        $vehicleImage = null;
        $capacitiesData = [];
        $error = null;

        if ($vehicle->car_type_id) {
            try {
                $vehicleImage = $this->getVehicleImage($registration, $vehicle->car_type_id);

                // Get all adjustments from cache (this is much more efficient than the old API calls)
                $adjustments = $this->haynesPro->getAllAdjustmentsWithCache($vehicle->car_type_id);

                // Find the "Capacities" adjustment group and process its structure
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Capacities' && isset($adjustment['subAdjustments'])) {
                        // Process the capacities data to create sections with flattened items
                        $capacitiesData = $this->processCapacitiesData($adjustment['subAdjustments']);
                        break;
                    }
                }

            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error('Failed to fetch capacities data', [
                    'registration' => $registration,
                    'car_type_id' => $vehicle->car_type_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('adjustments.capacities', [
            'vehicle' => $vehicle,
            'vehicleImage' => $vehicleImage,
            'capacitiesData' => $capacitiesData,
            'error' => $error
        ]);
    }

    /**
     * Process capacities data to handle complex nested structures with images
     */
    private function processCapacitiesData($sections)
    {
        $processedData = [];
        
        foreach ($sections as $section) {
            $processedSection = [
                'section_name' => $section['name'],
                'items' => []
            ];
            
            if (isset($section['subAdjustments']) && !empty($section['subAdjustments'])) {
                foreach ($section['subAdjustments'] as $item) {
                    // Add the main item
                    $processedSection['items'][] = $item;
                    
                    // If this item has sub-adjustments (like transmission details), add them as separate items
                    if (isset($item['subAdjustments']) && !empty($item['subAdjustments'])) {
                        foreach ($item['subAdjustments'] as $subItem) {
                            // Mark as sub-item and add parent context
                            $subItem['is_sub_item'] = true;
                            $subItem['parent_name'] = $item['name'] ?? null;
                            $processedSection['items'][] = $subItem;
                        }
                    }
                }
            }
            
            $processedData[] = $processedSection;
        }
        
        return $processedData;
    }

    /**
     * Torque settings adjustments
     */
    public function torqueSettings($registration)
    {
        $vehicle = $this->getVehicle($registration);
        $vehicleImage = null;
        $torqueData = [];
        $error = null;

        if ($vehicle->car_type_id) {
            try {
                $vehicleImage = $this->getVehicleImage($registration, $vehicle->car_type_id);

                // Get all adjustments from cache (this is much more efficient than the old API calls)
                $adjustments = $this->haynesPro->getAllAdjustmentsWithCache($vehicle->car_type_id);

                // Find the "Torque settings" adjustment group and process its structure
                foreach ($adjustments as $adjustment) {
                    if ($adjustment['name'] === 'Torque settings' && isset($adjustment['subAdjustments'])) {
                        // Process the torque data to create sections with flattened items
                        $torqueData = $this->processTorqueData($adjustment['subAdjustments']);
                        break;
                    }
                }

            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error('Failed to fetch torque settings data', [
                    'registration' => $registration,
                    'car_type_id' => $vehicle->car_type_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('adjustments.torque-settings', [
            'vehicle' => $vehicle,
            'vehicleImage' => $vehicleImage,
            'torqueData' => $torqueData,
            'error' => $error
        ]);
    }

    /**
     * Process torque data to handle complex nested structures
     */
    private function processTorqueData($sections)
    {
        $processedData = [];
        
        foreach ($sections as $section) {
            $processedSection = [
                'section_name' => $section['name'],
                'items' => []
            ];
            
            if (isset($section['subAdjustments']) && !empty($section['subAdjustments'])) {
                foreach ($section['subAdjustments'] as $item) {
                    // Add the main item
                    $processedSection['items'][] = $item;
                    
                    // If this item has sub-adjustments, add them as separate items
                    if (isset($item['subAdjustments']) && !empty($item['subAdjustments'])) {
                        foreach ($item['subAdjustments'] as $subItem) {
                            // Mark as sub-item and add parent context
                            $subItem['is_sub_item'] = true;
                            $subItem['parent_name'] = $item['name'] ?? null;
                            $processedSection['items'][] = $subItem;
                        }
                    }
                }
            }
            
            $processedData[] = $processedSection;
        }
        
        return $processedData;
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
                $steeringData = $this->haynesPro->getAdjustmentsBySystemGroup($vehicle->car_type_id, 'STEERING');

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

                // Get all steering/suspension adjustments from STEERING system group
                $wheelsData = $this->haynesPro->getAdjustmentsBySystemGroup($vehicle->car_type_id, 'STEERING');

            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error('Failed to fetch steering data', [
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
