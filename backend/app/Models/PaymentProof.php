<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PaymentProof extends Model {
    use HasUuids;
    protected $guarded = [];
    public $timestamps = false;
    public function asset() { return $this->belongsTo(MediaAsset::class); }
    public function payment() { return $this->belongsTo(Payment::class); }
}
