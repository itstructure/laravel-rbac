@section('title', 'Roles')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="role-index">

            <p><a class="btn btn-success" href="{{ route('create_role') }}">Create role</a></p>

            <table class="table table-striped table-bordered"><thead>
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
                                    <a href="{{ route('show_permission', ['id' => $permission->id]) }}">{{ $permission->name }}</a> <br>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('show_role', ['id' => $role->id]) }}" title="View" aria-label="View">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                                <a href="{{ route('edit_role', ['id' => $role->id]) }}" title="Edit" aria-label="Edit">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <a href="{{ route('delete_role', ['id' => $role->id]) }}" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $roles->links() }}

        </div>
    </section>

@endsection