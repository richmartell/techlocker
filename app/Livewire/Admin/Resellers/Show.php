<?php

namespace App\Livewire\Admin\Resellers;

use App\Models\Reseller;
use App\Models\Plan;
use App\Models\ResellerPlanPrice;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public Reseller $reseller;
    public $fallbackDiscount;
    public $planPrices = [];
    public $showPricingModal = false;

    public function mount(Reseller $reseller)
    {
        $this->reseller = $reseller->load([
            'accounts.plan',
            'accounts.users',
            'commissions.account',
            'planPrices'
        ]);

        $this->fallbackDiscount = $reseller->fallback_discount_percentage;
        
        // Load existing plan prices
        foreach (Plan::where('is_active', true)->get() as $plan) {
            $customPrice = $reseller->planPrices()->where('plan_id', $plan->id)->first();
            $this->planPrices[$plan->id] = $customPrice ? $customPrice->price : null;
        }
    }

    public function toggleStatus()
    {
        $this->reseller->update(['is_active' => !$this->reseller->is_active]);
        $this->reseller->refresh();
        
        session()->flash('success', 'Reseller status updated successfully.');
    }

    public function savePricing()
    {
        $this->validate([
            'fallbackDiscount' => 'nullable|numeric|min:0|max:100',
            'planPrices.*' => 'nullable|numeric|min:0',
        ]);

        // Update fallback discount
        $this->reseller->update([
            'fallback_discount_percentage' => $this->fallbackDiscount ?? 0
        ]);

        // Update plan prices
        foreach ($this->planPrices as $planId => $price) {
            if ($price !== null && $price !== '') {
                ResellerPlanPrice::updateOrCreate(
                    [
                        'reseller_id' => $this->reseller->id,
                        'plan_id' => $planId,
                    ],
                    [
                        'price' => $price
                    ]
                );
            } else {
                // Remove custom pricing if cleared
                ResellerPlanPrice::where('reseller_id', $this->reseller->id)
                    ->where('plan_id', $planId)
                    ->delete();
            }
        }

        $this->reseller->refresh();
        $this->reseller->load('planPrices');
        
        session()->flash('success', 'Pricing updated successfully.');
        $this->showPricingModal = false;
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        $plans = Plan::where('is_active', true)->get();
        
        return view('livewire.admin.resellers.show', [
            'plans' => $plans
        ]);
    }
}
