<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectorLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'collector_id',
        'latitude',
        'longitude',
        'accuracy',
        'recorded_at',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'accuracy' => 'decimal:2',
        'recorded_at' => 'datetime',
    ];

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }
}