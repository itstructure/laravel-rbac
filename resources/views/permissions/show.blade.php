@extends($rbacLayout)
@section('title', __('rbac::permissions.permission_details'))
@section('content')

    <section class="content container-fluid">
        <h2>{!! __('rbac::permissions.permission_details') !!}: {{ $permission->name }}</h2>

        <div class="row mb-3">
            <div class="col-12">
                <form action="{{ route('delete_permission') }}" method="post">
                    <a class="btn btn-success" href="{{ route('edit_permission', ['permission' => $permission->id]) }}" title="{!! __('rbac::main.edit') !!}">{!! __('rbac::permissions.edit_permission') !!}</a>
                    <input type="submit" class="btn btn-danger" value="{!! __('rbac::permissions.delete_permission') !!}" title="{!! __('rbac::main.delete') !!}" onclick="return confirm('{!! __('rbac::main.delete_confirm') !!}')">
                    <input type="hidden" value="{{ $permission->id }}" name="items[]">
                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                </form>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>{!! __('rbac::main.attribute') !!}</th>
                            <th>{!! __('rbac::main.value') !!}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{!! __('rbac::main.name') !!}</td>
                            <td>{{ $permission->name }}</td>
                        </tr>
                        <tr>
                            <td>{!! __('rbac::main.slug') !!}</td>
                            <td>{{ $permission->slug }}</td>
                        </tr>
                        <tr>
                            <td>{!! __('rbac::main.description') !!}</td>
                            <td>{{ $permission->description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
