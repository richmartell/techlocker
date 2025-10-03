<?php

namespace App\Livewire\Admin\Resellers;

use App\Models\Reseller;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public Reseller $reseller;

    public function mount(Reseller $reseller)
    {
        $this->reseller = $reseller->load([
            'accounts.plan',
            'accounts.users',
            'commissions.account'
        ]);
    }

    public function toggleStatus()
    {
        $this->reseller->update(['is_active' => !$this->reseller->is_active]);
        $this->reseller->refresh();
        
        session()->flash('success', 'Reseller status updated successfully.');
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.resellers.show');
    }
}
