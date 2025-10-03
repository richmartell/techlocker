<?php

namespace App\Livewire\Reseller;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    public function getStatsProperty()
    {
        $reseller = Auth::guard('reseller')->user();
        
        return [
            'trials_created' => $reseller->trials_created,
            'trials_converted' => $reseller->trials_converted,
            'conversion_rate' => $reseller->trials_created > 0 
                ? round(($reseller->trials_converted / $reseller->trials_created) * 100, 1) 
                : 0,
            'total_earned' => $reseller->total_commission_earned,
            'total_paid' => $reseller->total_commission_paid,
            'pending' => $reseller->pending_commission,
        ];
    }

    #[Layout('components.layouts.reseller')]
    public function render()
    {
        return view('livewire.reseller.dashboard');
    }
}
