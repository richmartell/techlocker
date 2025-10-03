<?php

namespace App\Livewire\Admin\Accounts;

use App\Models\Account;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public Account $account;

    public function mount(Account $account)
    {
        $this->account = $account->load(['plan', 'users', 'customers', 'vehicles']);
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.accounts.show');
    }
}
