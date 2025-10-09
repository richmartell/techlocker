<?php

namespace App\Livewire\Reseller\Customers;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getCustomersProperty()
    {
        $reseller = Auth::guard('reseller')->user();
        
        return $reseller->accounts()
            ->with(['plan', 'users'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('company_name', 'like', '%' . $this->search . '%')
                        ->orWhere('company_email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    #[Layout('components.layouts.reseller')]
    public function render()
    {
        return view('livewire.reseller.customers.index');
    }
}
