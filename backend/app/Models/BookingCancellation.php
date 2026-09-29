<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BookingCancellation extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['policy_snapshot' => 'array'];
}
