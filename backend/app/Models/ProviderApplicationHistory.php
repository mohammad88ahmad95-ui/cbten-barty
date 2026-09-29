<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProviderApplicationHistory extends Model {
    use HasUuids;
    protected $guarded = [];
    public function actor() { return $this->belongsTo(User::class, 'actor_id'); }
}
