<?php

namespace App\Livewire\Quotes;

use Livewire\Component;
use App\Models\Quote;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $search = '';
    public $statusFilter = '';
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
    
    public function getQuotesProperty()
    {
        $query = Quote::with(['customer', 'vehicle'])
            ->where('account_id', auth()->user()->account_id);
        
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('quote_number', 'like', "%{$this->search}%")
                    ->orWhereHas('customer', function ($subQuery) {
                        $subQuery->where('first_name', 'like', "%{$this->search}%")
                            ->orWhere('last_name', 'like', "%{$this->search}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$this->search}%"]);
                    })
                    ->orWhereHas('vehicle', function ($subQuery) {
                        $subQuery->where('registration', 'like', "%{$this->search}%");
                    });
            });
        }
        
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }
        
        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    public function render()
    {
        return view('livewire.quotes.index', [
            'quotes' => $this->quotes,
        ])->layout('components.layouts.app');
    }
}
