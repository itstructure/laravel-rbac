@section('title', 'Users')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="user-index">

            <h1>List users</h1>

            <form action="{{ route('delete_user') }}" method="post">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Roles</th>
                            <th class="action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <a href="{{ route('show_user', ['id' => $user->id]) }}">{{ $user->name }}</a>
                            </td>
                            <td>
                                @foreach($user->roles as $role)
                                    <a href="{{ route('show_role', ['id' => $role->id]) }}">{{ $role->name }}</a> <br>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('show_user', ['id' => $user->id]) }}" title="View" aria-label="View">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                                <a href="{{ route('edit_user', ['id' => $user->id]) }}" title="Edit" aria-label="Edit">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                @can('delete-yourself', $user->id)
                                    <input type="checkbox" name="items[]" value="{{ $user->id }}">
                                @else
                                    <span class="glyphicon glyphicon-ban-circle"></span>
                                @endcan
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

            {{ $users->links() }}

        </div>
    </section>

@endsection
