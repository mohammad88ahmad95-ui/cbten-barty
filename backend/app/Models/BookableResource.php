<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BookableResource extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['name_i18n' => 'array'];
    public function provider() { return $this->belongsTo(ProviderProfile::class); }
    public function rules() { return $this->hasMany(AvailabilityRule::class); }
    public function exceptions() { return $this->hasMany(AvailabilityException::class); }
    public function calendarEntries() { return $this->hasMany(CalendarEntry::class); }
    public function services() { return $this->belongsToMany(Service::class, 'service_resources'); }
}
