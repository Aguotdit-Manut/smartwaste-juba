<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    protected $fillable = [
        'collector_id',
        'vehicle_type',
        'registration_number',
        'capacity_kg',
        'status',
    ];

    protected $casts = [
        'capacity_kg' => 'decimal:2',
    ];

    public function collector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collector_id');
    }
}