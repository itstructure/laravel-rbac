@section('title', 'Show Role')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="role-show">

            <h1>Show role: {{ $role->name }}</h1>

            <p>
                <form action="{{ route('delete_role') }}" method="post">
                    <a class="btn btn-success" href="{{ route('edit_role', ['role' => $role->id]) }}"
                       title="Edit">Edit role</a>
                    <input type="submit" class="btn btn-danger" value="Delete role" title="Delete"
                           onclick="if (!confirm('{{ config('rbac.deleteConfirmation') }}')) {return false;}">
                    <input type="hidden" value="{{ $role->id }}" name="items[]">
                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">
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
                                <a href="{{ route('show_permission', ['id' => $permission->id]) }}">
                                    {{ $permission->name }}
                                </a> <br>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </section>

@endsection
