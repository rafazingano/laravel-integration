<?php

namespace MeridienClube\Meridien\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationData extends Model
{
    protected $casts = [
        'content' => 'collection'
    ];

    protected $fillable = [
        'integration_id',
        'integrationdataable_id',
        'integrationdataable_type',
        'content',
    ];

    /**
     * Get the owning integrationdataable model.
     */
    public function integrationable()
    {
        return $this->morphTo();
    }

    public function integration()
    {
        return $this->belongsTo('MeridienClube\Meridien\Integration');
    }
}
