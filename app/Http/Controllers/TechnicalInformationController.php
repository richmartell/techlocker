<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Services\HaynesPro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class TechnicalInformationController extends Controller
{
    protected $haynespro;

    public function __construct(HaynesPro $haynespro)
    {
        $this->haynespro = $haynespro;
    }

    /**
     * Show the technical information overview for a vehicle
     */
    public function index(string $registration)
    {
        try {
            $vehicle = Vehicle::with(['make', 'model'])
                ->where('registration', $registration)
                ->firstOrFail();

            // Get the carTypeId from vehicle identification (try VIN first, fallback to tecdoc_ktype)
            $carTypeId = null;
            $identificationData = [];
            
            // Try VIN-based identification first
            if ($vehicle->combined_vin && $vehicle->make && $vehicle->model && $vehicle->year_of_manufacture) {
                try {
                    $identificationData = $this->haynespro->findCarTypesByDetails(
                        $vehicle->make->name,
                        $vehicle->model->name,
                        $vehicle->year_of_manufacture,
                        $vehicle->fuel_type ?? '',
                        $vehicle->engine_capacity ?? '',
                        $vehicle->combined_vin
                    );
                    // Use the first result's ID as carTypeId
                    if (!empty($identificationData) && isset($identificationData[0]['id'])) {
                        $carTypeId = $identificationData[0]['id'];
                    }
                } catch (Exception $e) {
                    Log::warning('VIN-based identification failed, trying tecdoc_ktype fallback', [
                        'make' => $vehicle->make->name ?? 'N/A',
                        'model' => $vehicle->model->name ?? 'N/A',
                        'year' => $vehicle->year_of_manufacture,
                        'vin' => $vehicle->combined_vin,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Fallback to tecdoc_ktype if VIN approach failed
            if (!$carTypeId && $vehicle->tecdoc_ktype) {
                try {
                    $identificationData = $this->haynespro->getIdentificationByTecdocKtype($vehicle->tecdoc_ktype);
                    // Use the first result's ID as carTypeId
                    if (!empty($identificationData) && isset($identificationData[0]['id'])) {
                        $carTypeId = $identificationData[0]['id'];
                    }
                } catch (Exception $e) {
                    Log::error('Failed to get identification for TecdocKtype', [
                        'tecdoc_ktype' => $vehicle->tecdoc_ktype,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Get available subjects from identification data
            $availableSubjects = [];
            $subjectsByGroup = [];
            
            if (!empty($identificationData)) {
                $availableSubjects = $identificationData[0]['subjects'] ?? [];
                $subjectsByGroup = $identificationData[0]['subjectsByGroup']['mapItems'] ?? [];
            }

            return view('technical-information.index', [
                'vehicle' => $vehicle,
                'carTypeId' => $carTypeId,
                'identificationData' => $identificationData,
                'availableSubjects' => $availableSubjects,
                'subjectsByGroup' => $subjectsByGroup
            ]);
        } catch (Exception $e) {
            Log::error('Technical information overview error', [
                'registration' => $registration,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to load technical information: ' . $e->getMessage());
        }
    }

    /**
     * Get maintenance systems for a vehicle
     */
    public function maintenanceSystems(string $registration)
    {
        try {
            $vehicle = Vehicle::where('registration', $registration)->firstOrFail();
            $carTypeId = $this->getCarTypeId($vehicle);

            if (!$carTypeId) {
                return back()->with('error', 'Vehicle identification not available for maintenance systems');
            }

            $systems = $this->haynespro->getMaintenanceSystems($carTypeId);
            
            return view('technical-information.maintenance-systems', [
                'vehicle' => $vehicle,
                'systems' => $systems,
                'carTypeId' => $carTypeId
            ]);
        } catch (Exception $e) {
            Log::error('Maintenance systems error', [
                'registration' => $registration,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to load maintenance systems: ' . $e->getMessage());
        }
    }

    /**
     * Get maintenance tasks for a vehicle
     */
    public function maintenanceTasks(string $registration, Request $request)
    {
        try {
            $vehicle = Vehicle::where('registration', $registration)->firstOrFail();
            $carTypeId = $this->getCarTypeId($vehicle);

            if (!$carTypeId) {
                return back()->with('error', 'Vehicle identification not available for maintenance tasks');
            }

            $systemId = $request->get('systemId');
            $periodId = $request->get('periodId');

            $tasks = $this->haynespro->getMaintenanceTasks($carTypeId, $systemId, $periodId);
            
            return view('technical-information.maintenance-tasks', [
                'vehicle' => $vehicle,
                'tasks' => $tasks,
                'carTypeId' => $carTypeId,
                'systemId' => $systemId,
                'periodId' => $periodId
            ]);
        } catch (Exception $e) {
            Log::error('Maintenance tasks error', [
                'registration' => $registration,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to load maintenance tasks: ' . $e->getMessage());
        }
    }

    /**
     * Get adjustments for a vehicle by system group
     */
    public function adjustments(string $registration, string $systemGroup)
    {
        try {
            $vehicle = Vehicle::where('registration', $registration)->firstOrFail();
            $carTypeId = $this->getCarTypeId($vehicle);

            if (!$carTypeId) {
                return back()->with('error', 'Vehicle identification not available for adjustments');
            }

            $adjustments = $this->haynespro->getAdjustmentsV7($carTypeId, $systemGroup);
            
            return view('technical-information.adjustments', [
                'vehicle' => $vehicle,
                'adjustments' => $adjustments,
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);
        } catch (Exception $e) {
            Log::error('Adjustments error', [
                'registration' => $registration,
                'systemGroup' => $systemGroup,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to load adjustments: ' . $e->getMessage());
        }
    }

    /**
     * Get lubricants for a vehicle by system group
     */
    public function lubricants(string $registration, string $systemGroup)
    {
        try {
            $vehicle = Vehicle::where('registration', $registration)->firstOrFail();
            $carTypeId = $this->getCarTypeId($vehicle);

            if (!$carTypeId) {
                return back()->with('error', 'Vehicle identification not available for lubricants');
            }

            $lubricants = $this->haynespro->getLubricantsV5($carTypeId, $systemGroup);
            
            return view('technical-information.lubricants', [
                'vehicle' => $vehicle,
                'lubricants' => $lubricants,
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);
        } catch (Exception $e) {
            Log::error('Lubricants error', [
                'registration' => $registration,
                'systemGroup' => $systemGroup,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to load lubricants: ' . $e->getMessage());
        }
    }

    /**
     * Get technical drawings for a vehicle by system group
     */
    public function technicalDrawings(string $registration, string $systemGroup)
    {
        try {
            $vehicle = Vehicle::where('registration', $registration)->firstOrFail();
            $carTypeId = $this->getCarTypeId($vehicle);

            if (!$carTypeId) {
                return back()->with('error', 'Vehicle identification not available for technical drawings');
            }

            $drawings = $this->haynespro->getTechnicalDrawings($carTypeId, $systemGroup);
            
            return view('technical-information.technical-drawings', [
                'vehicle' => $vehicle,
                'drawings' => $drawings,
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);
        } catch (Exception $e) {
            Log::error('Technical drawings error', [
                'registration' => $registration,
                'systemGroup' => $systemGroup,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to load technical drawings: ' . $e->getMessage());
        }
    }

    /**
     * Get wiring diagrams for a vehicle
     */
    public function wiringDiagrams(string $registration)
    {
        try {
            $vehicle = Vehicle::where('registration', $registration)->firstOrFail();
            $carTypeId = $this->getCarTypeId($vehicle);

            if (!$carTypeId) {
                return back()->with('error', 'Vehicle identification not available for wiring diagrams');
            }

            $diagrams = $this->haynespro->getWiringDiagrams($carTypeId);
            
            return view('technical-information.wiring-diagrams', [
                'vehicle' => $vehicle,
                'diagrams' => $diagrams,
                'carTypeId' => $carTypeId
            ]);
        } catch (Exception $e) {
            Log::error('Wiring diagrams error', [
                'registration' => $registration,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to load wiring diagrams: ' . $e->getMessage());
        }
    }

    /**
     * Get fuse locations for a vehicle
     */
    public function fuseLocations(string $registration)
    {
        try {
            $vehicle = Vehicle::where('registration', $registration)->firstOrFail();
            $carTypeId = $this->getCarTypeId($vehicle);

            if (!$carTypeId) {
                return back()->with('error', 'Vehicle identification not available for fuse locations');
            }

            $fuseLocations = $this->haynespro->getFuseLocations($carTypeId);
            
            return view('technical-information.fuse-locations', [
                'vehicle' => $vehicle,
                'fuseLocations' => $fuseLocations,
                'carTypeId' => $carTypeId
            ]);
        } catch (Exception $e) {
            Log::error('Fuse locations error', [
                'registration' => $registration,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to load fuse locations: ' . $e->getMessage());
        }
    }

    /**
     * Get repair time information for a vehicle
     */
    public function repairTimes(string $registration, ?string $systemGroup = null)
    {
        try {
            $vehicle = Vehicle::where('registration', $registration)->firstOrFail();
            $carTypeId = $this->getCarTypeId($vehicle);

            if (!$carTypeId) {
                return back()->with('error', 'Vehicle identification not available for repair times');
            }

            $repairTimes = $this->haynespro->getRepairTimeInfos($carTypeId, $systemGroup);
            
            return view('technical-information.repair-times', [
                'vehicle' => $vehicle,
                'repairTimes' => $repairTimes,
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);
        } catch (Exception $e) {
            Log::error('Repair times error', [
                'registration' => $registration,
                'systemGroup' => $systemGroup,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to load repair times: ' . $e->getMessage());
        }
    }

    /**
     * Show maintenance schedules (service intervals) for a vehicle
     */
    public function schedules(string $registration, Request $request)
    {
        try {
            $vehicle = Vehicle::with(['make', 'model'])
                ->where('registration', $registration)
                ->firstOrFail();
            
            $carTypeId = $this->getCarTypeId($vehicle);

            if (!$carTypeId) {
                return back()->with('error', 'Vehicle identification not available for maintenance schedules');
            }

            // Get maintenance systems which contain the service intervals
            $maintenanceSystems = $this->haynespro->getMaintenanceSystems($carTypeId);
            
            // Get the selected system ID from query parameter
            $selectedSystemId = $request->query('systemId');

            // Extract service intervals from maintenance periods
            $maintenanceIntervals = [];
            foreach ($maintenanceSystems as $system) {
                $systemId = $system['id'] ?? 0;
                $systemName = $system['name'] ?? 'Maintenance System';
                
                // Skip this system if a specific system is selected and this isn't it
                if ($selectedSystemId && $selectedSystemId != $systemId) {
                    continue;
                }
                
                if (isset($system['maintenancePeriods']) && !empty($system['maintenancePeriods'])) {
                    foreach ($system['maintenancePeriods'] as $period) {
                        $periodId = $period['id'] ?? 0;
                        $periodName = $period['name'] ?? '';
                        
                        // Parse mileage and months from period name (e.g., "34,000 km/24 months")
                        $intervalMileage = 0;
                        $intervalMonths = 0;
                        $isTraditionalInterval = false;
                        
                        // Extract numbers from period name for traditional intervals
                        if (preg_match('/([0-9,]+)\s*(km|miles).*?(\d+)\s*months?/i', $periodName, $matches)) {
                            $rawMileage = (int) str_replace(',', '', $matches[1]);
                            $unit = strtolower($matches[2]);
                            $intervalMonths = (int) $matches[3];
                            $isTraditionalInterval = true;
                            
                            // Convert kilometers to miles if needed
                            if ($unit === 'km') {
                                $convertedMiles = $rawMileage * 0.621371;
                                // Round down to nearest 1000 miles
                                $intervalMileage = (int) (floor($convertedMiles / 1000) * 1000);
                            } else {
                                // Round down to nearest 1000 miles even if already in miles
                                $intervalMileage = (int) (floor($rawMileage / 1000) * 1000);
                            }
                        }
                        
                        // Include traditional intervals with mileage/months OR condition-based procedures
                        $shouldInclude = ($isTraditionalInterval && $intervalMileage > 0 && $intervalMonths > 0) || 
                                       (!$isTraditionalInterval && !empty($periodName));
                        
                        if ($shouldInclude) {
                            // Create appropriate description
                            if ($isTraditionalInterval) {
                                $description = number_format($intervalMileage) . ' miles / ' . $intervalMonths . ' months';
                            } else {
                                // For condition-based procedures, use the period name as description
                                $description = $periodName;
                            }
                            
                            $maintenanceIntervals[] = [
                                'systemId' => $systemId,
                                'systemName' => $systemName,
                                'periodId' => $periodId,
                                'intervalMileage' => $intervalMileage,
                                'intervalMonths' => $intervalMonths,
                                'description' => $description,
                                'originalDescription' => $periodName,
                                'isTraditionalInterval' => $isTraditionalInterval,
                                'tasks' => [] // Will be populated when viewing details
                            ];
                        }
                    }
                }
            }

            return view('maintenance.schedules', [
                'vehicle' => $vehicle,
                'maintenanceIntervals' => $maintenanceIntervals,
                'maintenanceSystems' => $maintenanceSystems,
                'selectedSystemId' => $selectedSystemId,
                'carTypeId' => $carTypeId
            ]);
        } catch (Exception $e) {
            Log::error('Maintenance schedules error', [
                'registration' => $registration,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to load maintenance schedules: ' . $e->getMessage());
        }
    }

    /**
     * Show details for a specific maintenance schedule (service interval)
     */
    public function scheduleDetails(string $registration, int $systemId, int $periodId)
    {
        try {
            $vehicle = Vehicle::with(['make', 'model'])
                ->where('registration', $registration)
                ->firstOrFail();
            
            $carTypeId = $this->getCarTypeId($vehicle);

            if (!$carTypeId) {
                return back()->with('error', 'Vehicle identification not available for schedule details');
            }

            // Get the specific maintenance tasks for this system and period using V9 API
            $maintenanceTasks = [];
            try {
                // Use getMaintenanceTasksV9 which provides more comprehensive task data
                $rawTasks = $this->haynespro->getMaintenanceTasksV9($carTypeId, $systemId, $periodId);
                
                // Flatten the nested structure - V9 API returns tasks with subTasks
                $maintenanceTasks = [];
                foreach ($rawTasks as $mainTask) {
                    $mainTaskName = $mainTask['name'] ?? 'Maintenance Task';
                    
                    if (isset($mainTask['subTasks']) && is_array($mainTask['subTasks'])) {
                        // Process each subtask
                        foreach ($mainTask['subTasks'] as $subTask) {
                            // Helper function to safely convert to string
                            $safeString = function($value) {
                                if (is_array($value)) {
                                    // Handle nested arrays by converting each element to string first
                                    $flatValues = array_map(function($item) {
                                        return is_array($item) ? json_encode($item) : (string)$item;
                                    }, $value);
                                    return !empty(array_filter($flatValues)) ? implode(', ', array_filter($flatValues)) : '';
                                }
                                return (string)($value ?? '');
                            };
                            
                            $formattedTask = [
                                'name' => $safeString($subTask['name'] ?? 'Task'),
                                'description' => $safeString($subTask['remark'] ?? ''),
                                'category' => $safeString($mainTaskName),
                                'type' => $safeString($mainTaskName),
                                'procedure' => $safeString($subTask['longDescriptions'] ?? ''),
                                'serviceTime' => $safeString($subTask['times'] ?? ''),
                                'time' => $safeString($subTask['times'] ?? ''),
                                'descriptionId' => $subTask['descriptionId'] ?? null,
                                'order' => $subTask['order'] ?? 0,
                                'mandatoryReplacement' => $subTask['mandatoryReplacement'] ?? false,
                                'includeByDefault' => $subTask['includeByDefault'] ?? true,
                                'parts' => $subTask['serviceTaskParts'] ?? [],
                                'smartLinks' => $safeString($subTask['smartLinks'] ?? ''),
                                'generalCriterias' => $subTask['generalCriterias'] ?? []
                            ];
                            $maintenanceTasks[] = $formattedTask;
                        }
                    } else {
                        // If no subtasks, use the main task itself
                        // Helper function to safely convert to string
                        $safeString = function($value) {
                            if (is_array($value)) {
                                // Handle nested arrays by converting each element to string first
                                $flatValues = array_map(function($item) {
                                    return is_array($item) ? json_encode($item) : (string)$item;
                                }, $value);
                                return !empty(array_filter($flatValues)) ? implode(', ', array_filter($flatValues)) : '';
                            }
                            return (string)($value ?? '');
                        };
                        
                        $formattedTask = [
                            'name' => $safeString($mainTaskName),
                            'description' => $safeString($mainTask['remark'] ?? ''),
                            'category' => 'General',
                            'type' => 'General',
                            'procedure' => $safeString($mainTask['longDescriptions'] ?? ''),
                            'serviceTime' => $safeString($mainTask['times'] ?? ''),
                            'time' => $safeString($mainTask['times'] ?? ''),
                            'descriptionId' => $mainTask['descriptionId'] ?? null,
                            'order' => $mainTask['order'] ?? 0,
                            'mandatoryReplacement' => $mainTask['mandatoryReplacement'] ?? false,
                            'includeByDefault' => $mainTask['includeByDefault'] ?? true,
                            'parts' => $mainTask['serviceTaskParts'] ?? [],
                            'smartLinks' => $safeString($mainTask['smartLinks'] ?? ''),
                            'generalCriterias' => $mainTask['generalCriterias'] ?? []
                        ];
                        $maintenanceTasks[] = $formattedTask;
                    }
                }
                
                // Sort tasks by category first, then by order within each category
                usort($maintenanceTasks, function($a, $b) {
                    // First, sort by category (Engine, Transmission, etc.)
                    $categoryComparison = strcasecmp($a['category'] ?? 'ZZZ', $b['category'] ?? 'ZZZ');
                    if ($categoryComparison !== 0) {
                        return $categoryComparison;
                    }
                    // If categories are the same, sort by order within the category
                    return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
                });
                

                
                Log::info('Retrieved and processed maintenance tasks V9', [
                    'carTypeId' => $carTypeId,
                    'systemId' => $systemId,
                    'periodId' => $periodId,
                    'rawTaskCount' => count($rawTasks),
                    'processedTaskCount' => count($maintenanceTasks)
                ]);
            } catch (Exception $e) {
                Log::warning('Failed to get maintenance tasks V9', [
                    'carTypeId' => $carTypeId,
                    'systemId' => $systemId,
                    'periodId' => $periodId,
                    'error' => $e->getMessage()
                ]);
                
                // Fallback to older method if V9 fails
                try {
                    $maintenanceTasks = $this->haynespro->getMaintenanceTasks($carTypeId, $systemId, $periodId);
                    Log::info('Used fallback maintenance tasks method', [
                        'taskCount' => count($maintenanceTasks)
                    ]);
                } catch (Exception $fallbackError) {
                    Log::error('Both maintenance task methods failed', [
                        'v9Error' => $e->getMessage(),
                        'fallbackError' => $fallbackError->getMessage()
                    ]);
                }
            }
            
            // Get maintenance parts for this period
            $maintenanceParts = [];
            if ($periodId > 0) {
                try {
                    $maintenanceParts = $this->haynespro->getMaintenancePartsForPeriod($carTypeId, $periodId);
                } catch (Exception $e) {
                    Log::warning('Failed to get maintenance parts for period', [
                        'carTypeId' => $carTypeId,
                        'periodId' => $periodId,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Get the interval information from maintenance systems
            $intervalInfo = null;
            try {
                $maintenanceSystems = $this->haynespro->getMaintenanceSystems($carTypeId);
                foreach ($maintenanceSystems as $system) {
                    if (($system['id'] ?? 0) == $systemId && isset($system['maintenancePeriods'])) {
                        foreach ($system['maintenancePeriods'] as $period) {
                            if (($period['id'] ?? 0) == $periodId) {
                                $periodName = $period['name'] ?? '';
                                
                                // Parse mileage and months from period name
                                $intervalMileage = 0;
                                $intervalMonths = 0;
                                if (preg_match('/([0-9,]+)\s*(km|miles).*?(\d+)\s*months?/i', $periodName, $matches)) {
                                    $rawMileage = (int) str_replace(',', '', $matches[1]);
                                    $unit = strtolower($matches[2]);
                                    $intervalMonths = (int) $matches[3];
                                    
                                    // Convert kilometers to miles if needed
                                    if ($unit === 'km') {
                                        $convertedMiles = $rawMileage * 0.621371;
                                        // Round down to nearest 1000 miles
                                        $intervalMileage = (int) (floor($convertedMiles / 1000) * 1000);
                                    } else {
                                        // Round down to nearest 1000 miles even if already in miles
                                        $intervalMileage = (int) (floor($rawMileage / 1000) * 1000);
                                    }
                                }
                                
                                $intervalInfo = [
                                    'intervalMileage' => $intervalMileage,
                                    'intervalMonths' => $intervalMonths,
                                    'systemName' => $system['name'] ?? 'Maintenance System',
                                    'description' => $periodName
                                ];
                                break 2;
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                Log::warning('Failed to get interval info', ['error' => $e->getMessage()]);
            }

            return view('maintenance.schedule-details', [
                'vehicle' => $vehicle,
                'maintenanceTasks' => $maintenanceTasks,
                'maintenanceParts' => $maintenanceParts,
                'carTypeId' => $carTypeId,
                'systemId' => $systemId,
                'periodId' => $periodId,
                'intervalInfo' => $intervalInfo
            ]);
        } catch (Exception $e) {
            Log::error('Schedule details error', [
                'registration' => $registration,
                'systemId' => $systemId,
                'periodId' => $periodId,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to load schedule details: ' . $e->getMessage());
        }
    }

    /**
     * Show service indicator reset procedures
     */
    public function serviceIndicatorReset(string $registration)
    {
        try {
            $vehicle = Vehicle::with(['make', 'model'])
                ->where('registration', $registration)
                ->firstOrFail();
            
            $carTypeId = $this->getCarTypeId($vehicle);

            if (!$carTypeId) {
                return back()->with('error', 'Vehicle identification not available for maintenance service reset');
            }

            // Use the new story-based approach
            $serviceResetData = $this->haynespro->getServiceIndicatorResetStory($carTypeId);

            return view('maintenance.service-indicator-reset', [
                'vehicle' => $vehicle,
                'serviceResetData' => $serviceResetData,
                'error' => null
            ]);

        } catch (Exception $e) {
            Log::error('Failed to fetch service indicator reset data', [
                'registration' => $registration,
                'error' => $e->getMessage()
            ]);

            return view('maintenance.service-indicator-reset', [
                'vehicle' => Vehicle::where('registration', $registration)->firstOrFail(),
                'serviceResetData' => null,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Helper method to get carTypeId from vehicle
     */
    private function getCarTypeId(Vehicle $vehicle): ?int
    {
        // Try VIN-based identification first
        if ($vehicle->combined_vin && $vehicle->make && $vehicle->model && $vehicle->year_of_manufacture) {
            try {
                $identificationData = $this->haynespro->findCarTypesByDetails(
                    $vehicle->make->name,
                    $vehicle->model->name,
                    $vehicle->year_of_manufacture,
                    $vehicle->fuel_type ?? '',
                    $vehicle->engine_capacity ?? '',
                    $vehicle->combined_vin
                );
                if (!empty($identificationData) && isset($identificationData[0]['id'])) {
                    return $identificationData[0]['id'];
                }
            } catch (Exception $e) {
                Log::warning('VIN-based identification failed in getCarTypeId, trying tecdoc_ktype fallback', [
                    'make' => $vehicle->make->name ?? 'N/A',
                    'model' => $vehicle->model->name ?? 'N/A',
                    'year' => $vehicle->year_of_manufacture,
                    'vin' => $vehicle->combined_vin,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Fallback to tecdoc_ktype if VIN approach failed
        if ($vehicle->tecdoc_ktype) {
            try {
                $identificationData = $this->haynespro->getIdentificationByTecdocKtype($vehicle->tecdoc_ktype);
                if (!empty($identificationData) && isset($identificationData[0]['id'])) {
                    return $identificationData[0]['id'];
                }
            } catch (Exception $e) {
                Log::error('Failed to get carTypeId from tecdoc_ktype', [
                    'tecdoc_ktype' => $vehicle->tecdoc_ktype,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return null;
    }
} 