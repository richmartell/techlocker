<?php

namespace App\Livewire\Admin\Invoices;

use App\Models\Invoice;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $status = '';

    #[Url]
    public $sortBy = 'created_at';

    #[Url]
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
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
    }

    public function getInvoicesProperty()
    {
        return Invoice::query()
            ->with(['account', 'plan'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('invoice_number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('account', function ($accountQuery) {
                            $accountQuery->where('company_name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(20);
    }

    public function getTotalRevenueProperty()
    {
        return Invoice::where('status', 'paid')->sum('amount');
    }

    public function getPendingRevenueProperty()
    {
        return Invoice::where('status', 'pending')->sum('amount');
    }

    public function getOverdueCountProperty()
    {
        return Invoice::where('status', 'pending')
            ->whereDate('due_date', '<', now())
            ->count();
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.invoices.index');
    }
}
