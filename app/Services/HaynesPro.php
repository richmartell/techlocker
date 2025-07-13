<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class HaynesPro
{
    /**
     * The base URL for the HaynesPro API
     */
    protected string $baseUrl = 'https://www.haynespro-services.com/workshopServices3/rest/jsonendpoint';

    /**
     * The base URL for the HaynesPro VRM API
     */
    protected string $vrmBaseUrl = 'https://uk.haynespro-services.com/api/v1';

    /**
     * The distributor credentials
     */
    protected string $distributorUsername;
    protected string $distributorPassword;

    /**
     * The VRM API credentials
     */
    protected string $vrmUsername;
    protected string $vrmToken;

    /**
     * The current VRID (session token)
     */
    protected ?string $vrid = null;

    /**
     * Create a new HaynesPro service instance.
     */
    public function __construct()
    {
        $this->distributorUsername = config('services.haynespro.distributor_username');
        $this->distributorPassword = config('services.haynespro.distributor_password');
        $this->vrmUsername = config('services.haynespro.vrm_username');
        $this->vrmToken = config('services.haynespro.vrm_token');
    }

    /**
     * Get the VRID (session token) for API authentication.
     * Will use cached VRID if available and not expired.
     *
     * @return string The VRID
     * @throws Exception If authentication fails
     */
    protected function getVrid(): string
    {
        // Try to get VRID from cache
        $cachedVrid = Cache::get('haynespro_vrid');
        if ($cachedVrid) {
            $this->vrid = $cachedVrid;
            return $this->vrid;
        }

        // If no cached VRID, authenticate
        $response = Http::get("{$this->baseUrl}/getAuthenticationVrid", [
            'distributorUsername' => $this->distributorUsername,
            'distributorPassword' => $this->distributorPassword,
            'username' => 'demo_user', // Arbitrary username for demo access
        ]);

        if (!$response->successful()) {
            Log::error('HaynesPro authentication failed', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);
            throw new Exception('Failed to authenticate with HaynesPro API');
        }

        $data = $response->json();
        if (!isset($data['vrid'])) {
            throw new Exception('Invalid response from HaynesPro API: missing VRID');
        }

        // Cache the VRID for 8 hours
        $this->vrid = $data['vrid'];
        Cache::put('haynespro_vrid', $this->vrid, now()->addHours(8));

        return $this->vrid;
    }

    /**
     * Make an authenticated request to the HaynesPro API.
     *
     * @param string $endpoint The API endpoint
     * @param array $params The request parameters
     * @return array The response data
     * @throws Exception If the request fails
     */
    protected function request(string $endpoint, array $params = [], string $method = 'post'): array
    {
        // Ensure we have a valid VRID
        $vrid = $this->getVrid();

        // Add VRID to parameters
        $params['vrid'] = $vrid;

        // Make the request based on the method
        $response = match (strtolower($method)) {
            'get' => Http::get("{$this->baseUrl}/{$endpoint}", $params),
            'put' => Http::put("{$this->baseUrl}/{$endpoint}", $params),
            'patch' => Http::patch("{$this->baseUrl}/{$endpoint}", $params),
            'delete' => Http::delete("{$this->baseUrl}/{$endpoint}", $params),
            default => Http::post("{$this->baseUrl}/{$endpoint}", $params),
        };

        if (!$response->successful()) {
            Log::error('HaynesPro API request failed', [
                'endpoint' => $endpoint,
                'method' => $method,
                'status' => $response->status(),
                'body' => $response->json()
            ]);
            throw new Exception("HaynesPro API request failed: {$response->status()}");
        }

        return $response->json();
    }

    public function vrid()
    {
        return $this->getVrid();
    }

    public function getVehicleMakes()
    {
        try {
            $response = $this->request('getIdentificationTreeV2', [
                'descriptionLanguage' => 'en',
                'vehicle_id' => '',
                'vehicle_level' => 'ROOT',
                'filter_dataset' => 'WORKSHOP',
                'filter_toVehicleLevel' => 'MAKE'
            ], 'get');
            
            // Extract makes from the subElements array
            $makes = [];
            if (isset($response['subElements']) && is_array($response['subElements'])) {
                foreach ($response['subElements'] as $element) {
                    if (isset($element['fullName'])) {
                        $makes[$element['id']] = $element['fullName'];
                    }
                }
            }
            return $makes;
        } catch (Exception $e) {
            Log::error('Failed to get vehicle makes', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function getVehicleModels($make_id)
    {
        try {
            $response = $this->request('getIdentificationTreeV2', [
                'descriptionLanguage' => 'en',
                'vehicle_id' => $make_id, 
                'vehicle_level' => 'MAKE',
                'filter_dataset' => 'WORKSHOP',
                'filter_toVehicleLevel' => 'MODEL'
            ], 'get');

            // Extract models from the subElements array
            $models = [];   
            if (isset($response['subElements']) && is_array($response['subElements'])) {
                foreach ($response['subElements'] as $element) {
                    if (isset($element['name']) && isset($element['id'])) {
                        $models[$element['id']] = $element['name'];
                    }
                }
            }
            return $models;
        } catch (Exception $e) {
            Log::error('Failed to get vehicle models', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function getVehicleTypes($model_id)
    {
        try {
            $response = $this->request('getIdentificationTreeV2', [
                'descriptionLanguage' => 'en',
                'vehicle_id' => $model_id,  
                'vehicle_level' => 'MODEL', 
                'filter_dataset' => 'WORKSHOP', 
                'filter_toVehicleLevel' => 'TYPE'
            ], 'get');

            return $response;
        } catch (Exception $e) {
            Log::error('Failed to get vehicle types', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function getVehicleDetails($vehicle_id)
    {
        try {
            $response = $this->request('getIdentificationTreeV2', [
                'descriptionLanguage' => 'en',
                'vehicle_id' => $vehicle_id,  
                'vehicle_level' => 'TYPE', 
                'filter_dataset' => 'WORKSHOP', 
                'filter_toVehicleLevel' => 'TYPE'
            ], 'get');      

            return $response;
        } catch (Exception $e) {
            Log::error('Failed to get vehicle details', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function getGeneralInformationLinks()
    {
        try {
            $response = $this->request('getGeneralInformationLinks', [
                'descriptionLanguage' => 'en'
            ], 'get');      

            return $response;
        } catch (Exception $e) {
            Log::error('Failed to get response', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function getAdjustments( $carType, $carTypeGroup )
    {
        try {
            $response = $this->request('getAdjustmentsV7', [
                'descriptionLanguage' => 'en',
                'carType' => $carType,
                'carTypeGroup' => $carTypeGroup,
                'includeSmartLinks' => true,
                'includeGenarts' => true
            ], 'get');

            return $response;
        } catch (Exception $e) {
            Log::error('Failed to get drawings', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function getLubricants( $carType, $carTypeGroup )
    {
        try {
            $response = $this->request('getLubricantsV5', [
                'descriptionLanguage' => 'en',
                'carType' => $carType,
                'carTypeGroup' => $carTypeGroup,
                'includeSmartLinks' => true,
                'includeGenarts' => true
            ], 'get');

            return $response;
        } catch (Exception $e) {
            Log::error('Failed to get drawings', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get vehicle details from the HaynesPro VRM API.
     *
     * @param string $vrm The vehicle registration mark
     * @return array The vehicle details
     * @throws Exception If the API request fails
     */
    public function getVehicleDetailsByVrm(string $vrm): array
    {
        try {
            Log::info('HaynesPro VRM API: Starting vehicle lookup', [
                'vrm' => $vrm,
                'token_configured' => !empty($this->vrmToken),
                'username' => $this->vrmUsername,
                'endpoint' => $this->vrmBaseUrl . '/Vehicle'
            ]);

            $requestPayload = [
                'Identifier' => $vrm,
                'IdentifierType' => 'VRM',
                'ReturnNullItems' => false,
                'RequestedItems' => [
                    'CombinedMake',
                    'CombinedModel',
                    'CombinedEngineCapacity',
                    'CombinedFuelType',
                    'CombinedForwardGears',
                    'CombinedTransmission',
                    'CombinedVin',
                    'HaynesModelVariantDescription',
                    'VrmCurr',
                    'DvlaDateofManufacture',
                    'DvlaLastMileage',
                    'DvlaLastMileageDate',
                    'HaynesMaximumPowerAtRpm',
                    'TecdocKType',
                    'TecdocID',
                    'TecdocKtype',
                    'TecDocKType',
                    'TecDocID',
                    'TecdocNType'
                ]
            ];

            Log::info('HaynesPro VRM API: Sending request', [
                'payload' => $requestPayload,
                'headers' => [
                    'Token' => !empty($this->vrmToken) ? 'SET' : 'NOT_SET',
                    'Content-Type' => 'application/json'
                ]
            ]);

            $response = Http::withHeaders([
                'Token' => $this->vrmToken,
                'Content-Type' => 'application/json',
            ])->post($this->vrmBaseUrl . '/Vehicle', $requestPayload);

            Log::info('HaynesPro VRM API: Response received', [
                'vrm' => $vrm,
                'status' => $response->status(),
                'content_type' => $response->header('Content-Type'),
                'response_size' => strlen($response->body())
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                Log::info('HaynesPro VRM API: Successfully retrieved vehicle details', [
                    'vrm' => $vrm,
                    'status' => $response->status(),
                    'data_keys' => array_keys($data ?? []),
                    'vehicle_info' => $data['VehicleInfo'] ?? null,
                    'full_response' => $data
                ]);
                
                return $data;
            }

            $responseBody = $response->body();
            
            Log::error('HaynesPro VRM API: Request failed', [
                'vrm' => $vrm,
                'status' => $response->status(),
                'response_body' => $responseBody,
                'response_headers' => $response->headers()
            ]);

            throw new Exception('HaynesPro VRM API request failed with status ' . $response->status() . ': ' . $responseBody);
        } catch (Exception $e) {
            Log::error('HaynesPro VRM API: Exception occurred', [
                'vrm' => $vrm,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get vehicle identification by TecdocKtype using the standard API.
     *
     * @param int $tecdocId The TecdocKtype ID
     * @return array The vehicle identification data
     * @throws Exception If the API request fails
     */
    public function getIdentificationByTecdocKtype(int $tecdocId): array
    {
        try {
            Log::info('HaynesPro: Starting identification by TecdocKtype', [
                'tecdoc_id' => $tecdocId
            ]);

            $response = $this->request('getIdentificationByTecdocNumberV2', [
                'descriptionLanguage' => 'en',
                'tecdoc_id' => (int) $tecdocId,
                'tecdoc_vehicleType' => 'CAR',
                'filter_dataset' => ['WORKSHOP'],
                'filter_category' => ['PASSENGER']
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved identification data', [
                'tecdoc_id' => $tecdocId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting identification by TecdocKtype', [
                'tecdoc_id' => $tecdocId,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get vehicle identification by VIN using the standard API.
     *
     * @param string $vin The VIN number
     * @return array The vehicle identification data
     * @throws Exception If the API request fails
     */
    public function getIdentificationByVin(string $vin): array
    {
        try {
            Log::info('HaynesPro: Starting identification by VIN', [
                'vin' => $vin
            ]);

            $response = $this->request('getIdentificationByVin', [
                'descriptionLanguage' => 'en',
                'vin' => $vin
            ]);

            Log::info('HaynesPro: Successfully retrieved identification data by VIN', [
                'vin' => $vin,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting identification by VIN', [
                'vin' => $vin,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get maintenance tasks for a vehicle by carTypeId.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The maintenance tasks data
     * @throws Exception If the API request fails
     */
    public function getMaintenanceTasks(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting maintenance tasks lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getMaintenanceTasksV7', [
                'carTypeId' => $carTypeId,
                'descriptionLanguage' => 'en'
            ]);

            Log::info('HaynesPro: Successfully retrieved maintenance tasks', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting maintenance tasks', [
                'carTypeId' => $carTypeId,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get repair time information for a vehicle by carTypeId and system group.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param string $systemGroup The system group (e.g., 'ENGINE', 'SUSPENSION')
     * @return array The repair time data
     * @throws Exception If the API request fails
     */
    public function getRepairTimeInfos(int $carTypeId, ?string $systemGroup = null): array
    {
        try {
            Log::info('HaynesPro: Starting repair time infos lookup', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);

            $params = [
                'carTypeId' => $carTypeId,
                'descriptionLanguage' => 'en'
            ];

            if ($systemGroup) {
                $params['systemGroup'] = $systemGroup;
            }

            $response = $this->request('getRepairtimeInfosV4', $params);

            Log::info('HaynesPro: Successfully retrieved repair time infos', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting repair time infos', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get technical drawings for a vehicle by carTypeId and system group.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param string $systemGroup The system group (e.g., 'ENGINE', 'SUSPENSION')
     * @return array The technical drawings data
     * @throws Exception If the API request fails
     */
    public function getTechnicalDrawings(int $carTypeId, ?string $systemGroup = null): array
    {
        try {
            Log::info('HaynesPro: Starting technical drawings lookup', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);

            $params = [
                'carTypeId' => $carTypeId,
                'descriptionLanguage' => 'en'
            ];

            if ($systemGroup) {
                $params['systemGroup'] = $systemGroup;
            }

            $response = $this->request('getTechnicalDrawingsV4', $params);

            Log::info('HaynesPro: Successfully retrieved technical drawings', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting technical drawings', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get wiring diagrams for a vehicle by carTypeId.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The wiring diagrams data
     * @throws Exception If the API request fails
     */
    public function getWiringDiagrams(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting wiring diagrams lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getWiringDiagramsV3', [
                'carTypeId' => $carTypeId,
                'descriptionLanguage' => 'en'
            ]);

            Log::info('HaynesPro: Successfully retrieved wiring diagrams', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting wiring diagrams', [
                'carTypeId' => $carTypeId,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get fuse locations for a vehicle by carTypeId.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The fuse locations data
     * @throws Exception If the API request fails
     */
    public function getFuseLocations(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting fuse locations lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getFuseLocationsV2', [
                'carTypeId' => $carTypeId,
                'descriptionLanguage' => 'en'
            ]);

            Log::info('HaynesPro: Successfully retrieved fuse locations', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting fuse locations', [
                'carTypeId' => $carTypeId,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get technical bulletins for a vehicle by carTypeId.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The technical bulletins data
     * @throws Exception If the API request fails
     */
    public function getTechnicalBulletins(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting technical bulletins lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getTechnicalBulletinsV2', [
                'carTypeId' => $carTypeId,
                'descriptionLanguage' => 'en'
            ]);

            Log::info('HaynesPro: Successfully retrieved technical bulletins', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting technical bulletins', [
                'carTypeId' => $carTypeId,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get recalls for a vehicle by carTypeId.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The recalls data
     * @throws Exception If the API request fails
     */
    public function getRecalls(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting recalls lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getRecallsV2', [
                'carTypeId' => $carTypeId,
                'descriptionLanguage' => 'en'
            ]);

            Log::info('HaynesPro: Successfully retrieved recalls', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting recalls', [
                'carTypeId' => $carTypeId,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get DTC (Diagnostic Trouble Code) information for a vehicle by carTypeId and DTC code.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param string $dtc The DTC code (e.g., 'P0300')
     * @return array The DTC information data
     * @throws Exception If the API request fails
     */
    public function getDtcInfos(int $carTypeId, string $dtc): array
    {
        try {
            Log::info('HaynesPro: Starting DTC infos lookup', [
                'carTypeId' => $carTypeId,
                'dtc' => $dtc
            ]);

            $response = $this->request('getDtcInfosV3', [
                'carTypeId' => $carTypeId,
                'dtc' => $dtc,
                'descriptionLanguage' => 'en'
            ]);

            Log::info('HaynesPro: Successfully retrieved DTC infos', [
                'carTypeId' => $carTypeId,
                'dtc' => $dtc,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting DTC infos', [
                'carTypeId' => $carTypeId,
                'dtc' => $dtc,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get PIDs (Parameter IDs) for a vehicle by carTypeId.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The PIDs data
     * @throws Exception If the API request fails
     */
    public function getPids(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting PIDs lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getPidsV3', [
                'carTypeId' => $carTypeId,
                'descriptionLanguage' => 'en'
            ]);

            Log::info('HaynesPro: Successfully retrieved PIDs', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting PIDs', [
                'carTypeId' => $carTypeId,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get test procedures for a vehicle by carTypeId.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The test procedures data
     * @throws Exception If the API request fails
     */
    public function getTestProcedures(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting test procedures lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getTestProceduresV3', [
                'carTypeId' => $carTypeId,
                'descriptionLanguage' => 'en'
            ]);

            Log::info('HaynesPro: Successfully retrieved test procedures', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting test procedures', [
                'carTypeId' => $carTypeId,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get structure by carTypeId to see available system/component hierarchies.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The structure data
     * @throws Exception If the API request fails
     */
    public function getStructureByCarTypeId(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting structure lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getStructureByCarTypeId', [
                'carTypeId' => $carTypeId,
                'descriptionLanguage' => 'en'
            ]);

            Log::info('HaynesPro: Successfully retrieved structure', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting structure', [
                'carTypeId' => $carTypeId,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

} 