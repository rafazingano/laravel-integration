<?php

namespace ConfrariaWeb\Integration\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IntegrationController extends Controller
{

    public function __construct()
    {
        //ini_set('memory_limit', -1);
    }

    public function executeAll()
    {
        resolve('IntegrationService')->executeAll();
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function receive($code)
    {
        try {
            $parameters = request()->all();
            $receive = resolve('IntegrationService')->receive($code, $parameters);
            return response('OK', 200);
        } catch (Exception $exception) {
            return response($exception->getMessage(), 406);
        }
    }

    public function index()
    {
        $data['integrations'] = resolve('IntegrationService')->all();
        return view(config('cw_integration.views') . 'integrations.index', $data);
    }

    public function create()
    {
        $data['services'] = collect(config('cw_integration.services'))->pluck('name', 'slug');
        $data['types'] = resolve('IntegrationTypeService')->pluck();
        $data['users'] = [];
        $data['scheduleFrequencyOptions'] = resolve('ScheduleFrequencyOptionService')->pluck();
        return view(config('cw_integration.views') . 'integrations.create', $data);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $data['user_id'] ?? Auth::id();
        $data['code'] = $data['code'] ?? Str::random(20);
        $integration = resolve('IntegrationService')->create($data);
        return redirect()
            ->route('admin.integrations.edit', $integration->id)
            ->with('status', 'Integração criada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['integration'] = resolve('IntegrationService')->find($id);

        if ($data['integration']->options['data']['user_id']) {
            $data['api_token'] = resolve('UserService')->find($data['integration']->options['data']['user_id'])->api_token;
        }

        $data['services'] = collect(config('cw_integration.services'))->pluck('name', 'slug');
        $data['types'] = resolve('IntegrationTypeService')->pluck();
        $data['scheduleFrequencyOptions'] = resolve('ScheduleFrequencyOptionService')->pluck();
        $data['user']['roles'] = resolve('RoleService')->pluck();
        if (isset($data['integration']->options['data']['user_id'])) {
            $option_data_user = resolve('UserService')->find($data['integration']->options['data']['user_id']);
            $data['option_data_user'] = $option_data_user->pluck('name', 'id');
        }
        //$data['user']['statuses'] = resolve('StatusService')->pluck();
        //$data['user']['steps'] = resolve('StepService')->pluck();
        $IntegrationService = resolve('IntegrationService');
        $IntegrationService->setId($id);
        //dd($IntegrationService->fieldsInside());
        $data['inside_fields'] = $IntegrationService->fieldsInside()->prepend('Escolha um opção', '');
        $data['outside_fields'] = $IntegrationService->fieldsOutside()->prepend('Escolha um opção', '');

        return view(config('cw_integration.views') . 'integrations.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $integration = resolve('IntegrationService')->update($request->all(), $id);
        return redirect()
            ->route('admin.integrations.edit', $integration->id)
            ->with('status', 'Integração editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $integration = resolve('IntegrationService')->destroy($id);
        return redirect()
            ->route('admin.integrations.index')
            ->with('status', 'Integração deletada com sucesso!');
    }
}
