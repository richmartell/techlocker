<?php

namespace App\Livewire\Settings\Technicians;

use App\Models\Technician;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public Technician $technician;

    public function mount(Technician $technician)
    {
        $this->authorize('view', $technician);
        $this->technician = $technician->load(['jobs' => function ($query) {
            $query->with('vehicle')->latest('start_at');
        }]);
    }

    public function toggleActive()
    {
        $this->authorize('update', $this->technician);
        $this->technician->update(['active' => !$this->technician->active]);
        $this->technician->refresh();
    }

    public function render()
    {
        return view('livewire.settings.technicians.show')
            ->layout('components.layouts.app', ['title' => $this->technician->full_name]);
    }
}