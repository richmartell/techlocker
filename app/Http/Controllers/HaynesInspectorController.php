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
        $methods = [
            'Technical Information' => []
        ];

        // Add technical information methods if we have carTypeId
        if ($vehicle->hasCarTypeIdentification()) {
            $carTypeId = $vehicle->car_type_id;
            
            $methods['Technical Information'] = [
                [
                    'method' => 'getMaintenanceSystems',
                    'name' => 'Maintenance Systems',
                    'description' => 'Get maintenance systems for the vehicle',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getMaintenanceTasks',
                    'name' => 'Maintenance Tasks',
                    'description' => 'Get maintenance tasks for the vehicle',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemId' => 'optional']
                ],
                [
                    'method' => 'getRepairTimeInfos',
                    'name' => 'Repair Time Information',
                    'description' => 'Get repair time information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'optional']
                ],
                [
                    'method' => 'getTechnicalDrawings',
                    'name' => 'Technical Drawings',
                    'description' => 'Get technical drawings',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'optional']
                ],
                [
                    'method' => 'getWiringDiagrams',
                    'name' => 'Wiring Diagrams',
                    'description' => 'Get wiring diagrams',
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
                    'description' => 'Get technical service bulletins',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'optional']
                ],
                [
                    'method' => 'getRecalls',
                    'name' => 'Vehicle Recalls',
                    'description' => 'Get vehicle recall information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'optional']
                ],
                [
                    'method' => 'getManagementSystems',
                    'name' => 'Management Systems',
                    'description' => 'Get management system information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'optional']
                ],
                [
                    'method' => 'getStoryOverview',
                    'name' => 'Story Overview (Repair Manuals)',
                    'description' => 'Get repair manual information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'optional']
                ],
                [
                    'method' => 'getWarningLights',
                    'name' => 'Warning Lights',
                    'description' => 'Get warning light information',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getEngineLocation',
                    'name' => 'Engine Location',
                    'description' => 'Get engine location information',
                    'parameters' => ['carTypeId' => $carTypeId]
                ],
                [
                    'method' => 'getAdjustmentsV7',
                    'name' => 'Adjustments & Specifications',
                    'description' => 'Get adjustment and specification data',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'required']
                ],
                [
                    'method' => 'getLubricantsV5',
                    'name' => 'Lubricants & Capacities',
                    'description' => 'Get lubricant and capacity information',
                    'parameters' => ['carTypeId' => $carTypeId, 'systemGroup' => 'required']
                ],
                [
                    'method' => 'getDtcInfos',
                    'name' => 'DTC Information',
                    'description' => 'Get diagnostic trouble code information',
                    'parameters' => ['carTypeId' => $carTypeId, 'dtc' => 'required']
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