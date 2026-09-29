<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OtpChallenge extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['expires_at' => 'datetime', 'consumed_at' => 'datetime'];
}
