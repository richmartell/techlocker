<?php

namespace App\Livewire\Admin\Accounts;

use App\Models\Account;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $trialStatus = '';

    #[Url]
    public $planFilter = '';

    #[Url]
    public $sortBy = 'created_at';

    #[Url]
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTrialStatus()
    {
        $this->resetPage();
    }

    public function updatingPlanFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function getAccountsProperty()
    {
        return Account::query()
            ->with(['plan', 'users'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('company_name', 'like', '%' . $this->search . '%')
                        ->orWhere('company_email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->trialStatus, function ($query) {
                if ($this->trialStatus === 'active') {
                    $query->where('trial_status', 'active')
                        ->where('trial_ends_at', '>', now());
                } elseif ($this->trialStatus === 'expired') {
                    $query->where(function ($q) {
                        $q->where('trial_status', 'expired')
                            ->orWhere(function ($subQ) {
                                $subQ->where('trial_status', 'active')
                                    ->where('trial_ends_at', '<=', now());
                            });
                    });
                } elseif ($this->trialStatus === 'converted') {
                    $query->where('trial_status', 'converted');
                } elseif ($this->trialStatus === 'none') {
                    $query->whereNull('trial_status');
                }
            })
            ->when($this->planFilter, function ($query) {
                if ($this->planFilter === 'none') {
                    $query->whereNull('plan_id');
                } else {
                    $query->where('plan_id', $this->planFilter);
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(20);
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.accounts.index');
    }
}
