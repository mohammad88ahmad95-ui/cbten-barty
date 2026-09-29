<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Area extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['name_i18n' => 'array'];
    public function city() { return $this->belongsTo(City::class); }
}
