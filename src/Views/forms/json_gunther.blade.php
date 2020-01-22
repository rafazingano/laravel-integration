<div class="form-group">
    <label class="control-label">URL do JSON <span class="required"> * </span></label>
    {!! Form::text('options[data][url]', isset($integration->options['data']['url'] )? $integration->options['data']['url'] : null, ['class' => 'form-control', 'placeholder' => 'Digite a URL do JSON', 'required']) !!}
    <small>
        Para que as colunas de relacionamento entre o sistema e a integração apareçam é importante salvar
        a url do json antes. os campos são buscados do primero nivel dos dados do json.
    </small>
</div>
