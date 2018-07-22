@section('title', 'Show Permission')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="permission-show">

            <p>
                <a class="btn btn-success" href="{{ route('edit_permission', ['id' => $permission->id]) }}" title="Edit" aria-label="Edit" data-pjax="0">Edit permission</a>
                <a class="btn btn-danger" href="{{ route('delete_permission', ['id' => $permission->id]) }}" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post">Delete permission</a>
            </p>

            <table class="table table-striped table-bordered"><thead>
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