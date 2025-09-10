<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Services\HaynesPro;
use Illuminate\Support\Facades\Log;
use Exception;

class HaynesInspectorController extends Controller
{
    protected $haynesProService;

    public function __construct(HaynesPro $haynesProService)
    {
        $this->haynesProService = $haynesProService;
    }

    /**
     * Show the Haynes Inspector dashboard for a vehicle
     */
    public function index($registration)
    {
        $vehicle = Vehicle::with(['make', 'model'])
            ->where('registration', $registration)
            ->firstOrFail();

        // Get available API methods grouped by category
        $apiMethods = $this->getAvailableApiMethods($vehicle);

        return view('haynes-inspector.index', [
            'vehicle' => $vehicle,
            'apiMethods' => $apiMethods
        ]);
    }

    /**
     * Execute a specific API method and return the JSON response
     */
    public function executeMethod(Request $request, $registration, $method)
    {
        $vehicle = Vehicle::where('registration', $registration)->firstOrFail();
        
        try {
            $response = $this->callHaynesProMethod($method, $vehicle, $request->all());
            
            return response()->json([
                'success' => true,
                'method' => $method,
                'data' => $response,
                'timestamp' => now()->toISOString()
            ]);
        } catch (Exception $e) {
            Log::error('Haynes Inspector API call failed', [
                'method' => $method,
                'vehicle' => $registration,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'method' => $method,
                'error' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 500);
        }
    }

    /**
     * Get all available API methods grouped by category
     */
        private function getAvailableApiMethods($vehicle)
    {
        $methods = [];

        // Add technical information methods grouped by subject if we have carTypeId
        if ($vehicle->hasCarTypeIdentification()) {
            $carTypeId = $vehicle->car_type_id;
            
            // ENGINE System Group
            $methods['ENGINE'] = [
                [
                    'method' => 'getAdjustmentsV7',
                    'name' => 'Adjustments & Specifications',
                    'description' => 'Get engine adjustment and specification data',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'ENGINE']
                ],
                [
                    'method' => 'getLubricantsV5',
                    'name' => 'Lubricants & Capacities',
                    'description' => 'Get engine lubricant and capacity information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'ENGINE']
                ],
                [
                    'method' => 'getStoryOverview',
                    'name' => 'Story Overview (Repair Manuals)',
                    'description' => 'Get engine repair manual information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'ENGINE']
                ],
                [
                    'method' => 'getTechnicalDrawings',
                    'name' => 'Technical Drawings (Legacy)',
                    'description' => 'Get engine technical drawings (legacy)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'ENGINE']
                ],
                [
                    'method' => 'getDrawingsV4',
                    'name' => 'Technical Drawings V4',
                    'description' => 'Get engine technical drawings (V4)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'ENGINE']
                ],
                [
                    'method' => 'getManagementSystems',
                    'name' => 'Management Systems',
                    'description' => 'Get engine management system information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'ENGINE']
                ],
                [
                    'method' => 'getRepairTimeInfos',
                    'name' => 'Repair Time Information',
                    'description' => 'Get engine repair time information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'ENGINE']
                ],
                [
                    'method' => 'getTechnicalBulletins',
                    'name' => 'Technical Service Bulletins',
                    'description' => 'Get engine technical service bulletins',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'ENGINE']
                ],
                [
                    'method' => 'getEngineLocation',
                    'name' => 'Engine Location',
                    'description' => 'Get engine location information',
                    'parameters' => ['carTypeId' => $carTypeId]
                ]
            ];

            // TRANSMISSION System Group
            $methods['TRANSMISSION'] = [
                [
                    'method' => 'getAdjustmentsV7',
                    'name' => 'Adjustments & Specifications',
                    'description' => 'Get transmission adjustment and specification data',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'TRANSMISSION']
                ],
                [
                    'method' => 'getLubricantsV5',
                    'name' => 'Lubricants & Capacities',
                    'description' => 'Get transmission lubricant and capacity information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'TRANSMISSION']
                ],
                [
                    'method' => 'getStoryOverview',
                    'name' => 'Story Overview (Repair Manuals)',
                    'description' => 'Get transmission repair manual information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'TRANSMISSION']
                ],
                [
                    'method' => 'getTechnicalDrawings',
                    'name' => 'Technical Drawings (Legacy)',
                    'description' => 'Get transmission technical drawings (legacy)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'TRANSMISSION']
                ],
                [
                    'method' => 'getDrawingsV4',
                    'name' => 'Technical Drawings V4',
                    'description' => 'Get transmission technical drawings (V4)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'TRANSMISSION']
                ],
                [
                    'method' => 'getManagementSystems',
                    'name' => 'Management Systems',
                    'description' => 'Get automatic transmission management systems',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'TRANSMISSION']
                ],
                [
                    'method' => 'getRepairTimeInfos',
                    'name' => 'Repair Time Information',
                    'description' => 'Get transmission repair time information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'TRANSMISSION']
                ],
                [
                    'method' => 'getTechnicalBulletins',
                    'name' => 'Technical Service Bulletins',
                    'description' => 'Get transmission technical service bulletins',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'TRANSMISSION']
                ]
            ];

            // STEERING System Group
            $methods['STEERING'] = [
                [
                    'method' => 'getAdjustmentsV7',
                    'name' => 'Adjustments & Specifications',
                    'description' => 'Get steering adjustment and specification data',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'STEERING']
                ],
                [
                    'method' => 'getLubricantsV5',
                    'name' => 'Lubricants & Capacities',
                    'description' => 'Get steering lubricant and capacity information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'STEERING']
                ],
                [
                    'method' => 'getStoryOverview',
                    'name' => 'Story Overview (Repair Manuals)',
                    'description' => 'Get steering repair manual information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'STEERING']
                ],
                [
                    'method' => 'getTechnicalDrawings',
                    'name' => 'Technical Drawings (Legacy)',
                    'description' => 'Get steering technical drawings (legacy)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'STEERING']
                ],
                [
                    'method' => 'getDrawingsV4',
                    'name' => 'Technical Drawings V4',
                    'description' => 'Get steering technical drawings (V4)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'STEERING']
                ],
                [
                    'method' => 'getRepairTimeInfos',
                    'name' => 'Repair Time Information',
                    'description' => 'Get steering repair time information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'STEERING']
                ],
                [
                    'method' => 'getTechnicalBulletins',
                    'name' => 'Technical Service Bulletins',
                    'description' => 'Get steering technical service bulletins',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'STEERING']
                ]
            ];

            // BRAKES System Group
            $methods['BRAKES'] = [
                [
                    'method' => 'getAdjustmentsV7',
                    'name' => 'Adjustments & Specifications',
                    'description' => 'Get brake adjustment and specification data',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'BRAKES']
                ],
                [
                    'method' => 'getLubricantsV5',
                    'name' => 'Lubricants & Capacities',
                    'description' => 'Get brake lubricant and capacity information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'BRAKES']
                ],
                [
                    'method' => 'getStoryOverview',
                    'name' => 'Story Overview (Repair Manuals)',
                    'description' => 'Get brake repair manual information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'BRAKES']
                ],
                [
                    'method' => 'getTechnicalDrawings',
                    'name' => 'Technical Drawings (Legacy)',
                    'description' => 'Get brake technical drawings (legacy)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'BRAKES']
                ],
                [
                    'method' => 'getDrawingsV4',
                    'name' => 'Technical Drawings V4',
                    'description' => 'Get brake technical drawings (V4)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'BRAKES']
                ],
                [
                    'method' => 'getManagementSystems',
                    'name' => 'Management Systems (ABS)',
                    'description' => 'Get ABS/brake management systems',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'BRAKES']
                ],
                [
                    'method' => 'getRepairTimeInfos',
                    'name' => 'Repair Time Information',
                    'description' => 'Get brake repair time information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'BRAKES']
                ],
                [
                    'method' => 'getTechnicalBulletins',
                    'name' => 'Technical Service Bulletins',
                    'description' => 'Get brake technical service bulletins',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'BRAKES']
                ]
            ];

            // EXTERIOR System Group
            $methods['EXTERIOR'] = [
                [
                    'method' => 'getAdjustmentsV7',
                    'name' => 'Adjustments & Specifications',
                    'description' => 'Get exterior adjustment and specification data',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'EXTERIOR']
                ],
                [
                    'method' => 'getLubricantsV5',
                    'name' => 'Lubricants & Capacities',
                    'description' => 'Get exterior lubricant and capacity information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'EXTERIOR']
                ],
                [
                    'method' => 'getStoryOverview',
                    'name' => 'Story Overview (Repair Manuals)',
                    'description' => 'Get exterior repair manual information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'EXTERIOR']
                ],
                [
                    'method' => 'getTechnicalDrawings',
                    'name' => 'Technical Drawings (Legacy)',
                    'description' => 'Get exterior technical drawings (legacy)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'EXTERIOR']
                ],
                [
                    'method' => 'getDrawingsV4',
                    'name' => 'Technical Drawings V4',
                    'description' => 'Get exterior technical drawings (V4)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'EXTERIOR']
                ],
                [
                    'method' => 'getManagementSystems',
                    'name' => 'Management Systems',
                    'description' => 'Get exterior management systems',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'EXTERIOR']
                ],
                [
                    'method' => 'getRepairTimeInfos',
                    'name' => 'Repair Time Information',
                    'description' => 'Get exterior repair time information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'EXTERIOR']
                ],
                [
                    'method' => 'getWiringDiagrams',
                    'name' => 'Wiring Diagrams (A/C)',
                    'description' => 'Get exterior/A/C wiring diagrams',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'EXTERIOR']
                ],
                [
                    'method' => 'getTechnicalBulletins',
                    'name' => 'Technical Service Bulletins',
                    'description' => 'Get exterior technical service bulletins',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'EXTERIOR']
                ]
            ];

            // ELECTRONICS System Group
            $methods['ELECTRONICS'] = [
                [
                    'method' => 'getManagementSystems',
                    'name' => 'Management Systems',
                    'description' => 'Get electronic management systems',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'ELECTRONICS']
                ],
                [
                    'method' => 'getWiringDiagrams',
                    'name' => 'Wiring Diagrams',
                    'description' => 'Get electronic wiring diagrams',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getFuseLocations',
                    'name' => 'Fuse Locations',
                    'description' => 'Get fuse box locations',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getTechnicalBulletins',
                    'name' => 'Technical Service Bulletins',
                    'description' => 'Get electronics technical service bulletins',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'ELECTRONICS']
                ],
                [
                    'method' => 'getWarningLights',
                    'name' => 'Warning Lights',
                    'description' => 'Get warning light information',
                    'parameters' => ['carTypeId' => $carTypeId]
                ]
            ];

            // QUICKGUIDES System Group
            $methods['QUICKGUIDES'] = [
                [
                    'method' => 'getAdjustmentsV7',
                    'name' => 'Adjustments & Specifications',
                    'description' => 'Get quick guide adjustments',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'QUICKGUIDES']
                ],
                [
                    'method' => 'getLubricantsV5',
                    'name' => 'Lubricants & Capacities',
                    'description' => 'Get quick guide lubricants',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'QUICKGUIDES']
                ],
                [
                    'method' => 'getStoryOverview',
                    'name' => 'Story Overview (Repair Manuals)',
                    'description' => 'Get quick guide stories',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'QUICKGUIDES']
                ],
                [
                    'method' => 'getTechnicalDrawings',
                    'name' => 'Technical Drawings (Legacy)',
                    'description' => 'Get quick guide technical drawings (legacy)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'QUICKGUIDES']
                ],
                [
                    'method' => 'getDrawingsV4',
                    'name' => 'Technical Drawings V4',
                    'description' => 'Get quick guide technical drawings (V4)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'QUICKGUIDES']
                ],
                [
                    'method' => 'getTechnicalBulletins',
                    'name' => 'Technical Service Bulletins',
                    'description' => 'Get quick guide technical service bulletins',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'QUICKGUIDES']
                ]
            ];

            // DIAGNOSTICS System Group (additional useful methods)
            $methods['DIAGNOSTICS'] = [
                [
                    'method' => 'getDtcInfos',
                    'name' => 'DTC Information',
                    'description' => 'Get diagnostic trouble code information',
                    'parameters' => ['carTypeId' => $carTypeId, 'dtc' => 'P0300']
                ],
                [
                    'method' => 'getPids',
                    'name' => 'PIDs (Parameter IDs)',
                    'description' => 'Get parameter ID information',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getTestProcedures',
                    'name' => 'Test Procedures',
                    'description' => 'Get test procedure information',
                    'parameters' => ['carTypeId' => $carTypeId]
                ]
            ];

            // MAINTENANCE System Group
            $methods['MAINTENANCE'] = [
                [
                    'method' => 'getMaintenanceSystems',
                    'name' => 'Maintenance Systems (Legacy)',
                    'description' => 'Get maintenance systems for the vehicle (legacy version)',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getMaintenanceSystemsV7',
                    'name' => 'Maintenance Systems V7',
                    'description' => 'Get maintenance systems for the vehicle (V7)',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getMaintenanceTasks',
                    'name' => 'Maintenance Tasks (Legacy)',
                    'description' => 'Get maintenance tasks for the vehicle (legacy version)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemId' => 1]
                ],
                [
                    'method' => 'getMaintenanceTasksV9',
                    'name' => 'Maintenance Tasks V9',
                    'description' => 'Get maintenance tasks for the vehicle (V9)',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemId' => 1, 'periodId' => 'optional']
                ],
                [
                    'method' => 'getMaintenanceServiceReset',
                    'name' => 'Maintenance Service Reset',
                    'description' => 'Get service indicator reset procedures for the vehicle',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getMaintenanceForms',
                    'name' => 'Maintenance Forms',
                    'description' => 'Get maintenance forms for the vehicle',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getMaintenanceSystemOverviewV2',
                    'name' => 'Maintenance System Overview V2',
                    'description' => 'Get maintenance system overview (V2)',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getMaintenancePartsForPeriod',
                    'name' => 'Maintenance Parts for Period',
                    'description' => 'Get maintenance parts for specific period',
                    'parameters' => ['carTypeId' => $carTypeId, 'periodId' => 'required']
                ],
                [
                    'method' => 'getCalculatedMaintenanceV4',
                    'name' => 'Calculated Maintenance V4',
                    'description' => 'Get calculated maintenance intervals (V4)',
                    'parameters' => ['carTypeId' => $carTypeId, 'mileage' => 50000, 'months' => 60]
                ],
                [
                    'method' => 'getTimingBeltMaintenanceTasksV5',
                    'name' => 'Timing Belt Maintenance Tasks V5',
                    'description' => 'Get timing belt maintenance tasks (V5)',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getTimingBeltReplacementIntervals',
                    'name' => 'Timing Belt Replacement Intervals',
                    'description' => 'Get timing belt replacement intervals',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getWearPartsIntervalsV3',
                    'name' => 'Wear Parts Intervals V3',
                    'description' => 'Get wear parts replacement intervals (V3)',
                    'parameters' => ['carTypeId' => $carTypeId]
                ]
            ];

            // RECALLS & SAFETY
            $methods['RECALLS & SAFETY'] = [
                [
                    'method' => 'getRecalls',
                    'name' => 'Vehicle Recalls',
                    'description' => 'Get vehicle recall information',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getStructureByCarTypeId',
                    'name' => 'Vehicle Structure',
                    'description' => 'Get vehicle system structure information',
                    'parameters' => ['carTypeId' => $carTypeId]
                ]
            ];
        }

        return $methods;
    }

    /**
     * Call a specific HaynesPro method with the given parameters
     */
    private function callHaynesProMethod($method, $vehicle, $parameters = [])
    {
        switch ($method) {
            // Technical information methods (require carTypeId)
            case 'getMaintenanceSystems':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getMaintenanceSystems($vehicle->car_type_id);
                
            case 'getMaintenanceTasks':
                $this->ensureCarTypeId($vehicle);
                $systemId = $parameters['systemId'] ?? 1; // Default to system 1 if not provided
                return $this->haynesProService->getMaintenanceTasks($vehicle->car_type_id, $systemId);
                
            case 'getRepairTimeInfos':
                $this->ensureCarTypeId($vehicle);
                $systemGroup = $parameters['systemGroup'] ?? null;
                return $this->haynesProService->getRepairTimeInfos($vehicle->car_type_id, $systemGroup);
                
            case 'getTechnicalDrawings':
                $this->ensureCarTypeId($vehicle);
                $systemGroup = $parameters['systemGroup'] ?? null;
                return $this->haynesProService->getTechnicalDrawings($vehicle->car_type_id, $systemGroup);
                
            case 'getWiringDiagrams':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getWiringDiagrams($vehicle->car_type_id);
                
            case 'getFuseLocations':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getFuseLocations($vehicle->car_type_id);
                
            case 'getTechnicalBulletins':
                $this->ensureCarTypeId($vehicle);
                $systemGroup = $parameters['systemGroup'] ?? null;
                return $this->haynesProService->getTechnicalBulletins($vehicle->car_type_id, $systemGroup);
                
            case 'getRecalls':
                $this->ensureCarTypeId($vehicle);
                $systemGroup = $parameters['systemGroup'] ?? null;
                return $this->haynesProService->getRecalls($vehicle->car_type_id, $systemGroup);
                
            case 'getManagementSystems':
                $this->ensureCarTypeId($vehicle);
                $systemGroup = $parameters['systemGroup'] ?? null;
                return $this->haynesProService->getManagementSystems($vehicle->car_type_id, $systemGroup);
                
            case 'getStoryOverview':
                $this->ensureCarTypeId($vehicle);
                $systemGroup = $parameters['systemGroup'] ?? null;
                return $this->haynesProService->getStoryOverview($vehicle->car_type_id, $systemGroup);
                
            case 'getWarningLights':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getWarningLights($vehicle->car_type_id);
                
            case 'getEngineLocation':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getEngineLocation($vehicle->car_type_id);
                
            case 'getAdjustmentsV7':
                $this->ensureCarTypeId($vehicle);
                $systemGroup = $parameters['systemGroup'] ?? 'ENGINE';
                return $this->haynesProService->getAdjustmentsV7($vehicle->car_type_id, $systemGroup);
                
            case 'getLubricantsV5':
                $this->ensureCarTypeId($vehicle);
                $systemGroup = $parameters['systemGroup'] ?? 'ENGINE';
                return $this->haynesProService->getLubricantsV5($vehicle->car_type_id, $systemGroup);
                
            case 'getDtcInfos':
                $this->ensureCarTypeId($vehicle);
                $dtc = $parameters['dtc'] ?? 'P0300';
                return $this->haynesProService->getDtcInfos($vehicle->car_type_id, $dtc);
                
            case 'getPids':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getPids($vehicle->car_type_id);
                
            case 'getTestProcedures':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getTestProcedures($vehicle->car_type_id);
                
            case 'getStructureByCarTypeId':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getStructureByCarTypeId($vehicle->car_type_id);

            // New Maintenance Methods
            case 'getMaintenanceSystemsV7':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getMaintenanceSystemsV7($vehicle->car_type_id);
                
            case 'getMaintenanceTasksV9':
                $this->ensureCarTypeId($vehicle);
                $systemId = $parameters['systemId'] ?? 1;
                $periodId = $parameters['periodId'] ?? null;
                return $this->haynesProService->getMaintenanceTasksV9($vehicle->car_type_id, $systemId, $periodId);
                
            case 'getMaintenanceForms':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getMaintenanceForms($vehicle->car_type_id);
                
            case 'getMaintenanceSystemOverviewV2':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getMaintenanceSystemOverviewV2($vehicle->car_type_id);
                
            case 'getMaintenanceServiceReset':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getMaintenanceServiceReset($vehicle->car_type_id);
                
            case 'getMaintenancePartsForPeriod':
                $this->ensureCarTypeId($vehicle);
                $periodId = $parameters['periodId'] ?? null;
                if (!$periodId) throw new Exception('periodId parameter is required');
                return $this->haynesProService->getMaintenancePartsForPeriod($vehicle->car_type_id, $periodId);
                
            case 'getCalculatedMaintenanceV4':
                $this->ensureCarTypeId($vehicle);
                $mileage = $parameters['mileage'] ?? 50000;
                $months = $parameters['months'] ?? 60;
                return $this->haynesProService->getCalculatedMaintenanceV4($vehicle->car_type_id, $mileage, $months);
                
            case 'getTimingBeltMaintenanceTasksV5':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getTimingBeltMaintenanceTasksV5($vehicle->car_type_id);
                
            case 'getTimingBeltReplacementIntervals':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getTimingBeltReplacementIntervals($vehicle->car_type_id);
                
            case 'getWearPartsIntervalsV3':
                $this->ensureCarTypeId($vehicle);
                return $this->haynesProService->getWearPartsIntervalsV3($vehicle->car_type_id);

            // New Drawings Method
            case 'getDrawingsV4':
                $this->ensureCarTypeId($vehicle);
                $systemGroup = $parameters['systemGroup'] ?? null;
                return $this->haynesProService->getDrawingsV4($vehicle->car_type_id, $systemGroup);
                
            default:
                throw new Exception("Unknown API method: {$method}");
        }
    }

    /**
     * Ensure the vehicle has a car type ID available
     */
    private function ensureCarTypeId($vehicle)
    {
        if (!$vehicle->hasCarTypeIdentification()) {
            throw new Exception('Vehicle does not have car type identification. Please refresh the vehicle data to perform complete identification.');
        }
    }
} 