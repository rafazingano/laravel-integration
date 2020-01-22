<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Listagem de integrações
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-section">
            <div class="kt-section__content">

                <table class="table table-striped table-hover" id="users_datatable">
                    <thead>
                        <tr>
                            <th width="">Code</th>
                            <th width="">Interação</th>
                            <th width="">Tipo</th>
                            <th width="">Titulo</th>
                            <th width="">Usúario</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($integrations as $integration)
                            <tr>
                                <td>{{ $integration->code }}</td>
                                <td>{{ $integration->interaction }}</td>
                                <td>{{ $integration->type->name }}</td>
                                <td>{{ $integration->title }}</td>
                                <td>{{ $integration->user->name }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="...">
                                        @permission('integrations.show')
                                        <a href="{{ route('admin.integrations.show', $integration->id) }}"
                                            class="btn btn-clean btn-icon btn-label-primary btn-icon-md " title="View">
                                            <i class="la la-eye"></i>
                                        </a>
                                        @endpermission
                                        @permission('integrations.edit')
                                        <a href="{{ route('admin.integrations.edit', $integration->id) }}"
                                            class="btn btn-clean btn-icon btn-label-success btn-icon-md " title="Edit">
                                            <i class="la la-edit"></i>
                                        </a>
                                        @endpermission
                                        @permission('integrations.destroy')
                                        <a href="javascript:void(0);"
                                            onclick="event.preventDefault();
                                            if(!confirm('Tem certeza que deseja deletar este item?')){ return false; }
                                            document.getElementById('delete-role-{{ $integration->id }}').submit();"
                                            class="btn btn-clean btn-icon btn-label-danger btn-icon-md "
                                            title="Deletar">
                                                <i class="la la-remove"></i>
                                        </a>
                                        <form
                                            action="{{ route('admin.integrations.destroy', $integration->id) }}"
                                            method="POST" id="delete-role-{{ $integration->id }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            @csrf
                                        </form>
                                        @endpermission
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
