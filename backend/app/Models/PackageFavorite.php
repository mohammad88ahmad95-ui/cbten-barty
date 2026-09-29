<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PackageFavorite extends Model {
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['created_at' => 'datetime'];
    public function package() { return $this->belongsTo(Package::class); }
}
