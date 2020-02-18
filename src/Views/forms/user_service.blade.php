@inject('userStatusService', 'ConfrariaWeb\User\Services\UserStatusService')
@inject('userStepService', 'ConfrariaWeb\Crm\Services\StepService')
@inject('roleService', 'ConfrariaWeb\Entrust\Services\RoleService')

<h4>Campos padrão caso nao seja vinculado</h4>

<div class="form-group">
    <label class="control-label">Nome </label>
    {!! Form::text('options[data][name]', $integration->options['data']['name']?? '', ['class' => 'form-control', 'placeholder' => 'Nome']) !!}
</div>

<div class="form-group">
    <label class="control-label">Status </label>
    {{ Form::select2('options[data][status_id]', isset($integration->options['data']['status_id'])? $userStatusService->where(['id' => $integration->options['data']['status_id']])->pluck() : [], $integration->options['data']['status_id']?? NULL, ['id' => 'data_user_status', 'class' => 'form-control'], ['server_side' => ['route' => 'api.users.statuses.select2']]) }}
</div>

<div class="form-group">
    <label class="control-label">Fase</label>
    {{ Form::select2('options[data][sync][steps][]', isset($integration->options['data']['sync']['steps'])? $userStepService->whereIn('id', $integration->options['data']['sync']['steps'])->pluck() : [], $integration->options['data']['sync']['steps']?? NULL, ['id' => 'data_user_step', 'class' => 'form-control', 'multiple'=>true], ['server_side' => ['route' => 'api.crm.steps.select2']]) }}
</div>

<div class="form-group">
    <label class="control-label">Perfil</label>
    {{ Form::select2('options[data][sync][roles][]', isset($integration->options['data']['sync']['roles'])? $roleService->whereIn('id', $integration->options['data']['sync']['roles'])->pluck() : [], $integration->options['data']['sync']['roles']?? NULL, ['id' => 'data_role', 'class' => 'form-control', 'multiple'=>true], ['server_side' => ['route' => 'api.entrusts.roles.select2']]) }}
</div>

<div class="form-group">
    <label class="control-label">Senha </label>
    {!! Form::text('options[data][password]', $integration->options['data']['password']?? NULL, ['class' => 'form-control', 'placeholder' => '********']) !!}
</div>

<div class="form-group">
    <label class="control-label">Confirme a senha</label>
    {!! Form::text('options[data][password_confirmation]', $integration->options['data']['password_confirmation']?? NULL, ['class' => 'form-control', 'placeholder' => '********']) !!}
</div>
