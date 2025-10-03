<?php

namespace App\Livewire\Admin\Resellers;

use App\Models\Reseller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|email|unique:resellers,email')]
    public $email = '';

    #[Rule('required|string|max:255')]
    public $company_name = '';

    #[Rule('nullable|string|max:20')]
    public $phone = '';

    #[Rule('required|numeric|min:0|max:100')]
    public $commission_rate = 10;

    #[Rule('boolean')]
    public $is_active = true;

    public function save()
    {
        $this->validate();

        // Generate a random password for the reseller
        $tempPassword = Str::random(16);

        $reseller = Reseller::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($tempPassword),
            'company_name' => $this->company_name,
            'phone' => $this->phone,
            'commission_rate' => $this->commission_rate,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Reseller created successfully! They will receive an email with login instructions.');

        return redirect()->route('admin.resellers.show', $reseller);
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.resellers.create');
    }
}
