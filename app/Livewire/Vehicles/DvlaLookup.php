<?php

namespace App\Livewire\Vehicles;

use App\Services\DVLA;
use App\Services\MOT;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class DvlaLookup extends Component
{
    #[Rule('required|string|max:8')]
    public $registration = '';

    public $vehicleData = null;
    public $motHistory = null;
    public $error = null;
    public $loading = false;

    public function lookup()
    {
        $this->validate();
        
        $this->loading = true;
        $this->error = null;
        $this->vehicleData = null;
        $this->motHistory = null;

        try {
            // Clean up registration (remove spaces, convert to uppercase)
            $cleanReg = strtoupper(str_replace(' ', '', $this->registration));

            // Get DVLA vehicle data
            try {
                $dvlaService = app(DVLA::class);
                $this->vehicleData = $dvlaService->getVehicleDetails($cleanReg);
            } catch (\Exception $e) {
                $this->error = 'DVLA API Error: ' . $e->getMessage();
            }

            // Get MOT history
            try {
                $motService = app(MOT::class);
                $motData = $motService->getMOTHistory($cleanReg);
                
                if (isset($motData['error'])) {
                    // MOT data not available, but continue showing DVLA data
                    $this->motHistory = null;
                } else {
                    $this->motHistory = $motData;
                }
            } catch (\Exception $e) {
                // MOT lookup failed, but continue showing DVLA data
                \Log::warning('MOT lookup failed', ['error' => $e->getMessage()]);
            }

        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        } finally {
            $this->loading = false;
        }
    }

    public function clear()
    {
        $this->reset(['registration', 'vehicleData', 'motHistory', 'error']);
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.vehicles.dvla-lookup');
    }
}
