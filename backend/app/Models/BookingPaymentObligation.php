<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BookingPaymentObligation extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['due_at' => 'datetime'];
}
