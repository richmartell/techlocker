<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class ApiSettingsController extends Controller
{
    /**
     * Show the API settings page.
     */
    public function show(): View
    {
        return view('settings.api-settings');
    }

    /**
     * Save the API settings.
     */
    public function save(Request $request)
    {
        $validated = $request->validate([
            'openai_api_key' => 'nullable|string|max:255',
            'openai_model' => 'nullable|string|in:gpt-3.5-turbo,gpt-4,gpt-4-turbo',
            'openai_organization' => 'nullable|string|max:255',
        ]);

        // Update the .env file
        $this->updateEnvironmentFile('OPENAI_API_KEY', $validated['openai_api_key'] ?? '');
        $this->updateEnvironmentFile('OPENAI_MODEL', $validated['openai_model'] ?? 'gpt-3.5-turbo');
        
        if (isset($validated['openai_organization']) && !empty($validated['openai_organization'])) {
            $this->updateEnvironmentFile('OPENAI_ORGANIZATION', $validated['openai_organization']);
        } else {
            $this->removeEnvironmentVariable('OPENAI_ORGANIZATION');
        }

        // Clear config cache to apply changes
        Artisan::call('config:clear');

        return redirect()->route('settings.api')->with('api_settings_saved', 'API settings have been saved successfully.');
    }

    /**
     * Update an environment variable in the .env file.
     */
    private function updateEnvironmentFile(string $key, string $value): void
    {
        $path = app()->environmentFilePath();
        $content = file_get_contents($path);

        // Escape any quotes in the value
        $value = str_replace('"', '\"', $value);

        // If the key exists, replace its value
        if (preg_match("/^{$key}=/m", $content)) {
            $content = preg_replace("/^{$key}=.*/m", "{$key}=\"{$value}\"", $content);
        } else {
            // Otherwise, add the key-value pair at the end of the file
            $content .= PHP_EOL . "{$key}=\"{$value}\"";
        }

        file_put_contents($path, $content);
    }

    /**
     * Remove an environment variable from the .env file.
     */
    private function removeEnvironmentVariable(string $key): void
    {
        $path = app()->environmentFilePath();
        $content = file_get_contents($path);

        // If the key exists, remove the line
        if (preg_match("/^{$key}=/m", $content)) {
            $content = preg_replace("/^{$key}=.*\n/m", '', $content);
            file_put_contents($path, $content);
        }
    }
} 