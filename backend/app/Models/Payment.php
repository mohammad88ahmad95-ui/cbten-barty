<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Payment extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['payment_date' => 'date', 'instructions_snapshot' => 'array',
        'verified_at' => 'datetime'];
    public function booking() { return $this->belongsTo(Booking::class); }
    public function proofs() { return $this->hasMany(PaymentProof::class); }
    public function statusHistory() { return $this->hasMany(PaymentStatusHistory::class); }
    public function account() { return $this->belongsTo(ProviderPaymentAccount::class, 'payment_account_id'); }
}
