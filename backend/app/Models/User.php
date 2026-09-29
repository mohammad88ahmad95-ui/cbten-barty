<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, HasUuids;
    protected $guarded = [];
    protected $hidden = ['password'];
    protected $casts = ['phone_verified_at' => 'datetime'];

    public function roles() { return $this->belongsToMany(Role::class, 'user_roles'); }
    public function memberships() { return $this->hasMany(ProviderMembership::class); }
    public function events() { return $this->hasMany(Event::class, 'customer_id'); }
    public function bookings() { return $this->hasMany(Booking::class, 'customer_id'); }
}
