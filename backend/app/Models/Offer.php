<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Offer extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['title_i18n' => 'array', 'description_i18n' => 'array',
        'conditions_i18n' => 'array', 'starts_at' => 'datetime', 'ends_at' => 'datetime'];
}
