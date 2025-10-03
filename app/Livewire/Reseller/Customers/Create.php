<?php

namespace App\Livewire\Reseller\Customers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    #[Rule('required|string|max:255')]
    public $company_name = '';

    #[Rule('required|string|max:255')]
    public $contact_name = '';

    #[Rule('required|email|unique:users,email')]
    public $email = '';

    #[Rule('nullable|string|max:20')]
    public $phone = '';

    public function createTrial()
    {
        $this->validate();

        $reseller = Auth::guard('reseller')->user();

        // Create the account with 14-day trial
        $account = Account::create([
            'company_name' => $this->company_name,
            'company_email' => $this->email,
            'company_phone' => $this->phone,
            'reseller_id' => $reseller->id,
            'trial_started_at' => now(),
            'trial_ends_at' => now()->addDays(14),
            'status' => 'trial',
            'is_active' => true,
            'country' => 'United Kingdom',
        ]);

        // Create the primary user for this account
        $tempPassword = Str::random(16);
        
        User::create([
            'account_id' => $account->id,
            'name' => $this->contact_name,
            'email' => $this->email,
            'password' => Hash::make($tempPassword),
            'role' => 'admin',
            'is_active' => true,
        ]);

        session()->flash('success', 'Trial account created successfully! The customer has 14 days to try the platform.');

        return redirect()->route('reseller.customers');
    }

    #[Layout('components.layouts.reseller')]
    public function render()
    {
        return view('livewire.reseller.customers.create');
    }
}
