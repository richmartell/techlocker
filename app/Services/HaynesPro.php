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

        // Get the JSON response and ensure it's always an array
        $data = $response->json();
        
        // Handle null or empty responses by returning an empty array
        if ($data === null || $data === '') {
            Log::info('HaynesPro API returned null/empty response', [
                'endpoint' => $endpoint,
                'method' => $method,
                'status' => $response->status()
            ]);
            return [];
        }

        // Ensure the response is an array
        if (!is_array($data)) {
            Log::warning('HaynesPro API returned non-array response', [
                'endpoint' => $endpoint,
                'method' => $method,
                'response_type' => gettype($data),
                'response_data' => $data
            ]);
            return [];
        }

        return $data;
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

    /**
     * Get maintenance tasks for a vehicle by carTypeId.
     * Based on getMaintenanceTasksV9 from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param int $systemId The maintenance system ID (optional)
     * @param int $periodId The maintenance period ID (optional)
     * @param bool $includeSmartLinks Whether to include smart links
     * @param bool $includeServiceTimes Whether to include service times
     * @return array The maintenance tasks data
     * @throws Exception If the API request fails
     */
    public function getMaintenanceTasks(int $carTypeId, int $systemId, ?int $periodId = null, bool $includeSmartLinks = true, bool $includeServiceTimes = true): array
    {
        try {
            Log::info('HaynesPro: Starting maintenance tasks lookup', [
                'carTypeId' => $carTypeId,
                'systemId' => $systemId,
                'periodId' => $periodId
            ]);

            $params = [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId,
                'includeSmartLinks' => $includeSmartLinks,
                'includeServiceTimes' => $includeServiceTimes,
                'maintenanceBasedType' => 'SUBJECT_BASED'
            ];

            if ($systemId) {
                $params['systemId'] = $systemId;
            }

            if ($periodId) {
                $params['periodId'] = $periodId;
            }

            $response = $this->request('getMaintenanceTasksV9', $params, 'get');

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
     * Get maintenance systems for a vehicle by carTypeId.
     * Based on getMaintenanceSystemsV7 from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The maintenance systems data
     * @throws Exception If the API request fails
     */
    public function getMaintenanceSystems(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting maintenance systems lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getMaintenanceSystemsV7', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved maintenance systems', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting maintenance systems', [
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
     * Based on getRepairtimeInfosV4 from HaynesPro API documentation
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
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ];

            if ($systemGroup) {
                $params['systemGroup'] = $systemGroup;
            }

            $response = $this->request('getRepairtimeInfosV4', $params, 'get');

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
     * Based on getDrawingsV4 from HaynesPro API documentation
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
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ];

            if ($systemGroup) {
                $params['systemGroup'] = $systemGroup;
            }

            $response = $this->request('getDrawingsV4', $params, 'get');

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
     * Based on getWiringDiagramsV3 from HaynesPro API documentation
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
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

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
     * Based on getFuseLocationsV3 from HaynesPro API documentation
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

            $response = $this->request('getFuseLocationsV3', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

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
     * Get technical service bulletins for a vehicle by carTypeId.
     * Based on getTSBDataV4 from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param string $systemGroup The system group (optional)
     * @return array The technical bulletins data
     * @throws Exception If the API request fails
     */
    public function getTechnicalBulletins(int $carTypeId, ?string $systemGroup = null): array
    {
        try {
            Log::info('HaynesPro: Starting technical bulletins lookup', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);

            $params = [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ];

            if ($systemGroup) {
                $params['systemGroup'] = $systemGroup;
            }

            $response = $this->request('getTSBDataV4', $params, 'get');

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
     * Based on getRecallDataV3 from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param string $systemGroup The system group (optional)
     * @return array The recalls data
     * @throws Exception If the API request fails
     */
    public function getRecalls(int $carTypeId, ?string $systemGroup = null): array
    {
        try {
            Log::info('HaynesPro: Starting recalls lookup', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);

            $params = [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ];

            if ($systemGroup) {
                $params['systemGroup'] = $systemGroup;
            }

            $response = $this->request('getRecallDataV3', $params, 'get');

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
     * Get management systems for a vehicle by carTypeId.
     * Based on getManagementSystems from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param string $systemGroup The system group (optional)
     * @return array The management systems data
     * @throws Exception If the API request fails
     */
    public function getManagementSystems(int $carTypeId, ?string $systemGroup = null): array
    {
        try {
            Log::info('HaynesPro: Starting management systems lookup', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);

            $params = [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ];

            if ($systemGroup) {
                $params['systemGroup'] = $systemGroup;
            }

            $response = $this->request('getManagementSystems', $params, 'get');

            Log::info('HaynesPro: Successfully retrieved management systems', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting management systems', [
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
     * Get story overview (repair manuals) for a vehicle by carTypeId.
     * Based on getStoryOverviewByGroupV2 from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param string $systemGroup The system group (optional)
     * @return array The story overview data
     * @throws Exception If the API request fails
     */
    public function getStoryOverview(int $carTypeId, ?string $systemGroup = null): array
    {
        try {
            Log::info('HaynesPro: Starting story overview lookup', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);

            $params = [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ];

            if ($systemGroup) {
                $params['systemGroup'] = $systemGroup;
                $response = $this->request('getStoryOverviewByGroupV2', $params, 'get');
            } else {
                $response = $this->request('getStoryOverview', $params, 'get');
            }

            Log::info('HaynesPro: Successfully retrieved story overview', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting story overview', [
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
     * Get warning lights for a vehicle by carTypeId.
     * Based on getWarningLightsV2 from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The warning lights data
     * @throws Exception If the API request fails
     */
    public function getWarningLights(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting warning lights lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getWarningLightsV2', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved warning lights', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting warning lights', [
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
     * Get engine location information for a vehicle by carTypeId.
     * Based on getEngineLocation from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The engine location data
     * @throws Exception If the API request fails
     */
    public function getEngineLocation(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting engine location lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getEngineLocation', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved engine location', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting engine location', [
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
     * Get updated getAdjustments method that uses the proper carTypeId parameter.
     * Based on getAdjustmentsV7 from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param string $systemGroup The system group
     * @param bool $includeSmartLinks Whether to include smart links
     * @param bool $includeGenarts Whether to include general articles
     * @return array The adjustments data
     * @throws Exception If the API request fails
     */
    public function getAdjustmentsV7(int $carTypeId, string $systemGroup, bool $includeSmartLinks = true, bool $includeGenarts = true): array
    {
        try {
            Log::info('HaynesPro: Starting adjustments lookup', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);

            $response = $this->request('getAdjustmentsV7', [
                'descriptionLanguage' => 'en',
                'carType' => $carTypeId,  // Note: API uses 'carType' not 'carTypeId'
                'carTypeGroup' => $systemGroup,
                'includeSmartLinks' => $includeSmartLinks,
                'includeGenarts' => $includeGenarts,
                'includeCriterias' => false
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved adjustments', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting adjustments', [
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
     * Get updated getLubricants method that uses the proper carTypeId parameter.
     * Based on getLubricantsV5 from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param string $systemGroup The system group
     * @param bool $includeSmartLinks Whether to include smart links
     * @param bool $includeGenarts Whether to include general articles
     * @return array The lubricants data
     * @throws Exception If the API request fails
     */
    public function getLubricantsV5(int $carTypeId, string $systemGroup, bool $includeSmartLinks = true, bool $includeGenarts = true): array
    {
        try {
            Log::info('HaynesPro: Starting lubricants lookup', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);

            $response = $this->request('getLubricantsV5', [
                'descriptionLanguage' => 'en',
                'carType' => $carTypeId,  // Note: API uses 'carType' not 'carTypeId'
                'carTypeGroup' => $systemGroup,
                'includeSmartLinks' => $includeSmartLinks,
                'includeGenarts' => $includeGenarts
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved lubricants', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting lubricants', [
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
                
                // Handle null or empty VRM API responses
                if ($data === null || $data === '') {
                    Log::info('HaynesPro VRM API: Empty response for vehicle', [
                        'vrm' => $vrm,
                        'status' => $response->status()
                    ]);
                    return [];
                }

                // Ensure data is an array
                if (!is_array($data)) {
                    Log::warning('HaynesPro VRM API: Non-array response', [
                        'vrm' => $vrm,
                        'response_type' => gettype($data),
                        'response_data' => $data
                    ]);
                    return [];
                }
                
                Log::info('HaynesPro VRM API: Successfully retrieved vehicle details', [
                    'vrm' => $vrm,
                    'status' => $response->status(),
                    'data_keys' => array_keys($data),
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
     * Find car types by vehicle details using the standard API.
     * This method is used to get carTypeId from vehicle information for technical information access.
     *
     * @param string $make The vehicle make
     * @param string $model The vehicle model
     * @param string $year The vehicle year
     * @param string $fuelType The fuel type
     * @param string $engineCapacity The engine capacity
     * @param string $vin The VIN number (optional)
     * @return array Array of car types with their carTypeId
     * @throws Exception If the API request fails
     */
    public function findCarTypesByDetails(string $make, string $model, string $year, string $fuelType = '', string $engineCapacity = '', string $vin = ''): array
    {
        try {
            Log::info('HaynesPro: Starting findCarTypesByDetails', [
                'make' => $make,
                'model' => $model,
                'year' => $year,
                'fuel_type' => $fuelType,
                'engine_capacity' => $engineCapacity,
                'vin' => $vin
            ]);

            // Try VIN decoding first if VIN is provided
            if (!empty($vin)) {
                try {
                    $response = $this->request('decodeVINV4', [
                        'descriptionLanguage' => 'en',
                        'vin' => $vin
                    ], 'get');

                    if (!empty($response)) {
                        Log::info('HaynesPro: Successfully retrieved car types from VIN via decodeVINV4', [
                            'vin' => $vin,
                            'response_count' => count($response ?? [])
                        ]);

                        return $response;
                    }
                } catch (Exception $e) {
                    Log::warning('HaynesPro: decodeVINV4 failed, trying alternative methods', [
                        'vin' => $vin,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Try different methods to find car types
            $methods = [
                'FindCarTypesV2' => [
                    'descriptionLanguage' => 'en',
                    'make' => $make,
                    'model' => $model,
                    'year' => $year,
                    'filter_dataset' => 'WORKSHOP'
                ],
                'findCarTypesByDetailsV3' => [
                    'descriptionLanguage' => 'en',
                    'make' => $make,
                    'model' => $model,
                    'year' => $year,
                    'filter_dataset' => 'WORKSHOP'
                ]
            ];

            foreach ($methods as $method => $params) {
                try {
                    // Add additional parameters if provided
                    if (!empty($fuelType)) {
                        $params['fuelType'] = strtoupper($fuelType);
                    }
                    
                    if (!empty($engineCapacity)) {
                        $params['capacity'] = $engineCapacity;
                    }
                    
                    if (!empty($vin)) {
                        $params['vin'] = $vin;
                    }

                    $response = $this->request($method, $params);

                    if (!empty($response)) {
                        Log::info('HaynesPro: Successfully retrieved car types from vehicle details via ' . $method, [
                            'make' => $make,
                            'model' => $model,
                            'year' => $year,
                            'response_count' => count($response ?? [])
                        ]);

                        return $response;
                    }
                } catch (Exception $e) {
                    Log::warning('HaynesPro: ' . $method . ' failed, trying next method', [
                        'make' => $make,
                        'model' => $model,
                        'year' => $year,
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }

            throw new Exception('No car types found for the given vehicle details');

        } catch (Exception $e) {
            Log::error('HaynesPro: Exception in findCarTypesByDetails', [
                'make' => $make,
                'model' => $model,
                'year' => $year,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Test maintenance tasks with minimal parameters
     */
    public function testMaintenanceTasks(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Testing maintenance tasks with minimal params', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getMaintenanceTasksV9', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

            Log::info('HaynesPro: Minimal maintenance tasks success', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Minimal maintenance tasks failed', [
                'carTypeId' => $carTypeId,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Test the decodeVINV4 method directly
     */
    public function testDecodeVINV4(string $vin): array
    {
        try {
            Log::info('HaynesPro: Testing decodeVINV4', [
                'vin' => $vin
            ]);

            // Try GET method first
            try {
                $response = $this->request('decodeVINV4', [
                    'descriptionLanguage' => 'en',
                    'vin' => $vin
                ], 'get');

                Log::info('HaynesPro: decodeVINV4 success with GET', [
                    'vin' => $vin,
                    'response_count' => count($response ?? [])
                ]);

                return $response;
            } catch (Exception $e) {
                Log::warning('HaynesPro: decodeVINV4 GET failed, trying POST', [
                    'vin' => $vin,
                    'error' => $e->getMessage()
                ]);

                // Fallback to POST method
                $response = $this->request('decodeVINV4', [
                    'descriptionLanguage' => 'en',
                    'vin' => $vin
                ], 'post');

                Log::info('HaynesPro: decodeVINV4 success with POST', [
                    'vin' => $vin,
                    'response_count' => count($response ?? [])
                ]);

                return $response;
            }
        } catch (Exception $e) {
            Log::error('HaynesPro: decodeVINV4 failed', [
                'vin' => $vin,
                'error' => $e->getMessage()
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
            ], 'get');

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
            ], 'get');

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
            ], 'get');

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
            ], 'get');

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

    /**
     * Get maintenance systems for a vehicle by carTypeId (Version 7).
     * Based on getMaintenanceSystemsV7 from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The maintenance systems data
     * @throws Exception If the API request fails
     */
    public function getMaintenanceSystemsV7(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting maintenance systems V7 lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getMaintenanceSystemsV7', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved maintenance systems V7', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting maintenance systems V7', [
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
     * Get maintenance tasks for a vehicle by carTypeId (Version 9).
     * Based on getMaintenanceTasksV9 from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param int $systemId The maintenance system ID
     * @param int $periodId The maintenance period ID (optional)
     * @return array The maintenance tasks data
     * @throws Exception If the API request fails
     */
    public function getMaintenanceTasksV9(int $carTypeId, int $systemId, ?int $periodId = null): array
    {
        try {
            Log::info('HaynesPro: Starting maintenance tasks V9 lookup', [
                'carTypeId' => $carTypeId,
                'systemId' => $systemId,
                'periodId' => $periodId
            ]);

            $params = [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId,
                'systemId' => $systemId,
                'repairtimesTypeId' => 120226,
                'rtTypeCategory' => 'CAR',
                'includeSmartLinks' => true,
                'includeServiceTimes' => true,
                'maintenanceBasedType' => 'SUBJECT_BASED'
            ];

            if ($periodId) {
                $params['periodId'] = $periodId;
            }

            $response = $this->request('getMaintenanceTasksV9', $params, 'get');

            Log::info('HaynesPro: Successfully retrieved maintenance tasks V9', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting maintenance tasks V9', [
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
     * Get maintenance forms for a vehicle by carTypeId.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The maintenance forms data
     * @throws Exception If the API request fails
     */
    public function getMaintenanceForms(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting maintenance forms lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getMaintenanceForms', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved maintenance forms', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting maintenance forms', [
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
     * Get maintenance system overview for a vehicle by carTypeId (Version 2).
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The maintenance system overview data
     * @throws Exception If the API request fails
     */
    public function getMaintenanceSystemOverviewV2(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting maintenance system overview V2 lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getMaintenanceSystemOverviewV2', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved maintenance system overview V2', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting maintenance system overview V2', [
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
     * Get maintenance parts for a specific period.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param int $periodId The maintenance period ID
     * @return array The maintenance parts data
     * @throws Exception If the API request fails
     */
    public function getMaintenancePartsForPeriod(int $carTypeId, int $periodId): array
    {
        try {
            Log::info('HaynesPro: Starting maintenance parts for period lookup', [
                'carTypeId' => $carTypeId,
                'periodId' => $periodId
            ]);

            $response = $this->request('getMaintenancePartsForPeriod', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId,
                'periodId' => $periodId
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved maintenance parts for period', [
                'carTypeId' => $carTypeId,
                'periodId' => $periodId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting maintenance parts for period', [
                'carTypeId' => $carTypeId,
                'periodId' => $periodId,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get calculated maintenance for a vehicle (Version 4).
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param int $mileage The vehicle mileage
     * @param int $months The months in service
     * @return array The calculated maintenance data
     * @throws Exception If the API request fails
     */
    public function getCalculatedMaintenanceV4(int $carTypeId, int $mileage, int $months): array
    {
        try {
            Log::info('HaynesPro: Starting calculated maintenance V4 lookup', [
                'carTypeId' => $carTypeId,
                'mileage' => $mileage,
                'months' => $months
            ]);

            $response = $this->request('getCalculatedMaintenanceV4', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId,
                'mileage' => $mileage,
                'months' => $months
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved calculated maintenance V4', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting calculated maintenance V4', [
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
     * Get all calculated maintenance intervals for a vehicle (Version 4).
     * This version doesn't require specific mileage/months and returns all intervals.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The maintenance intervals data
     * @throws Exception If the API request fails
     */
    public function getAllMaintenanceIntervals(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting all maintenance intervals lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getCalculatedMaintenanceV4', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved all maintenance intervals', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting all maintenance intervals', [
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
     * Get timing belt maintenance tasks for a vehicle (Version 5).
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The timing belt maintenance tasks data
     * @throws Exception If the API request fails
     */
    public function getTimingBeltMaintenanceTasksV5(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting timing belt maintenance tasks V5 lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getTimingBeltMaintenanceTasksV5', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved timing belt maintenance tasks V5', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting timing belt maintenance tasks V5', [
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
     * Get timing belt replacement intervals for a vehicle.
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The timing belt replacement intervals data
     * @throws Exception If the API request fails
     */
    public function getTimingBeltReplacementIntervals(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting timing belt replacement intervals lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getTimingBeltReplacementIntervals', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved timing belt replacement intervals', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting timing belt replacement intervals', [
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
     * Get wear parts intervals for a vehicle (Version 3).
     *
     * @param int $carTypeId The vehicle carTypeId
     * @return array The wear parts intervals data
     * @throws Exception If the API request fails
     */
    public function getWearPartsIntervalsV3(int $carTypeId): array
    {
        try {
            Log::info('HaynesPro: Starting wear parts intervals V3 lookup', [
                'carTypeId' => $carTypeId
            ]);

            $response = $this->request('getWearPartsIntervalsV3', [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ], 'get');

            Log::info('HaynesPro: Successfully retrieved wear parts intervals V3', [
                'carTypeId' => $carTypeId,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting wear parts intervals V3', [
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
     * Get technical drawings for a vehicle by carTypeId and system group (Version 4).
     * Based on getDrawingsV4 from HaynesPro API documentation
     *
     * @param int $carTypeId The vehicle carTypeId
     * @param string $systemGroup The system group (e.g., 'ENGINE', 'SUSPENSION')
     * @return array The technical drawings data
     * @throws Exception If the API request fails
     */
    public function getDrawingsV4(int $carTypeId, ?string $systemGroup = null): array
    {
        try {
            Log::info('HaynesPro: Starting drawings V4 lookup', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup
            ]);

            $params = [
                'descriptionLanguage' => 'en',
                'carTypeId' => $carTypeId
            ];

            if ($systemGroup) {
                $params['systemGroup'] = $systemGroup;
            }

            $response = $this->request('getDrawingsV4', $params, 'get');

            Log::info('HaynesPro: Successfully retrieved drawings V4', [
                'carTypeId' => $carTypeId,
                'systemGroup' => $systemGroup,
                'response_count' => count($response ?? [])
            ]);

            return $response;
        } catch (Exception $e) {
            Log::error('HaynesPro: Exception getting drawings V4', [
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
     * Complete vehicle identification process:
     * 1. Get vehicle details from VRM API
     * 2. Use VIN to decode and get car types
     * 3. Extract car type ID and available subjects
     * 
     * @param string $registration The vehicle registration
     * @return array Array containing vehicle data, car_type_id, and available_subjects
     * @throws Exception If identification process fails
     */
    public function identifyVehicleComplete(string $registration): array
    {
        try {
            Log::info('HaynesPro: Starting complete vehicle identification', [
                'registration' => $registration
            ]);

            // Step 1: Get vehicle details from VRM API
            $vrmData = $this->getVehicleDetailsByVrm($registration);
            
            // Handle empty VRM response
            if (empty($vrmData) || !isset($vrmData['VehicleInfo'])) {
                Log::warning('HaynesPro: No vehicle data found for registration', [
                    'registration' => $registration,
                    'vrm_response' => $vrmData
                ]);
                
                return [
                    'vehicle_data' => null,
                    'car_type_id' => null,
                    'available_subjects' => [],
                    'identification_method' => 'not_found',
                    'error' => 'No vehicle found with registration ' . $registration
                ];
            }

            $vehicleInfo = $vrmData['VehicleInfo'];
            
            // Check if we have a VIN
            $vin = $vehicleInfo['CombinedVin'] ?? null;
            if (empty($vin)) {
                Log::warning('HaynesPro: No VIN available for vehicle', ['registration' => $registration]);
                
                // Return basic vehicle info without car type identification
                return [
                    'vehicle_data' => $vehicleInfo,
                    'car_type_id' => null,
                    'available_subjects' => [],
                    'identification_method' => 'vrm_only'
                ];
            }

            // Step 2: Use VIN to decode and get car types
            Log::info('HaynesPro: Decoding VIN', ['vin' => substr($vin, 0, 8) . '***']);
            
            $vinDecodeData = $this->testDecodeVINV4($vin);
            
            if (empty($vinDecodeData) || !is_array($vinDecodeData)) {
                Log::warning('HaynesPro: VIN decode returned no data', ['vin' => substr($vin, 0, 8) . '***']);
                
                return [
                    'vehicle_data' => $vehicleInfo,
                    'car_type_id' => null,
                    'available_subjects' => [],
                    'identification_method' => 'vrm_only'
                ];
            }

            // Step 3: Extract car type ID and available subjects
            $carTypeId = null;
            $availableSubjects = [];

            // Look for the first car type with subjects
            foreach ($vinDecodeData as $carType) {
                if (isset($carType['id']) && !empty($carType['id'])) {
                    $carTypeId = (int) $carType['id'];
                    
                    // Extract available subjects
                    if (isset($carType['subjectsByGroup']['mapItems']) && is_array($carType['subjectsByGroup']['mapItems'])) {
                        foreach ($carType['subjectsByGroup']['mapItems'] as $group) {
                            if (isset($group['value']) && !empty($group['value'])) {
                                $subjects = explode(',', $group['value']);
                                $availableSubjects = array_merge($availableSubjects, $subjects);
                            }
                        }
                    }
                    
                    // Use the first valid car type we find
                    break;
                }
            }

            // Remove duplicates and clean up subjects
            $availableSubjects = array_unique(array_filter(array_map('trim', $availableSubjects)));

            Log::info('HaynesPro: Vehicle identification complete', [
                'registration' => $registration,
                'car_type_id' => $carTypeId,
                'subjects_count' => count($availableSubjects),
                'identification_method' => 'vrm_and_vin'
            ]);

            return [
                'vehicle_data' => $vehicleInfo,
                'car_type_id' => $carTypeId,
                'available_subjects' => $availableSubjects,
                'identification_method' => 'vrm_and_vin',
                'vin_decode_data' => $vinDecodeData
            ];

        } catch (Exception $e) {
            Log::error('HaynesPro: Exception in complete vehicle identification', [
                'registration' => $registration,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            
            throw $e;
        }
    }

} 