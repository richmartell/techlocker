<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DiagnosticsController extends Controller
{
    /**
     * Show the diagnostics page for a specific vehicle.
     */
    public function show(string $registration): View
    {
        $vehicle = \App\Models\Vehicle::with(['make', 'model'])
            ->where('registration', $registration)
            ->firstOrFail();

        $vehicleData = [
            'registration' => $vehicle->registration,
            'make' => $vehicle->make?->name ?? 'Unknown',
            'model' => $vehicle->model?->name ?? 'Unknown',
            'year' => $vehicle->year_of_manufacture ?? 'Unknown',
            'engine' => $vehicle->engine_capacity ? $vehicle->engine_capacity . 'cc' : 'Unknown',
        ];

        return view('diagnostics-ai', array_merge($vehicleData, ['vehicle' => $vehicle]));
    }

    /**
     * Process a diagnostic message and return an AI response.
     */
    public function processMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'registration' => 'required|string',
        ]);

        $userMessage = $request->input('message');
        $registration = $request->input('registration');
        
        Log::info('Diagnostics request received', [
            'message' => $userMessage,
            'registration' => $registration
        ]);
        
        // Check if we should use OpenAI API
        if (config('services.openai.api_key')) {
            Log::info('Using OpenAI API with key: ' . substr(config('services.openai.api_key'), 0, 3) . '...');
            Log::info('OpenAI model: ' . config('services.openai.model'));
            
            try {
                $response = $this->getOpenAIResponse($userMessage, $registration);
                
                Log::info('OpenAI API response received', [
                    'response_length' => strlen($response)
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => $response,
                ]);
            } catch (\Exception $e) {
                Log::error('OpenAI API error: ' . $e->getMessage(), [
                    'exception' => get_class($e),
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Fallback to local response if API fails
                $response = $this->generateLocalDiagnosticResponse($userMessage, $registration);
                
                return response()->json([
                    'success' => true,
                    'message' => $response . "\n\n(Note: This response was generated locally as the AI service was unavailable. Error: " . $e->getMessage() . ")",
                ]);
            }
        } else {
            Log::info('No OpenAI API key found, using local response generator');
            
            // Use local response generation if no API key is set
            $response = $this->generateLocalDiagnosticResponse($userMessage, $registration);
            
            return response()->json([
                'success' => true,
                'message' => $response,
            ]);
        }
    }

    /**
     * Get a response from the OpenAI API.
     */
    private function getOpenAIResponse(string $userMessage, string $registration): string
    {
        // Get vehicle data (in a real app, this would be fetched from the database)
        $vehicleData = [
            'registration' => $registration,
            'make' => 'Land Rover',
            'model' => 'Defender 90',
            'year' => '2022',
            'engine' => '2.0L Ingenium',
        ];

        // Craft system message with vehicle context
        $systemMessage = "You are DiagnosticsAI, an expert automotive diagnostic assistant specializing in vehicle issues. " .
                        "You're currently helping with a {$vehicleData['year']} {$vehicleData['make']} {$vehicleData['model']} " .
                        "with a {$vehicleData['engine']} engine (registration: {$vehicleData['registration']}). " .
                        "Provide helpful, accurate diagnostic information based on the symptoms described. " .
                        "Be concise but thorough. Organize your response with clear sections when appropriate. " .
                        "Be conversational but focus on technical accuracy.";

        Log::info('Preparing OpenAI API request', [
            'system_message_length' => strlen($systemMessage),
            'user_message' => $userMessage
        ]);

        $requestPayload = [
            'model' => config('services.openai.model', 'gpt-3.5-turbo'),
            'messages' => [
                ['role' => 'system', 'content' => $systemMessage],
                ['role' => 'user', 'content' => $userMessage]
            ],
            'temperature' => 0.7,
            'max_tokens' => 800,
        ];
        
        Log::debug('Full OpenAI request payload', $requestPayload);

        // Send request to OpenAI API
        $response = Http::withLogging()->withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.api_key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', $requestPayload);

        Log::info('OpenAI API response', [
            'status' => $response->status(),
            'success' => $response->successful(),
            'headers' => $response->headers()
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            Log::debug('Full OpenAI response', $responseData);
            
            return $responseData['choices'][0]['message']['content'];
        } else {
            Log::error('OpenAI API error response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            throw new \Exception('Failed to get response from OpenAI API: ' . $response->status() . ' - ' . $response->body());
        }
    }

    /**
     * Generate a diagnostic response based on the user's message.
     * This is a simplified demonstration. In a real application,
     * this would integrate with an AI service or language model.
     */
    private function generateLocalDiagnosticResponse(string $message, string $registration): string
    {
        $message = strtolower($message);
        
        // Simple keyword matching for demonstration purposes
        if (str_contains($message, 'engine') && (str_contains($message, 'noise') || str_contains($message, 'knocking'))) {
            return "Engine knocking or noise in your vehicle could be caused by several issues:\n\n" .
                   "1. Low-quality fuel or incorrect octane rating\n" .
                   "2. Carbon deposits in the combustion chamber\n" .
                   "3. Worn engine bearings or other internal components\n" .
                   "4. Timing issues or ignition problems\n" .
                   "5. Faulty fuel injectors\n\n" .
                   "I recommend checking your fuel quality first and considering a fuel system cleaner. If the issue persists, a professional diagnostic would be advisable.";
        }
        
        if (str_contains($message, 'brake') || str_contains($message, 'braking') || str_contains($message, 'stop')) {
            return "Brake issues can be serious safety concerns. Based on your description, possible causes include:\n\n" .
                   "1. Worn brake pads or rotors\n" .
                   "2. Air in the brake lines\n" .
                   "3. Leaking brake fluid\n" .
                   "4. Failing brake calipers\n" .
                   "5. ABS system malfunction\n\n" .
                   "I strongly recommend having your brakes inspected by a qualified technician as soon as possible.";
        }
        
        if (str_contains($message, 'overheat') || str_contains($message, 'temperature') || str_contains($message, 'hot')) {
            return "Overheating issues can lead to serious engine damage. Possible causes include:\n\n" .
                   "1. Low coolant level or coolant leak\n" .
                   "2. Faulty radiator or radiator cap\n" .
                   "3. Malfunctioning thermostat\n" .
                   "4. Water pump failure\n" .
                   "5. Blocked cooling system\n" .
                   "6. Electric fan not working properly\n\n" .
                   "Check your coolant level when the engine is cool and look for any visible leaks. If you notice the temperature gauge rising into the red zone, pull over safely and switch off the engine to prevent damage.";
        }
        
        if (str_contains($message, 'start') || str_contains($message, 'crank') || str_contains($message, 'battery')) {
            return "Starting problems can be frustrating. Based on your description, potential causes include:\n\n" .
                   "1. Weak or dead battery\n" .
                   "2. Faulty starter motor\n" .
                   "3. Alternator issues\n" .
                   "4. Ignition switch problems\n" .
                   "5. Fuel delivery issues\n" .
                   "6. Security system interference\n\n" .
                   "I suggest checking your battery connections first and testing the battery voltage. If it's below 12.4V when the engine is off, it may need charging or replacement.";
        }
        
        // Default response for unrecognized issues
        return "Thank you for describing your issue with your vehicle. Based on the information provided, I recommend the following steps:\n\n" .
               "1. Check if any warning lights are displayed on your dashboard\n" .
               "2. Note when the issue occurs (cold start, after driving, specific conditions)\n" .
               "3. Consider if there have been any recent changes (fuel, maintenance, etc.)\n\n" .
               "For a more accurate diagnosis, could you provide additional details about when the issue occurs and any other symptoms you've noticed?";
    }

    /**
     * Test the OpenAI API connection.
     */
    public function testApiConnection()
    {
        try {
            Log::info('Testing OpenAI API connection');
            
            $apiKey = config('services.openai.api_key');
            $hasKey = !empty($apiKey);
            
            $response = [
                'has_api_key' => $hasKey,
                'api_key_preview' => $hasKey ? substr($apiKey, 0, 3) . '...' . substr($apiKey, -3) : null,
                'model' => config('services.openai.model', 'gpt-3.5-turbo'),
            ];
            
            if ($hasKey) {
                // Test with a simple request
                $testResponse = Http::withLogging()->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post('https://api.openai.com/v1/chat/completions', [
                    'model' => config('services.openai.model', 'gpt-3.5-turbo'),
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => 'Say hello and confirm the connection is working.']
                    ],
                    'max_tokens' => 50
                ]);
                
                if ($testResponse->successful()) {
                    $content = $testResponse->json('choices.0.message.content', 'No content returned');
                    $response['connection_status'] = 'success';
                    $response['test_response'] = $content;
                    Log::info('OpenAI API connection successful', ['content' => $content]);
                } else {
                    $response['connection_status'] = 'error';
                    $response['error'] = $testResponse->body();
                    Log::error('OpenAI API connection test failed', ['response' => $testResponse->body()]);
                }
            } else {
                $response['connection_status'] = 'no_key';
                Log::warning('No OpenAI API key configured for connection test');
            }
            
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Exception during OpenAI API connection test', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'connection_status' => 'exception',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 