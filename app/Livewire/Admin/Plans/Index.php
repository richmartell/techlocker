<?php

namespace App\Livewire\Admin\Plans;

use App\Models\Plan;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public function toggleStatus($planId)
    {
        $plan = Plan::findOrFail($planId);
        $plan->update(['is_active' => !$plan->is_active]);
        
        $this->dispatch('plan-updated');
    }

    public function getPlansProperty()
    {
        return Plan::withCount('accounts')->get();
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.plans.index');
    }
}
