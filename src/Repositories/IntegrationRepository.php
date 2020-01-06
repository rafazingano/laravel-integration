<?PHP

namespace ConfrariaWeb\Integration\Repositories;

use ConfrariaWeb\Integration\Contracts\IntegrationContract;
use ConfrariaWeb\Integration\Models\Integration;
use ConfrariaWeb\Vendor\Traits\RepositoryTrait;
use Illuminate\Support\Facades\Log;

class IntegrationRepository implements IntegrationContract
{

    use RepositoryTrait;

    function __construct(Integration $integration)
    {
        $this->obj = $integration;
    }


    public function update(array $data, $id)
    {
        if (!property_exists($this, 'obj')) {
            Log::error('Missing OBJ attribute in RepositoryTraitUpdate');
            throw new RuntimeException('Missing OBJ attribute in RepositoryTraitUpdate');
        }
        $update = $this->obj->find($id);
        $update->update($data);
        $this->updateOrCreateFields($update, $data);
        $this->relationships($update, $data);
        return $update;
    }

    public function destroy($id)
    {
        return $this->integration->destroy($id);
    }

    public function where(array $data, int $take = null)
    {
        $w = $this->obj;
        if(isset($data['type_id'])){
            $w = $w->where('type_id', $data['type_id']);
        }
        if(isset($data['user_id'])){
            $w = $w->where('user_id', $data['user_id']);
        }
        if(isset($data['types']) && is_array($data['types'])){
            $w = $w->whereIn('type_id', $data['types']);
        }
        if(isset($data['interactions']) && is_array($data['interactions'])){
            $w = $w->whereIn('interaction', $data['interactions']);
        }
        //$w = isset($take)? $w->paginate($take) : $w->get();
        return $w;
    }
/*
    public function whereIn(string $column, $data = [], $take = null)
    {
        $w = $this->integration;
        $w = $w->whereIn($column, $data);
        $w = isset($take)? $w->paginate($take) : $w->get();
        return $w;
    }
*/
    protected function updateOrCreateFields($obj, $data){
        if(isset($data['inside']) && isset($data['outside'])){
            $data['inside'] = array_unique($data['inside']);
            $fields = [];
            for($i=0; $i < count($data['inside']); $i++){
                if(isset($data['inside'][$i]) && isset($data['outside'][$i])) {
                    $fields[] = ['inside' => $data['inside'][$i], 'outside' => $data['outside'][$i]];
                }
            }
            $obj->fields()->delete();
            $obj->fields()->createMany($fields);
        }
    }

}
