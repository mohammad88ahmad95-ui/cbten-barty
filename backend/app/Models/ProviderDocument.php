<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProviderDocument extends Model {
    use HasUuids;
    protected $guarded = [];
    public function asset() { return $this->belongsTo(MediaAsset::class); }
}
