<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class QuoteRequest extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['details' => 'array', 'expires_at' => 'datetime'];
    public function quotations() { return $this->hasMany(Quotation::class); }
    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function provider() { return $this->belongsTo(ProviderProfile::class); }
}
