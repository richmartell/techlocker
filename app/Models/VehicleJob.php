<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VehicleJob extends Model
{
    use HasFactory, SoftDeletes, HasUlids;

    protected $table = 'service_jobs';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'account_id',
        'vehicle_id',
        'job_number',
        'title',
        'description',
        'status',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (VehicleJob $job) {
            if (auth()->check() && auth()->user()->account_id && !$job->account_id) {
                $job->account_id = auth()->user()->account_id;
            }

            if (empty($job->job_number)) {
                $job->job_number = static::generateJobNumber();
            }
        });

        // Global scope for multi-tenancy
        static::addGlobalScope('account', function ($builder) {
            if (auth()->check() && auth()->user()->account_id) {
                $builder->where('account_id', auth()->user()->account_id);
            }
        });
    }

    public static function generateJobNumber(): string
    {
        $year = now()->year;
        $prefix = "JOB-{$year}-";
        $count = static::withTrashed()->whereYear('created_at', $year)->count() + 1;
        return $prefix . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function technicians(): BelongsToMany
    {
        return $this->belongsToMany(Technician::class, 'job_technician', 'job_id', 'technician_id')
            ->withPivot(['role'])
            ->withTimestamps();
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
