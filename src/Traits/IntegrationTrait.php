<?php

namespace ConfrariaWeb\Integration\Traits;

trait IntegrationTrait
{

    public function integrations()
    {
        return $this->belongsToMany('ConfrariaWeb\Integration\Models\Integration');
    }

    public function integrationData()
    {
        return $this->morphMany('ConfrariaWeb\Integration\Models\IntegrationData', 'integrationdataable');
    }

}
