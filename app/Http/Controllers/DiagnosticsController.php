<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DiagnosticsController extends Controller
{
    /**
     * Show the diagnostics page for a specific vehicle.
     */
    public function show(string $registration): View
    {
        // In a real application, this would fetch the vehicle data from a database
        // For now, we'll use sample data
        $vehicleData = [
            'registration' => $registration,
            'make' => 'Land Rover',
            'model' => 'Defender 90',
            'year' => '2022',
            'engine' => '2.0L Ingenium',
        ];

        return view('diagnostics-ai', $vehicleData);
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

        // In a real application, this would call an AI service or API
        // For demonstration, we'll use a simple response system

        $response = $this->generateDiagnosticResponse($userMessage, $registration);

        return response()->json([
            'success' => true,
            'message' => $response,
        ]);
    }

    /**
     * Generate a diagnostic response based on the user's message.
     * This is a simplified demonstration. In a real application,
     * this would integrate with an AI service or language model.
     */
    private function generateDiagnosticResponse(string $message, string $registration): string
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
} 