<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Tipo de integração </label>
            {{ Form::select('type_id', $types, isset($integration)? $integration->type_id : null, ['class' => 'form-control kt-select2']) }}
        </div>
        <div class="form-group">
            <label class="control-label">Titulo <span class="required"> * </span></label>
            {!! Form::text('title', isset($role)? $role->titulo : null, ['class' => 'form-control', 'placeholder' => 'Digite o titulo', 'required']) !!}
        </div>
        <div class="form-group">
            <label class="control-label"> Serviço para atualizar </label>
            {{ Form::select('service', $services, isset($integration)? $integration->service_id : null, ['class' => 'form-control kt-select2']) }}
        </div>
        <div class="form-row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label"> Permitir criar </label>
                    {{ Form::select('create', [1 => trans('meridien.yes'), 0 => trans('meridien.no')], isset($integration)? $integration->create : null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label"> Permitir atualizar </label>
                    {{ Form::select('update', [1 => trans('meridien.yes'), 0 => trans('meridien.no')], isset($integration)? $integration->update : null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label"> Interação </label>
                    {{ Form::select('interaction', ['search' => trans('meridien.search'), 'receive' => trans('meridien.Receber'), 'submit' => trans('meridien.Enviar')], isset($integration)? $integration->interaction : null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label"> Frequência </label>
            {{ Form::select('frequency_id', $scheduleFrequencyOptions, isset($integration)? $integration->frequency_id : null, ['class' => 'form-control kt-select2']) }}
        </div>

        <div class="form-group">
            <label class="control-label"> Usuário que executa a ação </label>
            {{ Form::select2('options[data][user_id]', $users?? [], $users?? [], ['id' => 'data_user_id', 'class' => 'form-control'], ['server_side' => ['route' => 'api.users.select2']]) }}
            <small>
                Esta informaçãos era usada por exemplo para informar no historico o usuario que
                executou, pode-se criar um ususario para o sistema, assim fica facil reconhecer
                quando é uma ação do sistema e quando é um usuário.
            </small>
        </div>

    </div>
    <div class="col-md-6">
        @isset($integration->type)
            @includeIf('integration::forms.' . $integration->type->code)
        @endif
        @isset($integration->service)
            @includeIf('integration::forms.' . Str::snake($integration->service))
        @endif
        @if(isset($inside_fields) && isset($outside_fields) && !empty($outside_fields) && count($outside_fields) > 1)
            <div class="form-group">
                <label class="control-label">Campo chave <span class="required"> * </span></label>
                {{ Form::select('key_field[]', $inside_fields, isset($integration)? $integration->key_field : null, ['class' => 'form-control', 'placeholder' => 'Selecione o campo chave', 'required', 'multiple']) }}
            </div>
            <h4>Interligue abaixo as colunas</h4>
            @php
                $loopindex = 0;
            @endphp
            @foreach($integration->fields as $field)
                @include('integration::partials.form_fields')
                @php
                    $loopindex++;
                    unset($field)
                @endphp
            @endforeach
            @include('integration::partials.form_fields')
            <div id="integration_fields"></div>
            <div class="form-row integration_field">
                <div class="col-md-10">
                </div>
                <div class="col-md-2">
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-primary text-center" id="integration_field_add">
                            <i class="flaticon2-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                <div class="alert-text">
                    <h4 class="alert-heading">Opsssss!</h4>
                    <p>
                        Esta integração não esta completa pois falta o arquivo para integrar.
                    </p>
                    <hr>
                    <p class="mb-0">
                        Ou o arquivo não foi adicionado ou ele é grande demais
                        e não pode ser lido pelo sistema.
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="kt-form__actions float-right">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('admin.integrations.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).on('click', '#integration_field_add', function (e) {
            e.preventDefault();
            var index = $('.integration_field_matrix:last').attr('data-index');
            index = parseInt(index) + 1;
            var html = $('.integration_field_matrix:last').clone();
            html.attr('data-index', index);

            html.find('select.outside').each(function () {
                this.name = 'outside[' + index + ']';
            });
            html.find('select.inside').each(function () {
                this.name = 'inside[' + index + ']';
            });

            html.appendTo($('#integration_fields'));
        });

        $(document).on('click', '.integration_field_remove', function (e) {
            console.log('teste');
            $(this).parents('.integration_field').remove();
        });

    </script>
@endpush
