<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProviderSearchDocument extends Model {
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'provider_id';
    public $timestamps = true;
    protected $guarded = [];
}
