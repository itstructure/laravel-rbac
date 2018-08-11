@section('title', 'Edit Role')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="role-edit">

            <div class="row">
                <div class="col-md-4">

                    <h1>Edit role: {{ $role->name }}</h1>

                    <form action="{{ route('update_role', ['role' => $role->id]) }}" method="post">

                        @include('rbac::roles._fields')

                        <button class="btn btn-primary" type="submit">Edit</button>

                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                    </form>

                </div>
            </div>

        </div>
    </section>

@stop
