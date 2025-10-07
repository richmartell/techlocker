<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\Attributes\On;

class Notes extends Component
{
    public Vehicle $vehicle;
    public $notes = '';
    public $isSaving = false;
    public $lastSaved = null;

    public function mount(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
        $this->notes = $vehicle->notes ?? '';
    }

    public function updatedNotes()
    {
        $this->saveNotes();
    }

    public function saveNotes()
    {
        $this->isSaving = true;

        $this->vehicle->update([
            'notes' => $this->notes,
        ]);

        $this->lastSaved = now()->format('g:i A');
        $this->isSaving = false;

        $this->dispatch('notes-saved');
    }

    public function render()
    {
        return view('livewire.vehicles.notes');
    }
}
