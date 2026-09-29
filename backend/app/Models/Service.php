<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Service extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['title_i18n' => 'array', 'description_i18n' => 'array',
        'rules_i18n' => 'array'];
    public function provider() { return $this->belongsTo(ProviderProfile::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function bookingConfig() { return $this->hasOne(ServiceBookingConfig::class); }
    public function packages() { return $this->hasMany(Package::class); }
    public function media() { return $this->belongsToMany(MediaAsset::class, 'service_media', 'service_id', 'asset_id')->withPivot('sort_order'); }
    public function resources() { return $this->belongsToMany(BookableResource::class, 'service_resources'); }
    public function bookings() { return $this->hasMany(Booking::class); }
    public function searchDocument() { return $this->hasOne(ServiceSearchDocument::class); }
}
