<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;

class Customer extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'account_id',
        'first_name',
        'last_name', 
        'email',
        'phone',
        'phone_e164',
        'notes',
        'tags',
        'source',
        'last_contact_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tags' => 'array',
        'last_contact_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Global scope to filter by current user's account
        static::addGlobalScope('account', function ($builder) {
            if (auth()->check() && auth()->user()->account_id) {
                $builder->where('account_id', auth()->user()->account_id);
            }
        });

        static::creating(function ($customer) {
            // Automatically set account_id when creating
            if (auth()->check() && auth()->user()->account_id && !$customer->account_id) {
                $customer->account_id = auth()->user()->account_id;
            }
        });

        static::saving(function ($customer) {
            // Normalize phone number to E.164 format when saving
            if ($customer->phone && $customer->isDirty('phone')) {
                $customer->phone_e164 = $customer->normalizePhoneNumber($customer->phone);
            }
        });
    }

    /**
     * Get the customer's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get the customer's formatted name (Last, First).
     */
    public function getFormattedNameAttribute(): string
    {
        return trim($this->last_name . ', ' . $this->first_name);
    }

    /**
     * Normalize phone number to E.164 format.
     */
    public function normalizePhoneNumber(?string $phone, string $defaultRegion = 'GB'): ?string
    {
        if (empty($phone)) {
            return null;
        }

        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $phoneNumber = $phoneUtil->parse($phone, $defaultRegion);
            
            if ($phoneUtil->isValidNumber($phoneNumber)) {
                return $phoneUtil->format($phoneNumber, PhoneNumberFormat::E164);
            }
        } catch (NumberParseException $e) {
            // If parsing fails, return null so phone_e164 stays empty
            // This allows storing the original input but doesn't provide normalized search
        }

        return null;
    }

    /**
     * Format phone number for display.
     */
    public function getFormattedPhoneAttribute(): ?string
    {
        if (empty($this->phone)) {
            return null;
        }

        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $phoneNumber = $phoneUtil->parse($this->phone, 'GB');
            
            if ($phoneUtil->isValidNumber($phoneNumber)) {
                return $phoneUtil->format($phoneNumber, PhoneNumberFormat::NATIONAL);
            }
        } catch (NumberParseException $e) {
            // Return original if formatting fails
        }

        return $this->phone;
    }

    /**
     * Get account relationship.
     */
    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Account::class);
    }

    /**
     * Get vehicles relationship.
     */
    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'customer_vehicle')
            ->withPivot(['relationship', 'owned_from', 'owned_to'])
            ->withTimestamps()
            ->orderBy('customer_vehicle.created_at', 'desc');
    }

    /**
     * Get current vehicles (where owned_to is null).
     */
    public function currentVehicles(): BelongsToMany
    {
        return $this->vehicles()->wherePivotNull('owned_to');
    }

    /**
     * Get vehicles by relationship type.
     */
    public function vehiclesByRelationship(string $relationship): BelongsToMany
    {
        return $this->vehicles()->wherePivot('relationship', $relationship);
    }

    /**
     * Check if customer owns a specific vehicle.
     */
    public function ownsVehicle(Vehicle $vehicle): bool
    {
        return $this->currentVehicles()
            ->where('vehicles.id', $vehicle->id)
            ->wherePivot('relationship', 'owner')
            ->exists();
    }

    /**
     * Scope for searching customers.
     */
    public function scopeSearch($query, ?string $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $search = trim($search);
            
            // Check if search looks like an email
            if (str_contains($search, '@')) {
                $query->where('email', 'like', "%{$search}%");
                return;
            }

            // Check if search contains only numbers (phone search)
            if (preg_match('/^[\d\s\-\+\(\)]+$/', $search)) {
                $cleanSearch = preg_replace('/[^\d\+]/', '', $search);
                $query->where(function ($query) use ($search, $cleanSearch) {
                    $query->where('phone', 'like', "%{$search}%")
                          ->orWhere('phone_e164', 'like', "%{$cleanSearch}%");
                });
                return;
            }

            // Name search - split by whitespace and search across first/last names
            $tokens = array_filter(explode(' ', $search));
            
            foreach ($tokens as $token) {
                $query->where(function ($query) use ($token) {
                    $query->where('first_name', 'like', "%{$token}%")
                          ->orWhere('last_name', 'like', "%{$token}%");
                });
            }
        });
    }

    /**
     * Scope for searching in notes.
     */
    public function scopeSearchNotes($query, ?string $search)
    {
        if (empty($search)) {
            return $query;
        }

        // Use full-text search if available, otherwise LIKE
        if (config('database.default') === 'mysql') {
            return $query->whereRaw('MATCH(notes) AGAINST(?)', [$search]);
        }
        
        return $query->where('notes', 'like', "%{$search}%");
    }

    /**
     * Scope for filtering by tags.
     */
    public function scopeWithTag($query, string $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Scope for filtering by source.
     */
    public function scopeFromSource($query, string $source)
    {
        return $query->where('source', $source);
    }

    /**
     * Add a tag to the customer.
     */
    public function addTag(string $tag): void
    {
        $tags = $this->tags ?? [];
        if (!in_array($tag, $tags)) {
            $tags[] = $tag;
            $this->tags = $tags;
            $this->save();
        }
    }

    /**
     * Remove a tag from the customer.
     */
    public function removeTag(string $tag): void
    {
        $tags = $this->tags ?? [];
        $tags = array_values(array_filter($tags, fn($t) => $t !== $tag));
        $this->tags = $tags;
        $this->save();
    }

    /**
     * Update last contact timestamp.
     */
    public function updateLastContact(): void
    {
        $this->last_contact_at = now();
        $this->save();
    }

    /**
     * Link a vehicle to this customer.
     */
    public function linkVehicle(Vehicle $vehicle, string $relationship = 'owner', ?string $ownedFrom = null, ?string $ownedTo = null): void
    {
        $this->vehicles()->attach($vehicle->id, [
            'id' => \Illuminate\Support\Str::ulid(),
            'relationship' => $relationship,
            'owned_from' => $ownedFrom,
            'owned_to' => $ownedTo,
        ]);
    }

    /**
     * End ownership of a vehicle.
     */
    public function endVehicleOwnership(Vehicle $vehicle, ?string $endDate = null): void
    {
        $this->vehicles()->updateExistingPivot($vehicle->id, [
            'owned_to' => $endDate ?? now()->toDateString(),
        ]);
    }

    /**
     * Get validation rules for customers.
     */
    public static function validationRules(?string $customerId = null): array
    {
        $emailRule = 'nullable|email:rfc,dns|max:191';
        
        if (auth()->check() && auth()->user()->account_id) {
            if ($customerId) {
                $emailRule .= "|unique:customers,email,{$customerId},id,deleted_at,NULL,account_id," . auth()->user()->account_id;
            } else {
                $emailRule .= '|unique:customers,email,NULL,id,deleted_at,NULL,account_id,' . auth()->user()->account_id;
            }
        }

        return [
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'email' => $emailRule,
            'phone' => 'nullable|string|max:30',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'source' => 'nullable|in:web,phone,walk-in,referral',
        ];
    }
}
