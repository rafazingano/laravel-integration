<?PHP

namespace ConfrariaWeb\Integration\Services;

use ConfrariaWeb\Integration\Contracts\IntegrationContract;
use ConfrariaWeb\Vendor\Traits\ServiceTrait;

class IntegrationService
{
    use ServiceTrait;

    protected $id;

    public function __construct(IntegrationContract $integration)
    {
        $this->obj = $integration;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    function pluck()
    {
        return $this->obj->all()->pluck('title', 'id');
    }

    public function execute($integration, $parameters = null)
    {
        if (isset($integration->key_field) && !$integration->key_field->isEmpty()) {
            $convertData = $this->convertData($integration, $parameters);;

            foreach ($convertData as $objData) {
                $key_field = NULL;
                $findBy = NULL;
                $obj = NULL;

                foreach ($integration->key_field as $kf) {
                    $key_field = $kf;
                    $data_get_key_field = data_get($objData, $key_field);
                    $data_get_key_field = (!isset($data_get_key_field) && isset($objData['sync'])) ? data_get($objData['sync'], $key_field) : $data_get_key_field;
                    $data_get_key_field = (!isset($data_get_key_field) && isset($objData['attach'])) ? data_get($objData['attach'], $key_field) : $data_get_key_field;
                    $findBy = resolve($integration->service)->findBy($key_field, $data_get_key_field);
                    if ($findBy) {
                        break;
                    }
                }

                if ($integration->update && $integration->create) {
                    $obj = resolve($integration->service)->updateOrCreate($objData, $key_field);
                }
                if ($integration->update && !$integration->create && isset($data_get_key_field)) {
                    if ($findBy) {
                        $obj = resolve($integration->service)->update($objData, $findBy->id);
                    }
                }
                if (!$integration->update && $integration->create && isset($data_get_key_field)) {
                    if (!$findBy) {
                        $obj = resolve($integration->service)->create($objData);
                    }
                }
                if (isset($obj)) {
                    $this->integrationDataCreate($integration, $obj, $objData);
                }
                unset($obj);
            }
            return true;
        }
        return false;
    }

    protected function integrationDataCreate($integration, $obj, $data)
    {
        if (isset($integration) && isset($obj)) {
            $integrationData['integration_id'] = $integration->id;
            $integrationData['content'] = $data;
            $obj->integrationData()->create($integrationData);
        }
    }

    public function schedule($schedule)
    {
        foreach ($this->obj->whereIn('interaction', ['search', 'submit'])->get() as $integration) {
            $frequency = $integration->frequency->frequency;
            $schedule->call(function () use ($integration) {
                $this->execute($integration);
            })->{$frequency}()
                ->name($integration->code)
                ->withoutOverlapping();
        }
    }

    public function receive($code, $parameters)
    {
        $integration = $this->obj->findBy('code', $code);
        if ($integration) {
            $execute = $this->execute($integration, $parameters);
            return true;
        }
        return false;
    }

    public function executeId($id)
    {
        $integration = $this->obj->find($id);
        $this->execute($integration);
    }

    public function executeAll()
    {
        foreach ($this->obj->all() as $integration) {
            $this->execute($integration);
        }
    }

    protected function convertData($integration, $parameters = null)
    {
        $data = isset($integration->options['data']) ? $integration->options['data'] : [];
        $serviceType = resolve($integration->type->service);
        if (isset($parameters)) {
            $data = [$data, $parameters];
        }
        $serviceType->set($data);
        $fields = $integration->fields->mapWithKeys(function ($item) {
            return [$item['outside'] => $item['inside']];
        })->toArray();
        $contentMap = $serviceType->get()->map(function ($item, $key) use ($fields) {
            $r = [];
            foreach ($item as $key => $value) {
                if (in_array($key, array_keys($fields)) && isset($fields[$key])) {
                    $r[$fields[$key]] = $value;
                    $r['syncWithoutDetaching']['optionsValues'][$fields[$key]] = $value;
                } else {
                    $r[$key] = $value;
                }
            }
            return $r;
        })->toArray();

        return $contentMap;
    }

    public function fieldsInside($integration_id)
    {
        $integration = $this->obj->find($integration_id);
        return resolve($integration->service)->fields();
    }

    public function fieldsOutside($integration_id)
    {
        $integration = $this->obj->find($integration_id);
        $data = isset($integration->options['data']) ? $integration->options['data'] : [];
        $serviceType = resolve($integration->type->service);
        $serviceType->set($data);
        //dd($serviceType->fields());
        return $serviceType->fields();
    }

}
