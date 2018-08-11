@section('title', 'Roles')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="role-index">

            <h1>List roles</h1>

            <p><a class="btn btn-success" href="{{ route('create_role') }}">Create role</a></p>

            <form action="{{ route('delete_role') }}" method="post">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Permissions</th>
                            <th class="action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <a href="{{ route('show_role', ['id' => $role->id]) }}">{{ $role->name }}</a>
                            </td>
                            <td>
                                {{ $role->description }}
                            </td>
                            <td>
                                @foreach($role->permissions as $permission)
                                    <a href="{{ route('show_permission', ['id' => $permission->id]) }}">
                                        {{ $permission->name }}
                                    </a> <br>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('show_role', ['id' => $role->id]) }}" title="View" aria-label="View">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                                <a href="{{ route('edit_role', ['role' => $role->id]) }}" title="Edit" aria-label="Edit">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <input type="checkbox" name="items[]" value="{{ $role->id }}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if ($errors->has('items'))
                    <span class="help-block">
                        <strong>{{ $errors->first('items') }}</strong>
                    </span>
                @endif
                <input type="submit" class="btn btn-danger"
                       value="Delete selected" title="Delete"
                       onclick="if (!confirm('{{ config('rbac.deleteConfirmation') }}')) {return false;}">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
            </form>

            {{ $roles->links() }}

        </div>
    </section>

@endsection
