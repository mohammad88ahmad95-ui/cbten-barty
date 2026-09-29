<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Quotation extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['valid_until' => 'datetime', 'accepted_at' => 'datetime'];
    public function quoteRequest() { return $this->belongsTo(QuoteRequest::class); }
    public function items() { return $this->hasMany(QuotationItem::class); }
    public function statusHistory() { return $this->hasMany(QuotationStatusHistory::class); }
}
