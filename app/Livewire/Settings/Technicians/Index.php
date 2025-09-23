<?php

namespace App\Livewire\Settings\Technicians;

use App\Models\Technician;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    public string $search = '';

    public function updatingSearch() { $this->resetPage(); }

    public function toggleActive(Technician $technician)
    {
        $this->authorize('update', $technician);
        $technician->update(['active' => !$technician->active]);
    }

    public function getTechniciansProperty()
    {
        $q = Technician::query();
        if ($this->search) {
            $term = '%' . trim($this->search) . '%';
            $q->where(function ($sub) use ($term) {
                $sub->where('first_name', 'like', $term)
                   ->orWhere('last_name', 'like', $term)
                   ->orWhere('email', 'like', $term)
                   ->orWhere('phone', 'like', $term);
            });
        }
        return $q->orderBy('last_name')->orderBy('first_name')->paginate(25);
    }

    public function render()
    {
        return view('livewire.settings.technicians.index', [
            'technicians' => $this->technicians,
        ])->layout('components.layouts.app', ['title' => 'Technicians']);
    }
}
