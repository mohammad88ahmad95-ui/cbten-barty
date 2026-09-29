<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProviderPaymentAccount extends Model {
    use HasUuids;
    protected $guarded = [];
    protected $casts = ['instructions_i18n' => 'array'];
    public function provider() { return $this->belongsTo(ProviderProfile::class); }
}
