<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteItem extends Model
{
    protected $fillable = [
        'quote_id',
        'description',
        'time_hours',
        'labour_rate',
        'quantity',
        'line_total',
        'sort_order',
    ];

    protected $casts = [
        'time_hours' => 'decimal:2',
        'labour_rate' => 'decimal:2',
        'quantity' => 'integer',
        'line_total' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            // Calculate line total automatically
            $item->line_total = ($item->time_hours * $item->labour_rate * $item->quantity);
        });
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }
}
