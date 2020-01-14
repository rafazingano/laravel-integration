<?php

namespace MeridienClube\Meridien\Models;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    protected $fillable = [
        'frequency_id',
        'type_id',
        'service_id',
        'user_id',
        'code',
        'title',
        'key_field',
        'options',
        'interaction',
        'create',
        'update'
    ];

    protected $casts = [
        'key_field' => 'collection',
        'options' => 'collection'
    ];

    public function user()
    {
        return $this->belongsTo('MeridienClube\Meridien\User');
    }

    public function type()
    {
        return $this->belongsTo('MeridienClube\Meridien\IntegrationType');
    }

    public function service()
    {
        return $this->belongsTo('MeridienClube\Meridien\Service');
    }

    public function users()
    {
        return $this->belongsToMany('MeridienClube\Meridien\User');
    }

    public function fields()
    {
        return $this->hasMany('MeridienClube\Meridien\IntegrationField');
    }

    public function frequency(){
        return $this->belongsTo('MeridienClube\Meridien\ScheduleFrequencyOption', 'frequency_id');
    }
}
