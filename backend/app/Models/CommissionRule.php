<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CommissionRule extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['valid_from' => 'date', 'valid_to' => 'date'];
}
