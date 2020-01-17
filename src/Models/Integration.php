<?php

namespace ConfrariaWeb\Integration\Models;

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
        return $this->belongsTo('App\User');
    }

    public function type()
    {
        return $this->belongsTo('ConfrariaWeb\Integration\Models\IntegrationType');
    }

    public function service()
    {
        return $this->belongsTo('ConfrariaWeb\Integration\Models\Service');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function fields()
    {
        return $this->hasMany('ConfrariaWeb\Integration\Models\IntegrationField');
    }

    public function frequency(){
        return $this->belongsTo('ConfrariaWeb\Integration\Models\ScheduleFrequencyOption', 'frequency_id');
    }
}
