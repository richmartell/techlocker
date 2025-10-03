<?php

namespace App\Livewire\Admin\Resellers;

use App\Models\Reseller;
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
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function getResellersProperty()
    {
        return Reseller::query()
            ->withCount('accounts')
            ->withSum('commissions', 'amount')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('company_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter !== '', function ($query) {
                if ($this->statusFilter === 'active') {
                    $query->where('is_active', true);
                } else {
                    $query->where('is_active', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function toggleStatus($resellerId)
    {
        $reseller = Reseller::findOrFail($resellerId);
        $reseller->update(['is_active' => !$reseller->is_active]);
        
        session()->flash('success', 'Reseller status updated successfully.');
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.resellers.index');
    }
}
