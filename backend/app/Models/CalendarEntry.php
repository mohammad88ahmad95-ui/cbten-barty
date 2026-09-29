<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CalendarEntry extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime',
        'hold_expires_at' => 'datetime'];
    public function resource() { return $this->belongsTo(BookableResource::class); }
    public function booking() { return $this->belongsTo(Booking::class); }
}
