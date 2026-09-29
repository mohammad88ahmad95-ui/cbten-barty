<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class QuotationItem extends Model {
    use HasUuids;
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = ['title_i18n' => 'array', 'description_i18n' => 'array'];
}
