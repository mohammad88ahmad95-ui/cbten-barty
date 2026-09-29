<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Event extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['event_date' => 'date', 'budget_amount' => 'integer'];
    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function eventType() { return $this->belongsTo(EventType::class); }
    public function requirements() { return $this->hasMany(EventServiceRequirement::class); }
}
