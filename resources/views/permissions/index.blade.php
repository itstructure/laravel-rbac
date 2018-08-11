@section('title', 'Permissions')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="permission-index">

            <h1>List permissions</h1>

            <p><a class="btn btn-success" href="{{ route('create_permission') }}">Create permission</a></p>

            <form action="{{ route('delete_permission') }}" method="post">
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
                                    <a href="{{ route('show_permission', ['id' => $permission->id]) }}">
                                        {{ $permission->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $permission->slug }}
                                </td>
                                <td>
                                    {{ $permission->description }}
                                </td>
                                <td>
                                    <a href="{{ route('show_permission', ['id' => $permission->id]) }}"
                                       title="View" aria-label="View">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                    <a href="{{ route('edit_permission', ['permission' => $permission->id]) }}"
                                       title="Edit" aria-label="Edit">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    <input type="checkbox" name="items[]" value="{{ $permission->id }}">
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
                <input type="submit" class="btn btn-danger" value="Delete selected" title="Delete"
                       onclick="if (!confirm('{{ config('rbac.deleteConfirmation') }}')) {return false;}">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
            </form>

            {{ $permissions->links() }}

        </div>
    </section>

@endsection
