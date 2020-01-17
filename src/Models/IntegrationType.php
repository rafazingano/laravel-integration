<?php

namespace ConfrariaWeb\Integration\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationType extends Model
{
    protected $fillable = [
        'code',
        'id',
        'name',
        'service'
    ];

    public function users()
    {
        return $this->belongsToMany(
    'App\User',
    'integration_user',
    'integration_id',
    'user_id'
        );
    }
}
