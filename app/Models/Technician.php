<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technician extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'account_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'notes',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Technician $tech) {
            if (auth()->check() && auth()->user()->account_id && !$tech->account_id) {
                $tech->account_id = auth()->user()->account_id;
            }
        });

        static::addGlobalScope('account', function ($builder) {
            if (auth()->check() && auth()->user()->account_id) {
                $builder->where('account_id', auth()->user()->account_id);
            }
        });
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(VehicleJob::class, 'job_technician', 'technician_id', 'job_id')
            ->withPivot(['role'])
            ->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
