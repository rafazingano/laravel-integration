<h4>Campos padrão caso nao seja vinculado</h4>

<div class="form-group">
    <label class="control-label">Nome </label>
    {!! Form::text('options[data][name]', NULL, ['class' => 'form-control', 'placeholder' => 'Nome']) !!}
</div>

<div class="form-group">
    <label class="control-label">Status </label>
    {{ Form::select2('options[data][status_id]', [], [], ['id' => 'data_user_status', 'class' => 'form-control'], ['server_side' => ['route' => 'api.users.status.select2']]) }}
</div>

<div class="form-group">
    <label class="control-label">Fase</label>
    {{ Form::select('options[data][sync][steps][]', resolve('UserStepService')->pluck(), null, ['class' => 'form-control kt-select2', 'multiple'=>true]) }}
</div>

<div class="form-group">
    <label class="control-label">Perfil</label>
    {{ Form::select('options[data][sync][roles][]', $user['roles'], null, ['class' => 'form-control kt-select2', 'multiple'=>true]) }}
</div>

<div class="form-group">
    <label class="control-label">Senha </label>
    {!! Form::text('options[data][password]', NULL, ['class' => 'form-control', 'placeholder' => '********']) !!}
</div>

<div class="form-group">
    <label class="control-label">Confirme a senha</label>
    {!! Form::text('options[data][password_confirmation]', NULL, ['class' => 'form-control', 'placeholder' => '********']) !!}
</div>
