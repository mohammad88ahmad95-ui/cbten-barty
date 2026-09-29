<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AvailabilityException extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['local_date' => 'date'];
    public function resource() { return $this->belongsTo(BookableResource::class); }
    public function periods() { return $this->hasMany(AvailabilityExceptionPeriod::class); }
}
