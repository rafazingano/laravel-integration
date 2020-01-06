<?php


namespace ConfrariaWeb\Integration\Repositories;

use ConfrariaWeb\Integration\Models\IntegrationType;
use ConfrariaWeb\Integration\Contracts\IntegrationTypeContract;
use ConfrariaWeb\Vendor\Traits\RepositoryTrait;

class IntegrationTypeRepository implements IntegrationTypeContract
{
    use RepositoryTrait;

    public function __construct(IntegrationType $integrationType)
    {
        $this->obj = $integrationType;
    }

}
