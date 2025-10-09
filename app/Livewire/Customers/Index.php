<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    public string $search = '';
    public string $sortBy = 'last_name';
    public string $sortDirection = 'asc';
    public string $filter = 'all'; // all, deleted
    
    // Delete modal state
    public bool $showDeleteModal = false;
    public ?Customer $customerToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'last_name'],
        'sortDirection' => ['except' => 'asc'],
        'filter' => ['except' => 'all'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->authorize('viewAny', Customer::class);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingIncludeNotes()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function openCreateModal()
    {
        try {
            $this->authorize('create', Customer::class);
            
            // Dispatch event to the Upsert component to open its modal
            $this->dispatch('openCustomerModal')->to('customers.upsert');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to open modal: ' . $e->getMessage());
        }
    }


    #[On('customerSaved')]
    public function handleCustomerSaved()
    {
        $this->resetPage(); // Refresh the customer list
    }

    public function deleteCustomer(Customer $customer)
    {
        $this->authorize('delete', $customer);
        
        $customer->delete();
        session()->flash('success', "Customer '{$customer->full_name}' has been deleted.");
    }

    public function restoreCustomer($customerId)
    {
        $customer = Customer::withTrashed()->findOrFail($customerId);
        $this->authorize('restore', $customer);
        
        $customer->restore();
        session()->flash('success', "Customer '{$customer->full_name}' has been restored.");
    }

    public function forceDeleteCustomer($customerId)
    {
        $customer = Customer::withTrashed()->findOrFail($customerId);
        $this->authorize('forceDelete', $customer);
        
        $customerName = $customer->full_name;
        $customer->forceDelete();
        session()->flash('success', "Customer '{$customerName}' has been permanently deleted.");
    }

    public function getCustomersProperty()
    {
        $query = Customer::query();

        // Apply soft delete filter
        if ($this->filter === 'deleted') {
            $query->onlyTrashed();
        } elseif ($this->filter === 'active') {
            // Active customers (explicitly exclude trashed)
            $query->whereNull('deleted_at');
        }
        // 'all' filter shows both active and trashed customers (default behavior)

        // Apply search
        if ($this->search) {
            $query->search($this->search);
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'name':
                $query->orderBy('last_name', $this->sortDirection)
                      ->orderBy('first_name', $this->sortDirection);
                break;
            case 'first_name':
                $query->orderBy('first_name', $this->sortDirection)
                      ->orderBy('last_name', $this->sortDirection);
                break;
            case 'last_name':
                $query->orderBy('last_name', $this->sortDirection)
                      ->orderBy('first_name', $this->sortDirection);
                break;
            case 'email':
                $query->orderBy('email', $this->sortDirection);
                break;
            case 'phone':
                $query->orderBy('phone', $this->sortDirection);
                break;
            case 'updated_at':
                $query->orderBy('updated_at', $this->sortDirection);
                break;
            default:
                $query->orderBy('last_name', 'asc')
                      ->orderBy('first_name', 'asc');
                break;
        }

        return $query->with(['currentVehicles'])
                    ->paginate(25);
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

    public function setSortBy(string $sortBy)
    {
        if ($this->sortBy === $sortBy) {
            $this->toggleSortDirection();
        } else {
            $this->sortBy = $sortBy;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleSortDirection()
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function confirmDelete($customerId)
    {
        $this->customerToDelete = Customer::withTrashed()->find($customerId);
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->customerToDelete = null;
    }

    public function delete()
    {
        if ($this->customerToDelete) {
            $this->authorize('delete', $this->customerToDelete);
            $this->customerToDelete->delete();
            session()->flash('success', "Customer '{$this->customerToDelete->full_name}' has been deleted.");
        }
        
        $this->cancelDelete();
    }

    public function restore($customerId)
    {
        $customer = Customer::withTrashed()->find($customerId);
        if ($customer) {
            $this->authorize('restore', $customer);
            $customer->restore();
            session()->flash('success', "Customer '{$customer->full_name}' has been restored.");
        }
    }

    public function render()
    {
        return view('livewire.customers.index', [
            'customers' => $this->customers,
        ])->layout('components.layouts.app', ['title' => 'Customers']);
    }
}
