<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AvailabilityRule extends Model {
    use HasUuids;
    protected $guarded = [];
    public function resource() { return $this->belongsTo(BookableResource::class); }
}
