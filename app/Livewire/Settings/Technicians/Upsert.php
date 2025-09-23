<?php

namespace App\Livewire\Settings\Technicians;

use App\Models\Technician;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Upsert extends Component
{
    use AuthorizesRequests;

    public ?Technician $technician = null;
    public bool $isEditing = false;

    // Form fields
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';
    public string $notes = '';
    public bool $active = true;

    protected function rules(): array
    {
        $emailRule = 'nullable|email|max:191';
        if (auth()->check() && auth()->user()->account_id) {
            if ($this->technician && $this->technician->exists) {
                $emailRule .= "|unique:technicians,email,{$this->technician->id},id,deleted_at,NULL,account_id," . auth()->user()->account_id;
            } else {
                $emailRule .= '|unique:technicians,email,NULL,id,deleted_at,NULL,account_id,' . auth()->user()->account_id;
            }
        }

        return [
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'email' => $emailRule,
            'phone' => 'nullable|string|max:30',
            'notes' => 'nullable|string',
            'active' => 'boolean',
        ];
    }

    protected $messages = [
        'first_name.required' => 'First name is required.',
        'last_name.required' => 'Last name is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email address is already in use.',
    ];

    public function mount(?Technician $technician = null): void
    {
        $this->technician = $technician;
        if ($technician && $technician->exists) {
            $this->authorize('view', $technician);
            $this->isEditing = true;
            $this->fill([
                'first_name' => $technician->first_name,
                'last_name' => $technician->last_name,
                'email' => $technician->email ?? '',
                'phone' => $technician->phone ?? '',
                'notes' => $technician->notes ?? '',
                'active' => $technician->active,
            ]);
        } else {
            $this->authorize('create', Technician::class);
        }
    }

    public function save()
    {
        $data = $this->validate();

        try {
            if ($this->isEditing && $this->technician) {
                $this->authorize('update', $this->technician);
                $this->technician->update($data);
                $message = "Technician '{$this->technician->full_name}' has been updated successfully.";
            } else {
                $this->technician = Technician::create($data);
                $message = "Technician '{$this->technician->full_name}' has been created successfully.";
            }

            session()->flash('success', $message);
            return redirect()->route('settings.technicians.show', $this->technician);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save technician. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.settings.technicians.upsert')
            ->layout('components.layouts.app', ['title' => $this->isEditing ? 'Edit Technician' : 'Add Technician']);
    }
}