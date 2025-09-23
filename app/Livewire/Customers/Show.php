<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Show extends Component
{
    use AuthorizesRequests;

    public Customer $customer;
    public bool $showEditModal = false;
    public bool $showLinkVehicleModal = false;
    public bool $showUnlinkConfirmModal = false;

    // Vehicle linking properties
    public string $vehicleRegistration = '';
    public string $vehicleRelationship = 'owner';
    public string $ownedFrom = '';
    public ?string $ownedTo = null;
    public ?Vehicle $vehicleToUnlink = null;

    // Notes properties
    public string $notes = '';
    public bool $notesChanged = false;

    protected $rules = [
        'vehicleRegistration' => 'required|string|max:20',
        'vehicleRelationship' => 'required|in:owner,driver,billing_contact',
        'ownedFrom' => 'nullable|date',
        'ownedTo' => 'nullable|date|after_or_equal:ownedFrom',
        'notes' => 'nullable|string|max:65535',
    ];

    public function mount(Customer $customer)
    {
        $this->authorize('view', $customer);
        $this->customer = $customer->load(['currentVehicles', 'vehicles']);
        $this->notes = $this->customer->notes ?? '';
        $this->ownedFrom = now()->format('Y-m-d');
    }

    public function setActiveTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    public function openEditModal()
    {
        $this->authorize('update', $this->customer);
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
    }

    #[On('customerSaved')]
    public function handleCustomerSaved()
    {
        $this->closeEditModal();
        $this->customer->refresh(); // Refresh customer data
        session()->flash('success', 'Customer updated successfully.');
    }

    #[On('modalClosed')]
    public function handleModalClosed()
    {
        $this->closeEditModal();
    }

    public function openLinkVehicleModal()
    {
        $this->authorize('linkVehicle', $this->customer);
        $this->resetVehicleLinkingForm();
        $this->showLinkVehicleModal = true;
    }

    public function closeLinkVehicleModal()
    {
        $this->showLinkVehicleModal = false;
        $this->resetVehicleLinkingForm();
    }

    public function linkVehicle()
    {
        $this->authorize('linkVehicle', $this->customer);
        
        $this->validate([
            'vehicleRegistration' => 'required|string|max:20',
            'vehicleRelationship' => 'required|in:owner,driver,billing_contact',
            'ownedFrom' => 'nullable|date',
            'ownedTo' => 'nullable|date|after_or_equal:ownedFrom',
        ]);

        try {
            // Clean and uppercase the registration
            $registration = strtoupper(trim($this->vehicleRegistration));
            
            // Find or create vehicle
            $vehicle = Vehicle::where('registration', $registration)
                             ->where('account_id', auth()->user()->account_id)
                             ->first();
            
            if (!$vehicle) {
                // Create new vehicle with basic registration info
                $vehicle = Vehicle::create([
                    'account_id' => auth()->user()->account_id,
                    'registration' => $registration,
                    'name' => $registration, // Placeholder name
                ]);
            }

            // Check if relationship already exists
            $existingLink = $this->customer->vehicles()
                                         ->where('vehicle_id', $vehicle->id)
                                         ->where('relationship', $this->vehicleRelationship)
                                         ->whereNull('owned_to')
                                         ->exists();

            if ($existingLink) {
                session()->flash('error', 'This vehicle is already linked with the same relationship.');
                return;
            }

            // Link vehicle to customer
            $this->customer->linkVehicle(
                $vehicle,
                $this->vehicleRelationship,
                $this->ownedFrom ?: null,
                $this->ownedTo
            );

            // Refresh customer data
            $this->customer->refresh();
            $this->customer->load(['currentVehicles', 'vehicles']);

            session()->flash('success', "Vehicle {$registration} linked successfully.");
            $this->closeLinkVehicleModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to link vehicle: ' . $e->getMessage());
        }
    }

    public function confirmUnlinkVehicle(Vehicle $vehicle)
    {
        $this->authorize('unlinkVehicle', $this->customer);
        $this->vehicleToUnlink = $vehicle;
        $this->showUnlinkConfirmModal = true;
    }

    public function unlinkVehicle()
    {
        $this->authorize('unlinkVehicle', $this->customer);
        
        if (!$this->vehicleToUnlink) {
            return;
        }

        try {
            $this->customer->endVehicleOwnership($this->vehicleToUnlink, now()->format('Y-m-d'));
            
            // Refresh customer data
            $this->customer->refresh();
            $this->customer->load(['currentVehicles', 'vehicles']);

            session()->flash('success', "Vehicle {$this->vehicleToUnlink->registration} unlinked successfully.");
            $this->closeUnlinkConfirmModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to unlink vehicle: ' . $e->getMessage());
        }
    }

    public function closeUnlinkConfirmModal()
    {
        $this->showUnlinkConfirmModal = false;
        $this->vehicleToUnlink = null;
    }

    public function updateNotes()
    {
        $this->authorize('update', $this->customer);
        
        $this->validate(['notes' => 'nullable|string|max:65535']);

        try {
            $this->customer->update([
                'notes' => $this->notes ?: null,
                'last_contact_at' => now(),
            ]);

            $this->notesChanged = false;
            session()->flash('success', 'Notes updated successfully.');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update notes: ' . $e->getMessage());
        }
    }

    public function updatedNotes()
    {
        $this->notesChanged = ($this->notes !== ($this->customer->notes ?? ''));
    }


    private function resetVehicleLinkingForm()
    {
        $this->vehicleRegistration = '';
        $this->vehicleRelationship = 'owner';
        $this->ownedFrom = now()->format('Y-m-d');
        $this->ownedTo = null;
    }

    public function getTagColor(string $tag): string
    {
        return match (strtolower($tag)) {
            'vip' => 'amber',
            'trade' => 'blue',
            'fleet' => 'purple',
            'regular' => 'green',
            'new' => 'cyan',
            default => 'zinc',
        };
    }

    public function render()
    {
        return view('livewire.customers.show');
    }
}
