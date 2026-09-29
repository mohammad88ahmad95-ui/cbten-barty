<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BookingItem extends Model {
    use HasUuids;
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = ['title_snapshot_i18n' => 'array', 'description_snapshot_i18n' => 'array'];
}
