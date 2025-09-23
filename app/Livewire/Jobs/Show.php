<?php

namespace App\Livewire\Jobs;

use App\Models\VehicleJob;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public VehicleJob $job;

    public function mount(VehicleJob $job)
    {
        $this->authorize('view', $job);
        $this->job = $job->load(['vehicle', 'technicians']);
    }

    public function render()
    {
        return view('livewire.jobs.show')->layout('components.layouts.app', [
            'title' => 'Job ' . $this->job->job_number,
        ]);
    }
}
