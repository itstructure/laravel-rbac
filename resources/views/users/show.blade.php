@section('title', 'Show User')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="user-show">

            <h1>Show user: {{ $user->name }}</h1>

            <p>
                <form action="{{ route('delete_user') }}" method="post">
                    <a class="btn btn-success" href="{{ route('edit_user', ['id' => $user->id]) }}"
                       title="Edit">Assign user roles</a>
                    @can('delete-yourself', $user->id)
                        <input type="submit" class="btn btn-danger" value="Delete user" title="Delete"
                               onclick="if (!confirm('{{ config('rbac.deleteConfirmation') }}')) {return false;}">
                        <input type="hidden" value="{{ $user->id }}" name="items[]">
                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                    @endcan
                </form>
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
