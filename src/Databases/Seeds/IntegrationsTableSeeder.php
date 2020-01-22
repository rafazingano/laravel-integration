<?php

use ConfrariaWeb\Integration\IntegrationType;
use Illuminate\Database\Seeder;

class IntegrationsTableSeeder extends Seeder
{
    public function run()
    {
        $integrationsTypes = $this->getIntegrations();

        foreach ($integrationsTypes as $type) {
            IntegrationType::create($type);

            $this->command->info("Tipo de Integração " . $type['name'] . " criada.");
        }
    }

    private function getIntegrations()
    {
        return [
            'json_gunther' => [
                'name' => 'Arquivo JSON - Gunther',
                'code' => 'json_gunther',
                'service' => 'IntegrationJsonGuntherService'
            ],
            'json' => [
                'name' => 'Arquivo JSON',
                'code' => 'json',
                'service' => 'IntegrationJsonService'
            ],
            'rd_station' => [
                'name' => 'RD Station',
                'code' => 'rd_station',
                'service' => 'IntegrationRdStationService'
            ]
        ];
    }
}
