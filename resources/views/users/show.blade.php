@section('title', 'Show User')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="user-show">

            <p>
                <a class="btn btn-success" href="{{ route('edit_user', ['id' => $user->id]) }}" title="Edit" aria-label="Edit" data-pjax="0">Assign user roles</a>
                <a class="btn btn-danger" href="{{ route('delete_user', ['id' => $user->id]) }}" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post">Delete user</a>
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
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Roles</td>
                        <td>
                            @foreach($user->roles as $role)
                                <a href="{{ route('show_role', ['id' => $role->id]) }}">{{ $role->name }}</a> <br>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </section>

@endsection