<?php

namespace App\Livewire\Settings;

use App\Models\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Labour extends Component
{
    use AuthorizesRequests;

    public Account $account;
    public string $hourly_labour_rate = '';
    public string $labour_loading_percentage = '';
    public bool $hasUnsavedChanges = false;

    protected $rules = [
        'hourly_labour_rate' => 'required|numeric|min:0|max:9999.99',
        'labour_loading_percentage' => 'required|numeric|min:0|max:100',
    ];

    protected $messages = [
        'hourly_labour_rate.required' => 'Hourly labour rate is required.',
        'hourly_labour_rate.numeric' => 'Hourly labour rate must be a valid number.',
        'hourly_labour_rate.min' => 'Hourly labour rate cannot be negative.',
        'hourly_labour_rate.max' => 'Hourly labour rate cannot exceed £9,999.99.',
        'labour_loading_percentage.required' => 'Labour loading percentage is required.',
        'labour_loading_percentage.numeric' => 'Labour loading percentage must be a valid number.',
        'labour_loading_percentage.min' => 'Labour loading percentage cannot be negative.',
        'labour_loading_percentage.max' => 'Labour loading percentage cannot exceed 100%.',
    ];

    public function mount()
    {
        // Get the authenticated user's account
        $this->account = auth()->user()->account;
        
        // Load current settings
        $this->hourly_labour_rate = number_format($this->account->hourly_labour_rate, 2, '.', '');
        $this->labour_loading_percentage = number_format($this->account->labour_loading_percentage * 100, 2, '.', '');
    }

    public function updated($propertyName)
    {
        $this->hasUnsavedChanges = true;
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        try {
            $this->account->update([
                'hourly_labour_rate' => (float) $this->hourly_labour_rate,
                'labour_loading_percentage' => (float) $this->labour_loading_percentage / 100, // Convert percentage to decimal
            ]);

            $this->hasUnsavedChanges = false;
            session()->flash('success', 'Labour settings updated successfully.');
            
            // Refresh the account model to get updated values
            $this->account->refresh();

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update labour settings. Please try again.');
        }
    }

    public function resetToDefaults()
    {
        $this->hourly_labour_rate = '50.00';
        $this->labour_loading_percentage = '0.00';
        $this->hasUnsavedChanges = true;
    }

    public function getEstimatedCostProperty()
    {
        if (!is_numeric($this->hourly_labour_rate) || !is_numeric($this->labour_loading_percentage)) {
            return null;
        }
        
        // Example calculation for 1 hour of work
        $baseHours = 1.0;
        $adjustedHours = $baseHours * (1 + ((float) $this->labour_loading_percentage / 100));
        $cost = $adjustedHours * (float) $this->hourly_labour_rate;
        
        return number_format($cost, 2);
    }

    public function render()
    {
        return view('livewire.settings.labour');
    }
}