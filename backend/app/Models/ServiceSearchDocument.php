<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ServiceSearchDocument extends Model {
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'service_id';
    public $timestamps = true;
    protected $guarded = [];
}
