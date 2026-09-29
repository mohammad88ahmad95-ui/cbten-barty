<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PackageItem extends Model {
    use HasUuids;
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = ['label_i18n' => 'array'];
}
