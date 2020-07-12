@extends($rbacLayout)
@section('title', __('rbac::users.user_details'))
@section('content')

    <section class="content container-fluid">
        <h2>{!! __('rbac::users.user_details') !!}: {{ $user->memberName }}</h2>

        <div class="row mb-3">
            <div class="col-12">
                <form action="{{ route('delete_user') }}" method="post">
                    <a class="btn btn-success" href="{{ route('edit_user', ['id' => $user->memberKey]) }}" title="{!! __('rbac::main.edit') !!}">{!! __('rbac::users.assign_roles') !!}</a>
                    @can(Itstructure\LaRbac\Models\Permission::DELETE_MEMBER_FLAG, $user->memberKey)
                        <input type="submit" class="btn btn-danger" value="{!! __('rbac::users.delete_user') !!}" title="{!! __('rbac::main.delete') !!}" onclick="return confirm('{!! __('rbac::main.delete_confirm') !!}')">
                        <input type="hidden" value="{{ $user->memberKey }}" name="items[]">
                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                    @endcan
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
                            <td>{!! __('rbac::users.name') !!}</td>
                            <td>{{ $user->memberName }}</td>
                        </tr>
                        <tr>
                            <td>{!! __('rbac::roles.roles') !!}</td>
                            <td>
                                <ul class="list-group list-group-flush">
                                    @foreach($user->roles as $role)
                                        <li class="list-group-item p-2">
                                            <a href="{{ route('show_role', ['id' => $role->id]) }}">{{ $role->name }}</a>
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
