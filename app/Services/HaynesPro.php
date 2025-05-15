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
     * The distributor credentials
     */
    protected string $distributorUsername;
    protected string $distributorPassword;

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
    

} 