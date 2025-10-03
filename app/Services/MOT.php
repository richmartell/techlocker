<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class MOT
{
    /**
     * The base URL for the MOT History API
     */
    protected string $baseUrl = 'https://beta.check-mot.service.gov.uk/trade/vehicles/mot-tests';

    /**
     * The API key for authentication
     */
    protected string $apiKey;

    /**
     * Create a new MOT service instance.
     */
    public function __construct()
    {
        $this->apiKey = config('services.mot.api_key');
        
        if (empty($this->apiKey)) {
            Log::warning('MOT API key is not configured. MOT history will not be available.');
        }
    }

    /**
     * Get MOT history for a vehicle.
     *
     * @param string $registrationNumber The vehicle registration number
     * @return array The MOT history
     * @throws Exception If the API request fails
     */
    public function getMOTHistory(string $registrationNumber): array
    {
        if (empty($this->apiKey)) {
            return [
                'error' => 'MOT API not configured',
                'message' => 'MOT history is not available at this time.'
            ];
        }

        try {
            Log::info('MOT API: Starting MOT history lookup', [
                'registration' => $registrationNumber
            ]);
            
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Accept' => 'application/json+v6',
            ])->get($this->baseUrl, [
                'registration' => $registrationNumber
            ]);

            Log::info('MOT API: Response received', [
                'registration' => $registrationNumber,
                'status' => $response->status()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                Log::info('MOT API: Successfully retrieved MOT history', [
                    'registration' => $registrationNumber,
                    'tests_count' => count($data ?? [])
                ]);
                
                return $data;
            }

            if ($response->status() === 404) {
                return [
                    'error' => 'Vehicle not found',
                    'message' => 'No MOT history found for this registration.'
                ];
            }

            $responseBody = $response->body();
            
            Log::error('MOT API: Request failed', [
                'registration' => $registrationNumber,
                'status' => $response->status(),
                'response_body' => $responseBody
            ]);

            throw new Exception('MOT API request failed with status ' . $response->status());
        } catch (Exception $e) {
            Log::error('MOT API: Exception occurred', [
                'registration' => $registrationNumber,
                'error_message' => $e->getMessage()
            ]);
            
            return [
                'error' => 'API Error',
                'message' => $e->getMessage()
            ];
        }
    }
}

