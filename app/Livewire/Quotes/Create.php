<?php

namespace App\Livewire\Quotes;

use Livewire\Component;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Create extends Component
{
    public $quote;
    public $customer;
    public $vehicle;
    public $quoteItems = [];
    public $labourRate = 75.00;
    public $vatRate = 20;
    public $notes = '';
    public $validUntil;
    
    public function mount(?Quote $quote = null)
    {
        // Load labour settings from account
        $account = auth()->user()->account;
        if ($account) {
            $this->labourRate = $account->hourly_labour_rate ?? $this->labourRate;
            $this->vatRate = $account->vat_registered ? 20 : 0;
        }
        
        if ($quote && $quote->exists) {
            // Load existing draft quote
            $this->quote = $quote->load(['customer', 'vehicle.make', 'vehicle.model', 'items']);
            $this->customer = $this->quote->customer;
            $this->vehicle = $this->quote->vehicle;
            $this->labourRate = $this->quote->labour_rate;
            $this->vatRate = $this->quote->vat_rate;
            $this->notes = $this->quote->notes ?? '';
            $this->validUntil = $this->quote->valid_until?->format('Y-m-d') ?? now()->addDays(30)->format('Y-m-d');
            
            // Load quote items
            foreach ($this->quote->items as $item) {
                $this->quoteItems['item_' . $item->id] = [
                    'id' => $item->id,
                    'description' => $item->description,
                    'time' => $item->time_hours,
                    'quantity' => $item->quantity,
                ];
            }
            
            Log::info('Existing quote loaded', [
                'quote_id' => $this->quote->id,
                'items_count' => count($this->quoteItems)
            ]);
        } else {
            // Set default valid until date (30 days from now)
            $this->validUntil = now()->addDays(30)->format('Y-m-d');
            
            Log::warning('No quote provided to Create component');
        }
    }
    
    public function updateItemQuantity($itemId, $quantity)
    {
        if (isset($this->quoteItems[$itemId])) {
            $this->quoteItems[$itemId]['quantity'] = max(1, (int) $quantity);
        }
    }
    
    public function removeItem($itemId)
    {
        unset($this->quoteItems[$itemId]);
    }
    
    public function getSubtotalProperty()
    {
        return array_sum(array_map(function($item) {
            return ($item['time'] * $this->labourRate * $item['quantity']);
        }, $this->quoteItems));
    }
    
    public function getVatAmountProperty()
    {
        return ($this->subtotal * $this->vatRate) / 100;
    }
    
    public function getTotalProperty()
    {
        return $this->subtotal + $this->vatAmount;
    }
    
    public function saveQuote()
    {
        $this->validate([
            'notes' => 'nullable|string|max:5000',
            'validUntil' => 'required|date|after:today',
        ]);
        
        if (count($this->quoteItems) === 0) {
            session()->flash('error', 'Cannot save a quote without items');
            return;
        }
        
        try {
            DB::beginTransaction();
            
            // Update the existing quote
            $this->quote->update([
                'labour_rate' => $this->labourRate,
                'vat_rate' => $this->vatRate,
                'subtotal' => $this->subtotal,
                'vat_amount' => $this->vatAmount,
                'total' => $this->total,
                'notes' => $this->notes,
                'valid_until' => $this->validUntil,
                'status' => 'sent', // Update status from draft to sent
            ]);
            
            // Delete existing items
            $this->quote->items()->delete();
            
            // Create updated quote items
            $sortOrder = 0;
            foreach ($this->quoteItems as $item) {
                QuoteItem::create([
                    'quote_id' => $this->quote->id,
                    'description' => $item['description'],
                    'time_hours' => $item['time'],
                    'labour_rate' => $this->labourRate,
                    'quantity' => $item['quantity'],
                    'line_total' => ($item['time'] * $this->labourRate * $item['quantity']),
                    'sort_order' => $sortOrder++,
                ]);
            }
            
            DB::commit();
            
            session()->flash('success', 'Quote saved successfully!');
            
            return redirect()->route('quotes.show', $this->quote->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to save quote', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Failed to save quote: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.quotes.create')->layout('components.layouts.app');
    }
}
