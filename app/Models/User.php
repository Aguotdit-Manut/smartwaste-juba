<?php

namespace App\Models;

use App\Models\CollectorLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'is_online',
        'last_seen_at',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_online' => 'boolean',
     'last_seen_at' => 'datetime',
   ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function pickupRequests()
    {
        return $this->hasMany(PickupRequest::class, 'resident_id');
    }

    public function assignedPickups()
    {
        return $this->hasMany(PickupRequest::class, 'collector_id');
    }

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'collector_id');
    }

    public function collectorLocations()
    {
        return $this->hasMany(CollectorLocation::class, 'collector_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}