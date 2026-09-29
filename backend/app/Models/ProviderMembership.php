<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProviderMembership extends Model {
    use HasUuids;
    protected $guarded = [];
    public function provider() { return $this->belongsTo(ProviderProfile::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function permissions() { return $this->hasMany(StaffPermission::class); }
}
