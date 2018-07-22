@section('title', 'Permissions')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="permission-index">

            <p><a class="btn btn-success" href="{{ route('create_permission') }}">Create permission</a></p>

            <table class="table table-striped table-bordered"><thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th class="action-column">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>
                                <a href="{{ route('show_permission', ['id' => $permission->id]) }}">{{ $permission->name }}</a>
                            </td>
                            <td>
                                {{ $permission->slug }}
                            </td>
                            <td>
                                {{ $permission->description }}
                            </td>
                            <td>
                                <a href="{{ route('show_permission', ['id' => $permission->id]) }}" title="View" aria-label="View">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                                <a href="{{ route('edit_permission', ['id' => $permission->id]) }}" title="Edit" aria-label="Edit">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <a href="{{ route('delete_permission', ['id' => $permission->id]) }}" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $permissions->links() }}

        </div>
    </section>

@endsection