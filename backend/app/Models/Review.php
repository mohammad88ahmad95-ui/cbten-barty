<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Review extends Model {
    use HasUuids;
    protected $guarded = [];
    public function booking() { return $this->belongsTo(Booking::class); }
    public function provider() { return $this->belongsTo(ProviderProfile::class); }
    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function reply() { return $this->hasOne(ReviewReply::class); }
    public function media() { return $this->hasMany(ReviewMedia::class); }
}
