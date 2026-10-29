<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WasteCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_recyclable',
        'is_compostable',
        'is_active',
    ];

    protected $casts = [
        'is_recyclable' => 'boolean',
        'is_compostable' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function pickupItems(): HasMany
    {
        return $this->hasMany(PickupItem::class);
    }
}