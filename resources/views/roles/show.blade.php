@extends($rbacLayout)
@section('title', __('rbac::roles.role_details'))
@section('content')

    <section class="content container-fluid">
        <h2>{!! __('rbac::roles.role_details') !!}: {{ $role->name }}</h2>

        <div class="row mb-3">
            <div class="col-12">
                <form action="{{ route('delete_role') }}" method="post">
                    <a class="btn btn-success" href="{{ route('edit_role', ['role' => $role->id]) }}" title="{!! __('rbac::main.edit') !!}">{!! __('rbac::roles.edit_role') !!}</a>
                    <input type="submit" class="btn btn-danger" value="{!! __('rbac::roles.delete_role') !!}" title="{!! __('rbac::main.delete') !!}" onclick="return confirm('{!! __('rbac::main.delete_confirm') !!}')">
                    <input type="hidden" value="{{ $role->id }}" name="items[]">
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
                            <td>{{ $role->name }}</td>
                        </tr>
                        <tr>
                            <td>{!! __('rbac::main.slug') !!}</td>
                            <td>{{ $role->slug }}</td>
                        </tr>
                        <tr>
                            <td>{!! __('rbac::main.description') !!}</td>
                            <td>{{ $role->description }}</td>
                        </tr>
                        <tr>
                            <td>{!! __('rbac::permissions.permissions') !!}</td>
                            <td>
                                <ul class="list-group list-group-flush">
                                    @foreach($role->permissions as $permission)
                                        <li class="list-group-item p-2">
                                            <a href="{{ route('show_permission', ['id' => $permission->id]) }}">
                                                {{ $permission->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
