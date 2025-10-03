<?php

namespace App\Livewire\Admin;

use App\Models\Account;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    public function getStatsProperty()
    {
        return [
            'total_accounts' => Account::count(),
            'total_users' => User::count(),
            'active_trials' => Account::where('status', 'trial')
                ->where('trial_ends_at', '>', now())
                ->count(),
            'expired_trials' => Account::where(function ($query) {
                $query->where('status', 'trial_expired')
                    ->orWhere(function ($q) {
                        $q->where('status', 'trial')
                            ->where('trial_ends_at', '<=', now());
                    });
            })->count(),
            'converted_trials' => Account::where('status', 'active')->count(),
            'accounts_with_plans' => Account::whereNotNull('plan_id')->count(),
            'churned_accounts' => Account::where('status', 'churned')->count(),
        ];
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
