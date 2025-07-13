<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\HaynesPro;
use Illuminate\Support\Facades\Log;
use Exception;

class HaynesApiStatus extends Component
{
    public bool $showModal = false;
    public array $statusChecks = [];
    public bool $isRunningChecks = false;

    public function mount()
    {
        $this->initializeStatusChecks();
    }

    public function showStatus()
    {
        $this->showModal = true;
        $this->runStatusChecks();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->initializeStatusChecks();
    }

    public function refreshStatus()
    {
        $this->initializeStatusChecks();
        $this->runStatusChecks();
    }

    private function initializeStatusChecks()
    {
        $this->statusChecks = [
            'config' => [
                'name' => 'Configuration Check',
                'status' => 'pending',
                'message' => '',
                'details' => []
            ],
            'authentication' => [
                'name' => 'Authentication (VRID)',
                'status' => 'pending',
                'message' => '',
                'details' => []
            ],
            'vehicle_makes' => [
                'name' => 'Vehicle Makes Retrieval',
                'status' => 'pending',
                'message' => '',
                'details' => []
            ],
            'general_info' => [
                'name' => 'General Information Access',
                'status' => 'pending',
                'message' => '',
                'details' => []
            ]
        ];
    }

    public function runStatusChecks()
    {
        $this->isRunningChecks = true;
        
        // Check 1: Configuration
        $this->checkConfiguration();
        $this->dispatch('status-updated');
        
        // Check 2: Authentication
        $this->checkAuthentication();
        $this->dispatch('status-updated');
        
        // Check 3: Vehicle Makes
        $this->checkVehicleMakes();
        $this->dispatch('status-updated');
        
        // Check 4: General Information
        $this->checkGeneralInformation();
        $this->dispatch('status-updated');
        
        $this->isRunningChecks = false;
    }

    private function checkConfiguration()
    {
        try {
            $username = config('services.haynespro.distributor_username');
            $password = config('services.haynespro.distributor_password');
            
            $details = [
                'Username configured' => !empty($username) ? 'Yes' : 'No',
                'Password configured' => !empty($password) ? 'Yes' : 'No',
                'Base URL' => 'https://www.haynespro-services.com/workshopServices3/rest/jsonendpoint'
            ];
            
            if (!empty($username) && !empty($password)) {
                $this->statusChecks['config']['status'] = 'success';
                $this->statusChecks['config']['message'] = 'Configuration valid';
            } else {
                $this->statusChecks['config']['status'] = 'failed';
                $this->statusChecks['config']['message'] = 'Missing credentials in configuration';
            }
            
            $this->statusChecks['config']['details'] = $details;
            
        } catch (Exception $e) {
            $this->statusChecks['config']['status'] = 'failed';
            $this->statusChecks['config']['message'] = 'Configuration error: ' . $e->getMessage();
            $this->statusChecks['config']['details'] = ['Error' => $e->getMessage()];
        }
    }

    private function checkAuthentication()
    {
        try {
            $haynesPro = app(HaynesPro::class);
            $vrid = $haynesPro->vrid();
            
            $this->statusChecks['authentication']['status'] = 'success';
            $this->statusChecks['authentication']['message'] = 'Authentication successful';
            $this->statusChecks['authentication']['details'] = [
                'VRID obtained' => 'Yes',
                'VRID format' => 'Valid (' . strlen($vrid) . ' characters)',
                'Cached' => 'Yes (8 hours)'
            ];
            
        } catch (Exception $e) {
            $this->statusChecks['authentication']['status'] = 'failed';
            $this->statusChecks['authentication']['message'] = 'Authentication failed';
            $this->statusChecks['authentication']['details'] = [
                'Error' => $e->getMessage(),
                'Check credentials' => 'Verify HAYNESPRO_DISTRIBUTOR_USERNAME and HAYNESPRO_DISTRIBUTOR_PASSWORD'
            ];
            
            Log::error('Haynes API authentication failed', ['error' => $e->getMessage()]);
        }
    }

    private function checkVehicleMakes()
    {
        try {
            $haynesPro = app(HaynesPro::class);
            $makes = $haynesPro->getVehicleMakes();
            
            $makeCount = count($makes);
            
            if ($makeCount > 0) {
                $this->statusChecks['vehicle_makes']['status'] = 'success';
                $this->statusChecks['vehicle_makes']['message'] = 'Vehicle makes retrieved successfully';
                $this->statusChecks['vehicle_makes']['details'] = [
                    'Makes found' => $makeCount,
                    'Sample makes' => implode(', ', array_slice($makes, 0, 5)),
                    'API endpoint' => 'getIdentificationTreeV2'
                ];
            } else {
                $this->statusChecks['vehicle_makes']['status'] = 'failed';
                $this->statusChecks['vehicle_makes']['message'] = 'No vehicle makes returned';
                $this->statusChecks['vehicle_makes']['details'] = [
                    'Makes found' => 0,
                    'Possible issue' => 'API returned empty result'
                ];
            }
            
        } catch (Exception $e) {
            $this->statusChecks['vehicle_makes']['status'] = 'failed';
            $this->statusChecks['vehicle_makes']['message'] = 'Failed to retrieve vehicle makes';
            $this->statusChecks['vehicle_makes']['details'] = [
                'Error' => $e->getMessage(),
                'API endpoint' => 'getIdentificationTreeV2',
                'Status' => 'Connection or data retrieval failed'
            ];
            
            Log::error('Haynes API vehicle makes failed', ['error' => $e->getMessage()]);
        }
    }

    private function checkGeneralInformation()
    {
        try {
            $haynesPro = app(HaynesPro::class);
            $generalInfo = $haynesPro->getGeneralInformationLinks();
            
            if (!empty($generalInfo)) {
                $this->statusChecks['general_info']['status'] = 'success';
                $this->statusChecks['general_info']['message'] = 'General information access working';
                $this->statusChecks['general_info']['details'] = [
                    'Response received' => 'Yes',
                    'Data type' => gettype($generalInfo),
                    'API endpoint' => 'getGeneralInformationLinks'
                ];
            } else {
                $this->statusChecks['general_info']['status'] = 'failed';
                $this->statusChecks['general_info']['message'] = 'No general information returned';
                $this->statusChecks['general_info']['details'] = [
                    'Response received' => 'Empty',
                    'API endpoint' => 'getGeneralInformationLinks'
                ];
            }
            
        } catch (Exception $e) {
            $this->statusChecks['general_info']['status'] = 'failed';
            $this->statusChecks['general_info']['message'] = 'Failed to retrieve general information';
            $this->statusChecks['general_info']['details'] = [
                'Error' => $e->getMessage(),
                'API endpoint' => 'getGeneralInformationLinks',
                'Status' => 'Connection or data retrieval failed'
            ];
            
            Log::error('Haynes API general info failed', ['error' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.haynes-api-status');
    }
}
