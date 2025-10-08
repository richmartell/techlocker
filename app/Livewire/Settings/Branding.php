<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class Branding extends Component
{
    use WithFileUploads;

    public $logo;
    public $existingLogo;
    public $companyName;
    public $tradingName;
    public $address;
    public $vatNumber;

    public function mount()
    {
        $account = Auth::user()->account;
        
        $this->existingLogo = $account->branding_logo;
        $this->companyName = $account->company_name;
        $this->tradingName = $account->branding_trading_name;
        $this->address = $account->branding_address;
        $this->vatNumber = $account->vat_number;
    }

    public function save()
    {
        $this->validate([
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'companyName' => 'required|string|max:255',
            'tradingName' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'vatNumber' => 'nullable|string|max:50',
        ]);

        $account = Auth::user()->account;

        // Handle logo upload
        if ($this->logo) {
            // Delete old logo if exists
            if ($account->branding_logo) {
                Storage::disk('public')->delete($account->branding_logo);
            }

            // Store new logo
            $logoPath = $this->logo->store('branding/logos', 'public');
            $account->branding_logo = $logoPath;
        }

        // Update branding fields
        $account->company_name = $this->companyName;
        $account->branding_trading_name = $this->tradingName;
        $account->branding_address = $this->address;
        $account->vat_number = $this->vatNumber;
        $account->save();

        // Reset logo input and update existing logo
        $this->existingLogo = $account->branding_logo;
        $this->logo = null;

        session()->flash('success', 'Branding updated successfully.');
    }

    public function removeLogo()
    {
        $account = Auth::user()->account;

        if ($account->branding_logo) {
            Storage::disk('public')->delete($account->branding_logo);
            $account->branding_logo = null;
            $account->save();

            $this->existingLogo = null;
            session()->flash('success', 'Logo removed successfully.');
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.settings.branding');
    }
}