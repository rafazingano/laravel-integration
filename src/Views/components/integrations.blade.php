<div class="table-responsive-md">
    <table class="integrations_table table table-striped" style="width:100%">
        <thead>
        <tr>
            <th>{{ trans('Integração') }}</th>
            <th>{{ trans('Tipo') }}</th>
            <th>{{ trans('Data de criação') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($integrationsData as $integrationData)
            <tr>
                <td>{{ $integrationData->integration->title }}</td>
                <td>{{ $integrationData->integration->type->name }}</td>
                <td>{{ $integrationData->created_at->format('d/m/Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3"><p>Este usuário não possui integrações.</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

