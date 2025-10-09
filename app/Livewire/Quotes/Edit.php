<?php

namespace App\Livewire\Quotes;

use Livewire\Component;
use App\Models\Quote;
use App\Models\QuoteItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Edit extends Component
{
    public Quote $quote;
    public $status;
    public $quoteItems = [];
    public $labourRate;
    public $vatRate;
    public $notes;
    public $validUntil;
    
    // Add item modal
    public $showAddItemModal = false;
    
    // New item fields
    public $newItemType = 'labour';
    public $newItemDescription = '';
    public $newItemTimeHours = '';
    public $newItemQuantity = 1;
    
    // Parts-specific fields
    public $newItemPartNumber = '';
    public $newItemPartName = '';
    public $newItemUnitPrice = '';
    
    public function mount(Quote $quote)
    {
        // Verify the quote belongs to the user's account
        if ($quote->account_id !== auth()->user()->account_id) {
            abort(403);
        }
        
        $this->quote = $quote->load(['customer', 'vehicle', 'items']);
        $this->status = $quote->status;
        $this->labourRate = $quote->labour_rate;
        $this->vatRate = $quote->vat_rate;
        $this->notes = $quote->notes ?? '';
        $this->validUntil = $quote->valid_until?->format('Y-m-d') ?? now()->addDays(30)->format('Y-m-d');
        
        // Load quote items
        foreach ($quote->items as $item) {
            $this->quoteItems[$item->id] = [
                'id' => $item->id,
                'type' => $item->type,
                'description' => $item->description,
                'time_hours' => $item->time_hours,
                'quantity' => $item->quantity,
                'part_number' => $item->part_number,
                'part_name' => $item->part_name,
                'unit_price' => $item->unit_price,
            ];
        }
    }
    
    public function updateItemQuantity($itemId, $quantity)
    {
        if (isset($this->quoteItems[$itemId])) {
            $this->quoteItems[$itemId]['quantity'] = max(1, (int) $quantity);
        }
    }
    
    public function updateItemTime($itemId, $time)
    {
        if (isset($this->quoteItems[$itemId])) {
            $this->quoteItems[$itemId]['time_hours'] = max(0, (float) $time);
        }
    }
    
    public function updateItemUnitPrice($itemId, $price)
    {
        if (isset($this->quoteItems[$itemId])) {
            $this->quoteItems[$itemId]['unit_price'] = max(0, (float) $price);
        }
    }
    
    public function removeItem($itemId)
    {
        unset($this->quoteItems[$itemId]);
    }
    
    public function addNewItem()
    {
        if ($this->newItemType === 'labour') {
            $this->validate([
                'newItemDescription' => 'required|string|max:500',
                'newItemTimeHours' => 'required|numeric|min:0',
                'newItemQuantity' => 'required|integer|min:1',
            ]);
            
            $tempId = 'new_' . uniqid();
            $this->quoteItems[$tempId] = [
                'id' => $tempId,
                'type' => 'labour',
                'description' => $this->newItemDescription,
                'time_hours' => (float) $this->newItemTimeHours,
                'quantity' => (int) $this->newItemQuantity,
                'part_number' => null,
                'part_name' => null,
                'unit_price' => null,
            ];
            
            // Reset labour fields
            $this->newItemDescription = '';
            $this->newItemTimeHours = '';
            $this->newItemQuantity = 1;
        } else {
            // Parts
            $this->validate([
                'newItemPartNumber' => 'nullable|string|max:100',
                'newItemPartName' => 'required|string|max:255',
                'newItemUnitPrice' => 'required|numeric|min:0',
                'newItemQuantity' => 'required|integer|min:1',
            ]);
            
            $tempId = 'new_' . uniqid();
            $this->quoteItems[$tempId] = [
                'id' => $tempId,
                'type' => 'parts',
                'description' => $this->newItemPartName, // Use part name as description
                'time_hours' => null,
                'quantity' => (int) $this->newItemQuantity,
                'part_number' => $this->newItemPartNumber ?: null,
                'part_name' => $this->newItemPartName,
                'unit_price' => (float) $this->newItemUnitPrice,
            ];
            
            // Reset parts fields
            $this->newItemPartNumber = '';
            $this->newItemPartName = '';
            $this->newItemUnitPrice = '';
            $this->newItemQuantity = 1;
        }
        
        // Close the modal
        $this->showAddItemModal = false;
    }
    
    public function getSubtotalProperty()
    {
        return array_sum(array_map(function($item) {
            if ($item['type'] === 'parts') {
                return ($item['unit_price'] * $item['quantity']);
            } else {
                // Labour
                return ($item['time_hours'] * $this->labourRate * $item['quantity']);
            }
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
    
    public function save()
    {
        $this->validate([
            'status' => 'required|in:draft,sent,approved,declined',
            'labourRate' => 'required|numeric|min:0',
            'vatRate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:5000',
            'validUntil' => 'required|date|after:today',
        ]);
        
        if (count($this->quoteItems) === 0) {
            session()->flash('error', 'Cannot save a quote without items');
            return;
        }
        
        try {
            DB::beginTransaction();
            
            // Update the quote
            $this->quote->update([
                'status' => $this->status,
                'labour_rate' => $this->labourRate,
                'vat_rate' => $this->vatRate,
                'subtotal' => $this->subtotal,
                'vat_amount' => $this->vatAmount,
                'total' => $this->total,
                'notes' => $this->notes,
                'valid_until' => $this->validUntil,
            ]);
            
            // Delete all existing items
            $this->quote->items()->delete();
            
            // Create updated/new items
            $sortOrder = 0;
            foreach ($this->quoteItems as $item) {
                if ($item['type'] === 'parts') {
                    QuoteItem::create([
                        'quote_id' => $this->quote->id,
                        'type' => 'parts',
                        'description' => $item['description'],
                        'part_number' => $item['part_number'],
                        'part_name' => $item['part_name'],
                        'unit_price' => $item['unit_price'],
                        'quantity' => $item['quantity'],
                        'line_total' => ($item['unit_price'] * $item['quantity']),
                        'sort_order' => $sortOrder++,
                    ]);
                } else {
                    // Labour
                    QuoteItem::create([
                        'quote_id' => $this->quote->id,
                        'type' => 'labour',
                        'description' => $item['description'],
                        'time_hours' => $item['time_hours'],
                        'labour_rate' => $this->labourRate,
                        'quantity' => $item['quantity'],
                        'line_total' => ($item['time_hours'] * $this->labourRate * $item['quantity']),
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }
            
            DB::commit();
            
            session()->flash('success', 'Quote updated successfully!');
            
            return redirect()->route('quotes.show', $this->quote->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update quote', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Failed to update quote: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.quotes.edit')->layout('components.layouts.app');
    }
}
