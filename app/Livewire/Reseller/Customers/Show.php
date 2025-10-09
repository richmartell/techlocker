<?php

namespace App\Livewire\Reseller\Customers;

use App\Models\Account;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public Account $account;
    public $selectedPlanId = null;
    public $customerPrice = null;
    public $showChangePlanModal = false;
    public $showDeleteModal = false;

    public function mount(Account $account)
    {
        // Verify this account belongs to the current reseller
        if ($account->reseller_id !== Auth::guard('reseller')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->account = $account;
    }

    public function toggleAccountAccess()
    {
        // Verify ownership
        if ($this->account->reseller_id !== Auth::guard('reseller')->id()) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $this->account->update([
            'is_active' => !$this->account->is_active,
        ]);

        $status = $this->account->is_active ? 'enabled' : 'disabled';
        session()->flash('success', "Account access has been {$status}.");
        
        // Refresh the account
        $this->account->refresh();
    }

    public function openChangePlanModal()
    {
        $this->selectedPlanId = $this->account->plan_id;
        $this->customerPrice = $this->account->subscription_price;
        $this->showChangePlanModal = true;
    }

    public function changePlan()
    {
        $this->validate([
            'selectedPlanId' => 'required|exists:plans,id',
            'customerPrice' => 'required|numeric|min:0',
        ]);

        // Verify ownership
        if ($this->account->reseller_id !== Auth::guard('reseller')->id()) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $updateData = [
            'plan_id' => $this->selectedPlanId,
            'subscription_price' => $this->customerPrice,
        ];

        // If changing from trial to active, set subscription date
        if ($this->account->status === 'trial' || $this->account->status === 'trial_expired') {
            $updateData['status'] = 'active';
            $updateData['subscribed_at'] = now();
        }

        $this->account->update($updateData);

        session()->flash('success', 'Plan has been updated successfully.');
        
        $this->reset(['showChangePlanModal', 'selectedPlanId', 'customerPrice']);
        $this->account->refresh();
    }

    public function deleteAccount()
    {
        // Verify ownership
        if ($this->account->reseller_id !== Auth::guard('reseller')->id()) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $accountName = $this->account->company_name;
        $this->account->delete();

        session()->flash('success', "Account '{$accountName}' has been deleted.");
        
        return redirect()->route('reseller.customers');
    }

    #[Layout('components.layouts.reseller')]
    public function render()
    {
        $reseller = Auth::guard('reseller')->user();
        $plans = Plan::where('is_active', true)->get();

        return view('livewire.reseller.customers.show', [
            'plans' => $plans,
            'reseller' => $reseller,
        ]);
    }
}
