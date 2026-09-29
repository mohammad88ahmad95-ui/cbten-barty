<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProviderProfile extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['business_name_i18n' => 'array', 'description_i18n' => 'array',
        'working_hours' => 'array', 'booking_policy_i18n' => 'array',
        'verified_at' => 'datetime', 'featured_until' => 'datetime'];
    public function owner() { return $this->belongsTo(User::class, 'owner_user_id'); }
    public function memberships() { return $this->hasMany(ProviderMembership::class); }
    public function documents() { return $this->hasMany(ProviderDocument::class); }
    public function applicationHistory() { return $this->hasMany(ProviderApplicationHistory::class); }
    public function services() { return $this->hasMany(Service::class); }
    public function resources() { return $this->hasMany(BookableResource::class); }
    public function paymentAccounts() { return $this->hasMany(ProviderPaymentAccount::class); }
    public function gallery() { return $this->belongsToMany(MediaAsset::class, 'provider_gallery', 'provider_id', 'asset_id')->withPivot('sort_order', 'is_cover'); }
    public function category() { return $this->belongsTo(Category::class); }
    public function city() { return $this->belongsTo(City::class); }
    public function area() { return $this->belongsTo(Area::class); }
    public function amenities() { return $this->belongsToMany(Amenity::class, 'provider_amenities'); }
}
