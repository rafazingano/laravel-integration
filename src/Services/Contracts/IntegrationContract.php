<?php

namespace ConfrariaWeb\Integration\Services\Contracts;

interface IntegrationContract
{

    public function set(array $data);

    public function get();

    public function fields();

    public function test();
}
