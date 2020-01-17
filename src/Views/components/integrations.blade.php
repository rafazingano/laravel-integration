<div class="table-responsive-md">
    <table class="integrations_table table table-striped" style="width:100%">
        <thead>
        <tr>
            <th>{{ trans('meridien.integration') }}</th>
            <th>{{ trans('meridien.integrations.type') }}</th>
            <th>{{ trans('meridien.date') }}</th>
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

