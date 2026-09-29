<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Package extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['name_i18n' => 'array', 'description_i18n' => 'array'];
    public function service() { return $this->belongsTo(Service::class); }
    public function items() { return $this->hasMany(PackageItem::class); }
}
