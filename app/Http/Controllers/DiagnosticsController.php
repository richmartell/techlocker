<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\DiagnosticsAiLog;

class DiagnosticsController extends Controller
{
    /**
     * Get vehicle image for a given vehicle
     */
    private function getVehicleImage($registration, $carTypeId)
    {
        try {
            if (!$carTypeId) {
                return null;
            }
            
            $haynesPro = app(\App\Services\HaynesPro::class);
            $vehicleDetails = $haynesPro->getVehicleDetails($carTypeId);
            return $vehicleDetails['image'] ?? null;
        } catch (\Exception $e) {
            Log::warning('Failed to fetch vehicle image', [
                'registration' => $registration,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

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

        // Get vehicle image
        $vehicleImage = $this->getVehicleImage($registration, $vehicle->car_type_id);

        return view('diagnostics-ai', array_merge($vehicleData, ['vehicle' => $vehicle, 'vehicleImage' => $vehicleImage]));
    }

    /**
     * Process a diagnostic message and return an AI response.
     */
    public function processMessage(Request $request)
    {
        $startTime = microtime(true);
        $sessionId = $request->header('X-Session-ID') ?? session()->getId();
        
        $request->validate([
            'message' => 'required|string|max:1000',
            'registration' => 'required|string',
        ]);

        $userMessage = $request->input('message');
        $registration = $request->input('registration');
        
        // Get vehicle data for logging
        $vehicle = \App\Models\Vehicle::with(['make', 'model'])
            ->where('registration', $registration)
            ->first();

        $vehicleData = $vehicle ? [
            'registration' => $vehicle->registration,
            'make' => $vehicle->make?->name ?? 'Unknown',
            'model' => $vehicle->model?->name ?? 'Unknown',
            'year' => $vehicle->year_of_manufacture ?? 'Unknown',
            'engine' => $vehicle->engine_capacity ? $vehicle->engine_capacity . 'cc' : 'Unknown',
        ] : null;
        
        Log::info('Diagnostics request received', [
            'message' => $userMessage,
            'registration' => $registration,
            'session_id' => $sessionId
        ]);
        
        // Initialize log data
        $logData = [
            'user_message' => $userMessage,
            'session_id' => $sessionId,
            'vehicle_registration' => $registration,
            'vehicle_data' => $vehicleData,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];
        
        // Check if we should use OpenAI API
        if (config('services.openai.api_key')) {
            Log::info('Using OpenAI API with key: ' . substr(config('services.openai.api_key'), 0, 3) . '...');
            Log::info('OpenAI model: ' . config('services.openai.model'));
            
            try {
                $response = $this->getOpenAIResponse($userMessage, $registration, $logData, $startTime);
                
                Log::info('OpenAI API response received', [
                    'response_length' => strlen($response),
                    'session_id' => $sessionId
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => $response,
                ]);
            } catch (\Exception $e) {
                Log::error('OpenAI API error: ' . $e->getMessage(), [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'session_id' => $sessionId
                ]);
                
                // Fallback to local response if API fails
                $response = $this->generateLocalDiagnosticResponse($userMessage, $registration);
                $fallbackResponse = $response . "\n\n(Note: This response was generated locally as the AI service was unavailable. Error: " . $e->getMessage() . ")";
                
                // Log the fallback interaction
                $logData['ai_response'] = $fallbackResponse;
                $logData['status'] = 'fallback';
                $logData['error_message'] = $e->getMessage();
                $logData['fallback_reason'] = 'api_error';
                $logData['response_time_ms'] = round((microtime(true) - $startTime) * 1000);
                
                DiagnosticsAiLog::logInteraction($logData);
                
                return response()->json([
                    'success' => true,
                    'message' => $fallbackResponse,
                ]);
            }
        } else {
            Log::info('No OpenAI API key found, using local response generator');
            
            // Use local response generation if no API key is set
            $response = $this->generateLocalDiagnosticResponse($userMessage, $registration);
            
            // Log the local interaction
            $logData['ai_response'] = $response;
            $logData['status'] = 'fallback';
            $logData['fallback_reason'] = 'no_api_key';
            $logData['response_time_ms'] = round((microtime(true) - $startTime) * 1000);
            
            DiagnosticsAiLog::logInteraction($logData);
            
            return response()->json([
                'success' => true,
                'message' => $response,
            ]);
        }
    }

    /**
     * Get a response prioritizing Haynes data over AI.
     */
    private function getOpenAIResponse(string $userMessage, string $registration, array &$logData, float $startTime): string
    {
        // Get vehicle data from database
        $vehicle = \App\Models\Vehicle::with(['make', 'model'])
            ->where('registration', $registration)
            ->first();

        if (!$vehicle) {
            throw new \Exception("Vehicle with registration {$registration} not found");
        }

        $vehicleData = [
            'registration' => $vehicle->registration,
            'make' => $vehicle->make?->name ?? 'Unknown',
            'model' => $vehicle->model?->name ?? 'Unknown',
            'year' => $vehicle->year_of_manufacture ?? 'Unknown',
            'engine' => $vehicle->engine_capacity ? $vehicle->engine_capacity . 'cc' : 'Unknown',
        ];

        // Get Haynes Pro diagnostic data
        $haynesProService = app(\App\Services\HaynesPro::class);
        $haynesProData = $haynesProService->ensureVehicleDataCached($registration);
        
        // STEP 1: Try to answer using only Haynes Pro data first
        if ($haynesProData) {
            $haynesResponse = $this->generateHaynesBasedResponse($userMessage, $vehicleData, $haynesProData);
            
            if ($haynesResponse) {
                Log::info('Response generated using Haynes Pro data only', [
                    'carTypeId' => $haynesProData->car_type_id,
                    'available_sections' => $this->getAvailableDataSections($haynesProData),
                    'response_length' => strlen($haynesResponse)
                ]);
                
                // Update log data for Haynes-only response
                $logData['ai_response'] = $haynesResponse;
                $logData['status'] = 'haynes_primary';
                $logData['data_source'] = 'haynes_only';
                $logData['haynes_car_type_id'] = $haynesProData->car_type_id;
                $logData['haynes_data_available'] = true;
                $logData['haynes_data_sections'] = $this->getAvailableDataSections($haynesProData);
                $logData['haynes_last_fetch'] = $haynesProData->last_comprehensive_fetch;
                $logData['response_time_ms'] = round((microtime(true) - $startTime) * 1000);
                
                DiagnosticsAiLog::logInteraction($logData);
                
                return $haynesResponse;
            }
        }
        
        // STEP 2: Fall back to ChatGPT with Haynes data as context
        Log::info('Falling back to ChatGPT due to insufficient Haynes data', [
            'has_haynes_data' => $haynesProData !== null,
            'reason' => $haynesProData ? 'insufficient_haynes_data' : 'no_haynes_data'
        ]);
        
        return $this->getChatGPTResponseWithHaynesContext($userMessage, $vehicleData, $haynesProData, $logData, $startTime);
    }

    /**
     * Generate response using only Haynes Pro data.
     */
    private function generateHaynesBasedResponse(string $userMessage, array $vehicleData, \App\Models\HaynesProVehicle $haynesProData): ?string
    {
        $userMessageLower = strtolower($userMessage);
        $response = [];
        $dataUsed = [];
        
        // Detect what type of diagnostic query this is
        $isWarningLight = str_contains($userMessageLower, 'light') || str_contains($userMessageLower, 'lamp') || 
                         str_contains($userMessageLower, 'dashboard') || str_contains($userMessageLower, 'indicator');
        
        $isDTC = str_contains($userMessageLower, 'p0') || str_contains($userMessageLower, 'b0') || 
                str_contains($userMessageLower, 'c0') || str_contains($userMessageLower, 'u0') ||
                str_contains($userMessageLower, 'dtc') || str_contains($userMessageLower, 'code');
        
        $isMaintenance = str_contains($userMessageLower, 'service') || str_contains($userMessageLower, 'maintenance') ||
                        str_contains($userMessageLower, 'interval') || str_contains($userMessageLower, 'schedule');
        
        $isLubricant = str_contains($userMessageLower, 'oil') || str_contains($userMessageLower, 'lubricant') ||
                      str_contains($userMessageLower, 'fluid') || str_contains($userMessageLower, 'grease') ||
                      str_contains($userMessageLower, 'engine oil') || str_contains($userMessageLower, 'brake fluid') ||
                      str_contains($userMessageLower, 'coolant') || str_contains($userMessageLower, 'transmission') ||
                      str_contains($userMessageLower, 'differential') || str_contains($userMessageLower, 'gear oil') ||
                      str_contains($userMessageLower, 'power steering') || str_contains($userMessageLower, 'hydraulic');
        
        $isFuse = str_contains($userMessageLower, 'fuse') || str_contains($userMessageLower, 'relay') ||
                 str_contains($userMessageLower, 'electrical') || str_contains($userMessageLower, 'circuit');
        
        $isProcedure = str_contains($userMessageLower, 'test') || str_contains($userMessageLower, 'procedure') ||
                      str_contains($userMessageLower, 'diagnostic') || str_contains($userMessageLower, 'check');

        // Header with vehicle information
        $response[] = "**HAYNES PRO TECHNICAL DATA - {$vehicleData['year']} {$vehicleData['make']} {$vehicleData['model']}**\n";

        // Warning lights section
        if ($isWarningLight && $haynesProData->warning_lights) {
            $response[] = "**WARNING LIGHTS & INDICATORS:**";
            $response[] = $this->formatHaynesArrayData($haynesProData->warning_lights, $userMessage);
            $dataUsed[] = 'Warning Lights';
        }

        // Technical bulletins and recalls for specific issues
        if (($isDTC || $isProcedure) && $haynesProData->technical_bulletins) {
            $bulletins = $this->searchHaynesData($haynesProData->technical_bulletins, $userMessage);
            if (!empty($bulletins)) {
                $response[] = "**TECHNICAL SERVICE BULLETINS:**";
                $response[] = $bulletins;
                $dataUsed[] = 'Technical Bulletins';
            }
        }

        // Test procedures
        if ($isProcedure && $haynesProData->test_procedures) {
            $procedures = $this->searchHaynesData($haynesProData->test_procedures, $userMessage);
            if (!empty($procedures)) {
                $response[] = "**DIAGNOSTIC TEST PROCEDURES:**";
                $response[] = $procedures;
                $dataUsed[] = 'Test Procedures';
            }
        }

        // Fuse locations for electrical issues
        if ($isFuse && $haynesProData->fuse_locations) {
            $response[] = "**FUSE & RELAY LOCATIONS:**";
            $response[] = $this->formatHaynesArrayData($haynesProData->fuse_locations, $userMessage);
            $dataUsed[] = 'Fuse Locations';
        }

        // PIDs for diagnostic scanning
        if (($isDTC || $isProcedure) && $haynesProData->pids) {
            $response[] = "**DIAGNOSTIC PARAMETERS (PIDs):**";
            $response[] = $this->formatHaynesArrayData($haynesProData->pids, $userMessage);
            $dataUsed[] = 'Diagnostic PIDs';
        }

        // Lubricants and fluids information
        if ($isLubricant && $haynesProData->lubricants) {
            $response[] = "**LUBRICANTS & FLUIDS SPECIFICATIONS:**";
            $response[] = $this->formatLubricantData($haynesProData->lubricants, $userMessage);
            $dataUsed[] = 'Lubricants & Fluids';
        }

        // Maintenance information
        if ($isMaintenance && $haynesProData->maintenance_intervals) {
            $response[] = "**MAINTENANCE INTERVALS:**";
            $response[] = $this->formatHaynesArrayData($haynesProData->maintenance_intervals, $userMessage);
            $dataUsed[] = 'Maintenance Intervals';
        }

        // Recalls for safety-related issues
        if ($haynesProData->recalls && (count($haynesProData->recalls) > 0)) {
            $recalls = $this->searchHaynesData($haynesProData->recalls, $userMessage);
            if (!empty($recalls)) {
                $response[] = "**RELEVANT RECALLS:**";
                $response[] = $recalls;
                $dataUsed[] = 'Recalls';
            }
        }

        // Only return a response if we found relevant data
        if (count($dataUsed) >= 1) {
            $response[] = "\n---";
            $response[] = "**DATA SOURCE:** Haynes Pro Technical Database";
            $response[] = "**SECTIONS USED:** " . implode(', ', $dataUsed);
            $response[] = "\n*This response was generated using manufacturer-specific technical data from Haynes Pro. For additional diagnostic guidance beyond this data, please refine your query or request AI analysis.*";
            
            return implode("\n\n", $response);
        }
        
        return null; // Insufficient data found
    }

    /**
     * Get ChatGPT response with Haynes data as context (fallback).
     */
    private function getChatGPTResponseWithHaynesContext(string $userMessage, array $vehicleData, ?\App\Models\HaynesProVehicle $haynesProData, array &$logData, float $startTime): string
    {
        // Start building the system message
        $systemMessage = "You are DiagnosticsAI, a professional automotive diagnostic assistant designed specifically for qualified mechanics and automotive technicians. " .
                        "You're providing technical diagnostic guidance for a {$vehicleData['year']} {$vehicleData['make']} {$vehicleData['model']} " .
                        "with a {$vehicleData['engine']} engine (registration: {$vehicleData['registration']}). " .
                        
                        "Your responses should be:\n" .
                        "- TECHNICAL: Use proper automotive terminology, OEM procedures, and industry-standard diagnostic methods\n" .
                        "- SPECIFIC: Reference exact component locations, connector pinouts, resistance values, and torque specifications when relevant\n" .
                        "- PRACTICAL: Suggest specific diagnostic tools (multimeter, oscilloscope, scan tools), test procedures, and measurement points\n" .
                        "- EFFICIENT: Focus on the most likely causes first, suggest systematic diagnostic approaches to minimize diagnostic time\n" .
                        "- COMPREHENSIVE: Include relevant TSBs, known issues, common failure patterns, and preventive measures\n\n" .
                        
                        "Assume the user has:\n" .
                        "- Professional diagnostic equipment and tools\n" .
                        "- Access to workshop manuals and technical data\n" .
                        "- Understanding of automotive systems, electrical theory, and diagnostic procedures\n" .
                        "- Commercial workshop environment with proper safety equipment\n\n" .
                        
                        "Structure responses with: Diagnostic Steps → Testing Procedures → Expected Values → Common Causes → Repair Recommendations.";

        // Add comprehensive Haynes Pro technical data if available
        if ($haynesProData) {
            $technicalData = $haynesProData->getFormattedDataForAI();
            if (!empty($technicalData)) {
                $systemMessage .= "\n\nYou have access to the following comprehensive technical data for this specific vehicle:\n\n" . $technicalData;
                $systemMessage .= "\n\nLEVERAGE THIS TECHNICAL DATA to provide manufacturer-specific diagnostic guidance:\n" .
                                 "- Reference exact fuse/relay locations, part numbers, and circuit descriptions\n" .
                                 "- Cite specific warning light meanings and associated diagnostic trouble codes\n" .
                                 "- Include relevant TSBs, recalls, and known service issues\n" .
                                 "- Reference OEM maintenance procedures, torque specifications, and service intervals\n" .
                                 "- Suggest vehicle-specific test points, sensor values, and diagnostic parameters\n" .
                                 "- Provide connector pinouts and wire color codes where applicable";
            }

            Log::info('Haynes Pro data included in ChatGPT context', [
                'carTypeId' => $haynesProData->car_type_id,
                'available_sections' => $this->getAvailableDataSections($haynesProData),
                'last_comprehensive_fetch' => $haynesProData->last_comprehensive_fetch
            ]);
        } else {
            Log::info('No Haynes Pro data available for ChatGPT context', [
                'registration' => $vehicleData['registration']
            ]);
        }

        Log::info('Preparing OpenAI API request', [
            'system_message_length' => strlen($systemMessage),
            'user_message' => $userMessage,
            'has_haynes_data' => $haynesProData !== null
        ]);

        $requestPayload = [
            'model' => config('services.openai.model', 'gpt-3.5-turbo'),
            'messages' => [
                ['role' => 'system', 'content' => $systemMessage],
                ['role' => 'user', 'content' => $userMessage]
            ],
            'temperature' => 0.4, // Lower temperature for more focused, deterministic professional responses
            'max_tokens' => 1500, // Increased token limit for detailed technical diagnostic responses
        ];
        
        Log::debug('Full OpenAI request payload (message content truncated)', [
            'model' => $requestPayload['model'],
            'temperature' => $requestPayload['temperature'],
            'max_tokens' => $requestPayload['max_tokens'],
            'system_message_length' => strlen($requestPayload['messages'][0]['content']),
            'user_message' => $requestPayload['messages'][1]['content']
        ]);

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
            $aiResponse = $responseData['choices'][0]['message']['content'];
            
            // Add a note that this is an AI-enhanced response with Haynes data
            $enhancedResponse = $aiResponse . "\n\n---\n**DATA SOURCE:** AI Analysis with Haynes Pro Technical Data\n" .
                              "*This response combines AI diagnostic expertise with manufacturer-specific technical data from Haynes Pro.*";
            
            Log::debug('Full OpenAI response received', [
                'finish_reason' => $responseData['choices'][0]['finish_reason'] ?? 'unknown',
                'response_length' => strlen($aiResponse)
            ]);
            
            // Update log data with successful response information
            $logData['ai_response'] = $enhancedResponse;
            $logData['status'] = 'success';
            $logData['data_source'] = 'ai_with_haynes';
            $logData['ai_model'] = $requestPayload['model'];
            $logData['temperature'] = $requestPayload['temperature'];
            $logData['max_tokens'] = $requestPayload['max_tokens'];
            $logData['system_message'] = $systemMessage; // Will be removed in logInteraction but used for length calculation
            $logData['response_time_ms'] = round((microtime(true) - $startTime) * 1000);
            
            // Add Haynes Pro data information if available
            if ($haynesProData) {
                $logData['haynes_car_type_id'] = $haynesProData->car_type_id;
                $logData['haynes_data_available'] = true;
                $logData['haynes_data_sections'] = $this->getAvailableDataSections($haynesProData);
                $logData['haynes_last_fetch'] = $haynesProData->last_comprehensive_fetch;
            } else {
                $logData['haynes_data_available'] = false;
            }
            
            // Log the successful interaction
            DiagnosticsAiLog::logInteraction($logData);
            
            return $enhancedResponse;
        } else {
            Log::error('OpenAI API error response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            throw new \Exception('Failed to get response from OpenAI API: ' . $response->status() . ' - ' . $response->body());
        }
    }

    /**
     * Format Haynes array data for display.
     */
    private function formatHaynesArrayData(array $data, string $userQuery): string
    {
        if (empty($data)) {
            return "No relevant data found in Haynes Pro database.";
        }

        $formatted = [];
        $queryLower = strtolower($userQuery);
        
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                // Check if this item is relevant to the user's query
                $itemText = strtolower(json_encode($item));
                $isRelevant = false;
                
                // Basic relevance checking
                foreach (explode(' ', $queryLower) as $word) {
                    if (strlen($word) > 3 && str_contains($itemText, $word)) {
                        $isRelevant = true;
                        break;
                    }
                }
                
                if ($isRelevant || count($data) <= 10) { // Show all if small dataset
                    if (isset($item['name']) || isset($item['description'])) {
                        $name = $item['name'] ?? $item['description'] ?? 'Item';
                        $desc = $item['description'] ?? $item['details'] ?? $item['procedure'] ?? '';
                        $partNumber = isset($item['part_number']) ? " (Part: {$item['part_number']})" : '';
                        $location = isset($item['location']) ? " - Location: {$item['location']}" : '';
                        
                        $formatted[] = "• **{$name}**{$partNumber}{$location}";
                        if ($desc && $desc !== $name) {
                            $formatted[] = "  {$desc}";
                        }
                    } else {
                        $formatted[] = "• " . json_encode($item);
                    }
                }
            } else {
                $formatted[] = "• {$key}: {$item}";
            }
        }
        
        if (empty($formatted)) {
            return "No data specifically relevant to your query found in this section.";
        }
        
        return implode("\n", array_slice($formatted, 0, 15)); // Limit to 15 items
    }

    /**
     * Search Haynes data for relevant content.
     */
    private function searchHaynesData(array $data, string $userQuery): string
    {
        if (empty($data)) {
            return "";
        }

        $relevant = [];
        $queryLower = strtolower($userQuery);
        $keywords = array_filter(explode(' ', $queryLower), fn($word) => strlen($word) > 3);
        
        foreach ($data as $item) {
            if (is_array($item)) {
                $itemText = strtolower(json_encode($item));
                $relevanceScore = 0;
                
                foreach ($keywords as $keyword) {
                    if (str_contains($itemText, $keyword)) {
                        $relevanceScore++;
                    }
                }
                
                if ($relevanceScore > 0) {
                    $relevant[] = ['item' => $item, 'score' => $relevanceScore];
                }
            }
        }
        
        // Sort by relevance score
        usort($relevant, fn($a, $b) => $b['score'] - $a['score']);
        
        $formatted = [];
        foreach (array_slice($relevant, 0, 5) as $entry) { // Top 5 most relevant
            $item = $entry['item'];
            if (isset($item['title']) || isset($item['description']) || isset($item['summary'])) {
                $title = $item['title'] ?? $item['description'] ?? $item['summary'] ?? 'Technical Information';
                $content = $item['content'] ?? $item['description'] ?? $item['details'] ?? '';
                $reference = isset($item['bulletin_number']) ? " (Ref: {$item['bulletin_number']})" : '';
                
                $formatted[] = "• **{$title}**{$reference}";
                if ($content && $content !== $title) {
                    $formatted[] = "  " . substr($content, 0, 300) . (strlen($content) > 300 ? '...' : '');
                }
            }
        }
        
        return implode("\n\n", $formatted);
    }

    /**
     * Format lubricant data specifically for the complex Haynes Pro lubricant structure.
     */
    private function formatLubricantData(array $lubricantData, string $userQuery): string
    {
        if (empty($lubricantData)) {
            return "No lubricant data found in Haynes Pro database.";
        }

        $formatted = [];
        $queryLower = strtolower($userQuery);
        
        foreach ($lubricantData as $system) {
            if (!is_array($system) || !isset($system['name'])) {
                continue;
            }
            
            $systemName = $system['name'];
            $systemLower = strtolower($systemName);
            
            // Check if this system is relevant to the user's query
            $isRelevant = false;
            $keywords = ['engine', 'oil', 'brake', 'transmission', 'coolant', 'differential', 'steering', 'transfer', 'gear'];
            
            foreach ($keywords as $keyword) {
                if (str_contains($queryLower, $keyword) && str_contains($systemLower, $keyword)) {
                    $isRelevant = true;
                    break;
                }
            }
            
            // Also include if query is general (like "lubricants")
            if (str_contains($queryLower, 'lubricant') || str_contains($queryLower, 'fluid') || str_contains($queryLower, 'specification')) {
                $isRelevant = true;
            }
            
            if (!$isRelevant && count($lubricantData) > 5) {
                continue; // Skip irrelevant systems if there are many
            }
            
            $systemInfo = "### {$systemName}";
            
            // Add capacity information from smartLinks
            if (isset($system['smartLinks']) && is_array($system['smartLinks'])) {
                foreach ($system['smartLinks'] as $link) {
                    if (isset($link['text']) && is_array($link['text']) && count($link['text']) >= 2) {
                        $description = $link['text'][0];
                        $capacity = $link['text'][1];
                        $unit = $link['text'][2] ?? '';
                        if (!empty($capacity) && $capacity !== '') {
                            $systemInfo .= "\n**Capacity:** {$description}: {$capacity} {$unit}";
                        }
                    }
                }
            }
            
            // Add lubricant specifications
            if (isset($system['lubricantItems']) && is_array($system['lubricantItems'])) {
                foreach ($system['lubricantItems'] as $lubricant) {
                    if (!is_array($lubricant)) continue;
                    
                    $name = $lubricant['name'] ?? 'Lubricant';
                    $quality = $lubricant['quality'] ?? '';
                    $viscosity = $lubricant['viscosity'] ?? '';
                    $temperature = $lubricant['temperature'] ?? '';
                    
                    $lubricantInfo = "**{$name}:**";
                    if ($quality) $lubricantInfo .= "\n  - Quality: {$quality}";
                    if ($viscosity) $lubricantInfo .= "\n  - Viscosity: {$viscosity}";
                    if ($temperature) $lubricantInfo .= "\n  - Temperature Range: {$temperature}";
                    
                    $systemInfo .= "\n\n{$lubricantInfo}";
                }
            }
            
            $formatted[] = $systemInfo;
        }
        
        if (empty($formatted)) {
            return "No lubricant data specifically relevant to your query found.";
        }
        
        return implode("\n\n", array_slice($formatted, 0, 8)); // Limit to 8 systems to avoid overwhelming response
    }

    /**
     * Get a list of available data sections for logging purposes.
     */
    private function getAvailableDataSections(\App\Models\HaynesProVehicle $haynesProData): array
    {
        $sections = [];
        
        $fields = [
            'vehicle_identification_data' => 'Vehicle ID',
            'warning_lights' => 'Warning Lights',
            'technical_bulletins' => 'Technical Bulletins',
            'recalls' => 'Recalls',
            'maintenance_systems' => 'Maintenance Systems',
            'maintenance_intervals' => 'Maintenance Intervals',
            'engine_location' => 'Engine Location',
            'fuse_locations' => 'Fuse Locations',
            'test_procedures' => 'Test Procedures',
            'pids' => 'Diagnostic PIDs',
            'lubricants' => 'Lubricants',
            'timing_belt_intervals' => 'Timing Belt',
            'wear_parts_intervals' => 'Wear Parts',
            'available_subjects' => 'Available Systems'
        ];

        foreach ($fields as $field => $label) {
            if (!empty($haynesProData->$field)) {
                $sections[] = $label;
            }
        }

        return $sections;
    }

    /**
     * Show diagnostics AI logs for debugging (admin only).
     */
    public function showLogs(Request $request)
    {
        // Simple authentication check - you might want to use proper middleware
        if (!config('app.debug') && !auth()->check()) {
            abort(403, 'Access denied');
        }

        $query = DiagnosticsAiLog::query()->orderBy('created_at', 'desc');

        // Apply filters from request
        if ($vehicle = $request->get('vehicle')) {
            $query->forVehicle($vehicle);
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($request->get('recent')) {
            $query->recent();
        }

        if ($request->get('errors')) {
            $query->withErrors();
        }

        $logs = $query->paginate(20);
        $stats = DiagnosticsAiLog::getPerformanceMetrics();

        return view('diagnostics-logs', compact('logs', 'stats'));
    }

    /**
     * Generate a diagnostic response based on the user's message.
     * This is a simplified demonstration. In a real application,
     * this would integrate with an AI service or language model.
     */
    private function generateLocalDiagnosticResponse(string $message, string $registration): string
    {
        $message = strtolower($message);
        
        // Professional diagnostic responses for mechanics
        if (str_contains($message, 'engine') && (str_contains($message, 'noise') || str_contains($message, 'knocking'))) {
            return "**DIAGNOSTIC PROTOCOL - Engine Knock/Noise Analysis:**\n\n" .
                   "**Primary Tests:**\n" .
                   "• Listen with stethoscope at specific locations: main bearings, rod bearings, wrist pins\n" .
                   "• Check fuel octane rating and perform fuel sample analysis\n" .
                   "• Scope ignition timing with timing light - verify advance curve\n" .
                   "• Test cylinder compression and leakdown\n\n" .
                   "**Probable Causes by Sound Characteristics:**\n" .
                   "• Deep knock at load: Main bearing wear, check oil pressure\n" .
                   "• Light ping under acceleration: Carbon deposits, check EGR function\n" .
                   "• Metallic rattle: Rod bearing clearance, check crankshaft journals\n" .
                   "• High-frequency tick: Valve train, check cam timing and lifter operation\n\n" .
                   "**Diagnostic Tools Required:** Stethoscope, timing light, compression tester, oil pressure gauge, oscilloscope for ignition analysis";
        }
        
        if (str_contains($message, 'brake') || str_contains($message, 'braking') || str_contains($message, 'stop')) {
            return "**BRAKE SYSTEM DIAGNOSTIC PROTOCOL:**\n\n" .
                   "**Visual Inspection:**\n" .
                   "• Measure pad thickness (minimum spec varies by vehicle, typically 3-4mm)\n" .
                   "• Check rotor thickness with micrometer, compare to minimum specification\n" .
                   "• Inspect brake fluid level and color (DOT 3/4 should be clear/amber)\n" .
                   "• Check for fluid leaks at calipers, lines, and master cylinder\n\n" .
                   "**Performance Testing:**\n" .
                   "• Pedal feel test: Note travel, firmness, and fade characteristics\n" .
                   "• Pressure test brake system (typically 50-60 bar working pressure)\n" .
                   "• ABS self-test via scan tool, check for stored DTCs\n" .
                   "• Road test: Check for pull, vibration, or noise under braking\n\n" .
                   "**Common Failure Points:**\n" .
                   "• Caliper sticking: Check slide pin lubrication and rubber boot condition\n" .
                   "• Master cylinder internal leak: Perform bypass test\n" .
                   "• ABS modulator valve malfunction: Check wheel speed sensor signals";
        }
        
        if (str_contains($message, 'overheat') || str_contains($message, 'temperature') || str_contains($message, 'hot')) {
            return "**COOLING SYSTEM DIAGNOSTIC PROCEDURE:**\n\n" .
                   "**Pressure Testing:**\n" .
                   "• Pressure test cooling system to specified pressure (typically 1.1-1.4 bar)\n" .
                   "• Test radiator cap operation and pressure relief valve\n" .
                   "• Check for external leaks at water pump weep hole, hoses, radiator\n\n" .
                   "**Thermostat Testing:**\n" .
                   "• Monitor coolant temperature with infrared gun or scan tool\n" .
                   "• Verify opening temperature (typically 82-88°C depending on specification)\n" .
                   "• Check for proper coolant flow after thermostat opens\n\n" .
                   "**Water Pump Assessment:**\n" .
                   "• Check for bearing play and shaft seal leakage\n" .
                   "• Verify impeller condition (no cavitation or corrosion)\n" .
                   "• Test coolant flow rate and circulation\n\n" .
                   "**Fan Operation:**\n" .
                   "• Test fan motor amperage draw and compare to specification\n" .
                   "• Check temperature switch operation and ECM fan control signals\n" .
                   "• Verify fan shroud and blade condition for optimal airflow";
        }
        
        if (str_contains($message, 'start') || str_contains($message, 'crank') || str_contains($message, 'battery')) {
            return "**NO-START DIAGNOSTIC TREE:**\n\n" .
                   "**Battery/Charging System:**\n" .
                   "• Test battery: 12.6V static, 10.5V minimum under 300A load test\n" .
                   "• Check specific gravity (1.265 fully charged) or conductance test\n" .
                   "• Measure voltage drop on positive and negative cables (<0.5V total)\n\n" .
                   "**Starter Circuit Analysis:**\n" .
                   "• Verify starter draw (typically 150-300A depending on engine size)\n" .
                   "• Test starter solenoid engagement and hold-in windings\n" .
                   "• Check ignition switch and neutral safety switch operation\n\n" .
                   "**Fuel System Verification:**\n" .
                   "• Test fuel pressure at rail (specification varies by system)\n" .
                   "• Check fuel pump relay and fuse, verify pump operation\n" .
                   "• Scan for fuel pump control module DTCs\n\n" .
                   "**Ignition System:**\n" .
                   "• Test for spark at plugs using inline spark tester\n" .
                   "• Check crankshaft and camshaft position sensor signals\n" .
                   "• Verify ignition timing and coil primary/secondary circuits";
        }
        
        // Default professional diagnostic response
        return "**SYSTEMATIC DIAGNOSTIC APPROACH:**\n\n" .
               "**Data Collection Phase:**\n" .
               "• Retrieve all stored DTCs using appropriate scan tool\n" .
               "• Document freeze frame data and failure conditions\n" .
               "• Note symptom frequency, duration, and environmental factors\n\n" .
               "**Initial Assessment:**\n" .
               "• Verify customer concern through road test or static test\n" .
               "• Check for TSBs related to symptoms or DTCs\n" .
               "• Review vehicle history and recent service records\n\n" .
               "**Next Steps:**\n" .
               "• Perform base electrical tests (battery, charging system)\n" .
               "• Check fluid levels and condition\n" .
               "• Use systematic approach based on specific symptom category\n\n" .
               "**Additional Information Needed:**\n" .
               "Please specify: Exact symptom onset conditions, any DTCs present, recent maintenance performed, and environmental factors when issue occurs.";
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