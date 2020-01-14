<?php

namespace MeridienClube\Meridien\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class IntegrationUser extends Pivot
{
    protected $casts = [
        'content' => 'array'
    ];
    protected $fillable = [
        'created_at',
        'user_id',
        'integration_id',
        'content',
        'updated_at'
    ];
}
