@section('title', 'Assign user roles')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="user-edit">

            <div class="row">
                <div class="col-md-4">

                    <h1>Assign user roles for: {{ $user->name }}</h1>

                    <form action="{{ route('update_user', ['user' => $user->id]) }}" method="post">

                        @include('rbac::users._fields')

                        <button class="btn btn-primary" type="submit">Edit</button>

                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                    </form>

                </div>
            </div>

        </div>
    </section>

@stop
