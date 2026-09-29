<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ServiceBookingConfig extends Model {
    use HasUuids;
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
}
