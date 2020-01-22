<div class="form-row integration_field integration_field_matrix" data-index="{{ $loopindex }}">
    <div class="col-md-5">
        <div class="form-group">
            <label class="control-label">Coluna externa </label>
            {{ Form::select('outside[' . $loopindex . ']', $outside_fields, isset($field)? $field->outside : null, ['class' => 'form-control outside']) }}
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label class="control-label">Coluna interna</label>
            {{ Form::select('inside[' . $loopindex . ']', $inside_fields, isset($field)? $field->inside : null, ['class' => 'form-control inside']) }}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group text-right">
            <button type="button" class="btn btn-danger text-center integration_field_remove" style="margin-top: 25px;">
                <i class="flaticon-delete"></i>
            </button>
        </div>
    </div>
</div>
