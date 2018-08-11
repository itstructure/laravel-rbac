@section('title', 'Edit Permission')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="permission-edit">

            <div class="row">
                <div class="col-md-4">

                    <h1>Edit permission: {{ $permission->name }}</h1>

                    <form action="{{ route('update_permission', ['permission' => $permission->id]) }}" method="post">

                        @include('rbac::permissions._fields')

                        <button class="btn btn-primary" type="submit">Edit</button>

                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                    </form>

                </div>
            </div>

        </div>
    </section>

@stop
