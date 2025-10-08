<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'account_id',
        'customer_id',
        'vehicle_id',
        'quote_number',
        'status',
        'labour_rate',
        'vat_rate',
        'subtotal',
        'vat_amount',
        'total',
        'notes',
        'valid_until',
    ];

    protected $casts = [
        'labour_rate' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'valid_until' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quote) {
            if (!$quote->quote_number) {
                $quote->quote_number = static::generateQuoteNumber();
            }
        });
    }

    public static function generateQuoteNumber(): string
    {
        $year = now()->year;
        $lastQuote = static::whereYear('created_at', $year)->latest('id')->first();
        $nextNumber = $lastQuote ? ((int) substr($lastQuote->quote_number, -4)) + 1 : 1;
        
        return 'QUOTE-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuoteItem::class)->orderBy('sort_order');
    }

    public function calculateTotals(): void
    {
        $this->subtotal = $this->items->sum('line_total');
        $this->vat_amount = ($this->subtotal * $this->vat_rate) / 100;
        $this->total = $this->subtotal + $this->vat_amount;
    }
}
