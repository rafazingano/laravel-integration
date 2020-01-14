<?php

namespace MeridienClube\Meridien\Services\Contracts;

interface IntegrationContract
{

    public function set(array $data);

    public function get();

    public function fields();

    public function test();
}
