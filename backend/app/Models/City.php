<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class City extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['name_i18n' => 'array'];
    public function areas() { return $this->hasMany(Area::class); }
}
