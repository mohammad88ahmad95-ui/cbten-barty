<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EventServiceRequirement extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['title_i18n' => 'array'];
    public function event() { return $this->belongsTo(Event::class); }
}
