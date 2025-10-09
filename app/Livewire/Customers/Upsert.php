<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;

class Upsert extends Component
{
    use AuthorizesRequests;

    public ?Customer $customer = null;
    public bool $isEditing = false;

    // Form fields
    public ?string $first_name = '';
    public ?string $last_name = '';
    public ?string $organisation = '';
    public ?string $email = '';
    public ?string $phone = '';
    public ?string $notes = '';
    public array $tags = [];
    public ?string $source = '';

    // UI state
    public bool $showModal = false;
    public ?string $newTag = '';

    protected function rules()
    {
        return Customer::validationRules($this->customer?->id);
    }

    protected $messages = [
        'first_name.required' => 'First name is required.',
        'last_name.required' => 'Last name is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email address is already in use.',
        'phone.max' => 'Phone number cannot exceed 30 characters.',
    ];

    public function mount(?Customer $customer = null): void
    {
        \Log::info('🧪 UPSERT MOUNT - customer provided: ' . ($customer ? 'YES (ID: ' . ($customer->id ?? 'NULL') . ')' : 'NO'));
        
        try {
            // Check if we have a valid customer with an ID (edit mode)
            if ($customer && $customer->exists) {
                // Edit mode - customer passed from Show page
                $this->authorize('update', $customer);
                $this->customer = $customer;
                $this->isEditing = true;
                $this->loadCustomerData();
                $this->showModal = true; // Auto-show modal when editing
                \Log::info('Upsert - edit mode set for customer: ' . $customer->full_name);
            } else {
                // Create mode - no customer passed (from Index page)
                // Authorization will be checked in save() method
                $this->isEditing = false;
                $this->showModal = false; // Don't auto-show for create mode
                \Log::info('Upsert - create mode set');
            }

            \Log::info('Upsert component mounted successfully - isEditing: ' . ($this->isEditing ? 'true' : 'false'));

        } catch (\Exception $e) {
            \Log::error('Upsert mount error: ' . $e->getMessage());
            session()->flash('error', 'Failed to load customer form: ' . $e->getMessage());
            $this->showModal = false;
        }
    }

    public function loadCustomerData()
    {
        if ($this->customer) {
            $this->first_name = $this->customer->first_name;
            $this->last_name = $this->customer->last_name;
            $this->organisation = $this->customer->organisation ?? '';
            $this->email = $this->customer->email ?? '';
            $this->phone = $this->customer->phone ?? '';
            $this->notes = $this->customer->notes ?? '';
            $this->tags = $this->customer->tags ?? [];
            $this->source = $this->customer->source ?? '';
        }
    }

    #[On('openCustomerModal')]
    public function openModal(?Customer $customer = null)
    {
        // Only treat as edit mode if we have a valid existing customer
        if ($customer && $customer->exists) {
            $this->isEditing = true;
            $this->customer = $customer;
            $this->loadCustomerData();
        } else {
            $this->isEditing = false;
            $this->resetForm();
        }
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetValidation();
        
        // Notify parent component to hide its modal state
        $this->dispatch('modalClosed');
    }

    public function resetForm()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->organisation = '';
        $this->email = '';
        $this->phone = '';
        $this->notes = '';
        $this->tags = [];
        $this->source = '';
        $this->newTag = '';
        $this->customer = null;
        $this->isEditing = false;
    }

    public function addTag()
    {
        $tag = trim($this->newTag);
        
        if ($tag && !in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
            $this->newTag = '';
        }
    }

    public function removeTag($index)
    {
        unset($this->tags[$index]);
        $this->tags = array_values($this->tags); // Re-index array
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'first_name' => trim($this->first_name),
                'last_name' => trim($this->last_name),
                'organisation' => $this->organisation ? trim($this->organisation) : null,
                'email' => $this->email ? trim($this->email) : null,
                'phone' => $this->phone ? trim($this->phone) : null,
                'notes' => $this->notes ? trim($this->notes) : null,
                'tags' => empty($this->tags) ? null : $this->tags,
                'source' => $this->source ?: null,
            ];

            if ($this->isEditing && $this->customer) {
                $this->authorize('update', $this->customer);
                $this->customer->update($data);
                $message = "Customer '{$this->customer->full_name}' has been updated successfully.";
            } else {
                $this->authorize('create', Customer::class);
                // Add account_id for new customers
                $data['account_id'] = auth()->user()->account_id;
                $this->customer = Customer::create($data);
                $message = "Customer '{$this->customer->full_name}' has been created successfully.";
            }

            $this->closeModal();
            
            session()->flash('success', $message);
            
            // Emit event to parent component
            $this->dispatch('customerSaved', $this->customer->id);
            
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while saving the customer. Please try again.');
        }
    }

    public function updatedNewTag()
    {
        // Auto-add tag when user presses Enter or comma
        $this->newTag = str_replace(',', '', $this->newTag);
    }

    public function getAvailableSourcesProperty()
    {
        return [
            'web' => 'Website',
            'phone' => 'Phone Call',
            'walk-in' => 'Walk-in',
            'referral' => 'Referral',
        ];
    }

    public function getCommonTagsProperty()
    {
        return ['VIP', 'Trade', 'Fleet', 'Regular', 'New', 'Repeat Customer', 'Credit Hold'];
    }

    public function addCommonTag($tag)
    {
        if (!in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }
    }

    public function addSuggestedTag(string $tag)
    {
        if (!in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }
    }

    public function render()
    {
        return view('livewire.customers.upsert', [
            'availableSources' => $this->availableSources,
            'commonTags' => $this->commonTags,
        ]);
    }
}
