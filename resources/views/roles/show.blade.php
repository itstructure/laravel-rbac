@section('title', 'Show Role')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="role-show">

            <p>
                <a class="btn btn-success" href="{{ route('edit_role', ['id' => $role->id]) }}" title="Edit" aria-label="Edit" data-pjax="0">Edit role</a>
                <a class="btn btn-danger" href="{{ route('delete_role', ['id' => $role->id]) }}" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post">Delete role</a>
            </p>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Attribute</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{ $role->name }}</td>
                    </tr>
                    <tr>
                        <td>Slug</td>
                        <td>{{ $role->slug }}</td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>{{ $role->description }}</td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>
                            @foreach($role->permissions as $permission)
                                <a href="{{ route('show_permission', ['id' => $permission->id]) }}">{{ $permission->name }}</a> <br>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </section>

@endsection