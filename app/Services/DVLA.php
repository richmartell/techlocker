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
            Log::info('DVLA API: Starting vehicle lookup', [
                'registration' => $registrationNumber,
                'api_key_configured' => !empty($this->apiKey),
                'api_key_preview' => !empty($this->apiKey) ? substr($this->apiKey, 0, 8) . '...' : null,
                'endpoint' => $this->baseUrl
            ]);
            
            $requestPayload = [
                'registrationNumber' => $registrationNumber,
            ];
            
            Log::info('DVLA API: Sending request', [
                'payload' => $requestPayload,
                'headers' => [
                    'x-api-key' => !empty($this->apiKey) ? 'SET' : 'NOT_SET',
                    'Content-Type' => 'application/json'
                ]
            ]);
            
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl, $requestPayload);

            Log::info('DVLA API: Response received', [
                'registration' => $registrationNumber,
                'status' => $response->status(),
                'content_type' => $response->header('Content-Type'),
                'response_size' => strlen($response->body())
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                Log::info('DVLA API: Successfully retrieved vehicle details', [
                    'registration' => $registrationNumber,
                    'status' => $response->status(),
                    'data_keys' => array_keys($data ?? []),
                    'make' => $data['make'] ?? 'NOT_PROVIDED',
                    'model' => $data['model'] ?? 'NOT_PROVIDED',
                    'colour' => $data['colour'] ?? 'NOT_PROVIDED',
                    'fuel_type' => $data['fuelType'] ?? 'NOT_PROVIDED',
                    'year_of_manufacture' => $data['yearOfManufacture'] ?? 'NOT_PROVIDED',
                    'full_response' => $data
                ]);
                
                return $data;
            }

            $responseBody = $response->body();
            
            Log::error('DVLA API: Request failed', [
                'registration' => $registrationNumber,
                'status' => $response->status(),
                'response_body' => $responseBody,
                'response_headers' => $response->headers()
            ]);

            throw new Exception('DVLA API request failed with status ' . $response->status() . ': ' . $responseBody);
        } catch (Exception $e) {
            Log::error('DVLA API: Exception occurred', [
                'registration' => $registrationNumber,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
} 