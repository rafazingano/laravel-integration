<?php

namespace ConfrariaWeb\Integration\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationField extends Model
{

    protected $table = 'integration_fields';

    protected $fillable = [
        'integration_id',
        'outside',
        'inside',
        'create',
        'update'
    ];
}
