<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model {
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['config' => 'array'];
}
