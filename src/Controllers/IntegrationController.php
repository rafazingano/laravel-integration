<?php

namespace ConfrariaWeb\Integration\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntegrationController extends Controller
{


    /**
     * IntegrationController constructor.
     */
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['integrations'] = resolve('IntegrationService')->all();
        return view('integrations.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['services'] = resolve('ServiceService')->pluck();
        $data['types'] = resolve('IntegrationTypeService')->pluck();
        $data['users'] = resolve('UserService')->pluck();
        $data['scheduleFrequencyOptions'] = resolve('ScheduleFrequencyOptionService')->pluck();
        return view('integrations.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $integration = resolve('IntegrationService')->create($request->all());
        return redirect()
            ->route('integrations.edit', $integration->id)
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['integration'] = resolve('IntegrationService')->find($id);

        if ($data['integration']->options['data']['user_id']) {
            $data['api_token'] = resolve('UserService')->find($data['integration']->options['data']['user_id'])->api_token;
        }

        $data['services'] = resolve('ServiceService')->pluck();
        $data['types'] = resolve('IntegrationTypeService')->pluck();
        $data['users'] = resolve('UserService')->pluck();
        $data['scheduleFrequencyOptions'] = resolve('ScheduleFrequencyOptionService')->pluck();
        $data['user']['roles'] = resolve('RoleService')->pluck();
        $data['user']['statuses'] = resolve('StatusService')->pluck();
        $data['user']['steps'] = resolve('StepService')->pluck();
        $IntegrationService = resolve('IntegrationService');
        $IntegrationService->setId($id);
        //dd($IntegrationService->fieldsInside());
        $data['inside_fields'] = $IntegrationService->fieldsInside()->prepend('Escolha um opção', '');
        $data['outside_fields'] = $IntegrationService->fieldsOutside()->prepend('Escolha um opção', '');

        return view('integrations.edit', $data);
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
            ->route('integrations.edit', $integration->id)
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
        //
    }
}
