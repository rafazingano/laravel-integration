<?php

namespace ConfrariaWeb\Integration\Services;

use ConfrariaWeb\Integration\Contracts\IntegrationTypeContract;
use ConfrariaWeb\Vendor\Traits\ServiceTrait;

class IntegrationTypeService
{
    use ServiceTrait;

    public function __construct(IntegrationTypeContract $integrationType)
    {
        $this->obj = $integrationType;
    }

}
