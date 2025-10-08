<?php

namespace App\Livewire\Quotes;

use Livewire\Component;
use App\Models\Quote;

class Show extends Component
{
    public Quote $quote;
    
    public function mount(Quote $quote)
    {
        // Check authorization
        if ($quote->account_id !== auth()->user()->account_id) {
            abort(403);
        }
        
        $this->quote = $quote;
        $this->quote->load(['customer', 'vehicle', 'items']);
    }
    
    public function deleteQuote()
    {
        $this->quote->delete();
        
        session()->flash('success', 'Quote deleted successfully');
        
        return redirect()->route('vehicle.show', $this->quote->vehicle->registration);
    }

    public function render()
    {
        return view('livewire.quotes.show')->layout('components.layouts.app');
    }
}
