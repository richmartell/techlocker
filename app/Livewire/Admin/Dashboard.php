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
            'active_trials' => Account::where('trial_status', 'active')
                ->where('trial_ends_at', '>', now())
                ->count(),
            'expired_trials' => Account::where(function ($query) {
                $query->where('trial_status', 'expired')
                    ->orWhere(function ($q) {
                        $q->where('trial_status', 'active')
                            ->where('trial_ends_at', '<=', now());
                    });
            })->count(),
            'converted_trials' => Account::where('trial_status', 'converted')->count(),
            'accounts_with_plans' => Account::whereNotNull('plan_id')->count(),
        ];
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
