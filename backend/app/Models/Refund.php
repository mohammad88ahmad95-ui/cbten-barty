<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Refund extends Model {
    use HasUuids;
    protected $guarded = [];
    public function allocations() { return $this->hasMany(RefundAllocation::class); }
}
