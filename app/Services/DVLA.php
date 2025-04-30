<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class DVLA
{
    /**
     * The base URL for the DVLA Vehicle Enquiry Service API
     */
    protected string $baseUrl = 'https://driver-vehicle-licensing.api.gov.uk/vehicle-enquiry/v1/vehicles';

    /**
     * The API key for authentication
     */
    protected string $apiKey;

    /**
     * Create a new DVLA service instance.
     */
    public function __construct()
    {
        $this->apiKey = config('services.dvla.api_key');
        
        if (empty($this->apiKey)) {
            throw new Exception('DVLA API key is not configured. Please set DVLA_API_KEY in your .env file.');
        }
    }

    /**
     * Get vehicle details from the DVLA API.
     *
     * @param string $registrationNumber The vehicle registration number
     * @return array The vehicle details
     * @throws Exception If the API request fails
     */
    public function getVehicleDetails(string $registrationNumber): array
    {
        try {
            Log::info('Fetching vehicle details from DVLA API', ['registration' => $registrationNumber]);
            
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl, [
                'registrationNumber' => $registrationNumber,
            ]);

            if ($response->successful()) {
                Log::info('Successfully retrieved vehicle details from DVLA API', [
                    'registration' => $registrationNumber,
                    'status' => $response->status(),
                ]);
                
                return $response->json();
            }

            Log::error('Failed to retrieve vehicle details from DVLA API', [
                'registration' => $registrationNumber,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new Exception('Failed to retrieve vehicle details: ' . $response->body());
        } catch (Exception $e) {
            Log::error('Error fetching vehicle details from DVLA API', [
                'registration' => $registrationNumber,
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }
} 