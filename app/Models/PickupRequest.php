<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PickupRequest extends Model
{
    protected $fillable = [
        'resident_id',
        'address_id',
        'collector_id',
        'request_type',
        'scheduled_at',
        'status',
        'total_amount',
        'payment_status',
        'notes',
        'photo_path',
        'recurrence_frequency',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resident_id');
    }

    public function collector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PickupItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}