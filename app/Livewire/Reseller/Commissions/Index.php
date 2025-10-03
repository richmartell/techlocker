<?php

namespace App\Livewire\Reseller\Commissions;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $statusFilter = '';

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function getCommissionsProperty()
    {
        $reseller = Auth::guard('reseller')->user();
        
        return $reseller->commissions()
            ->with('account')
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('earned_at', 'desc')
            ->paginate(20);
    }

    #[Layout('components.layouts.reseller')]
    public function render()
    {
        return view('livewire.reseller.commissions.index');
    }
}
