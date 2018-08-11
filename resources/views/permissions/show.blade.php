@section('title', 'Show Permission')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="permission-show">

            <h1>Show permission: {{ $permission->name }}</h1>

            <p>
                <form action="{{ route('delete_permission') }}" method="post">
                    <a class="btn btn-success" href="{{ route('edit_permission', ['permission' => $permission->id]) }}"
                       title="Edit">Edit permission</a>
                    <input type="submit" class="btn btn-danger" value="Delete permission" title="Delete"
                           onclick="if (!confirm('{{ config('rbac.deleteConfirmation') }}')) {return false;}">
                    <input type="hidden" value="{{ $permission->id }}" name="items[]">
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
                        <td>{{ $permission->name }}</td>
                    </tr>
                    <tr>
                        <td>Slug</td>
                        <td>{{ $permission->slug }}</td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>{{ $permission->description }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </section>

@endsection
