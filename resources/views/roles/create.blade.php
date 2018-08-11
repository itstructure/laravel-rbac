@section('title', 'Create Role')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="role-create">

            <div class="row">
                <div class="col-md-4">

                    <h1>Create role</h1>

                    <form action="{{ route('store_role') }}" method="post">

                        @include('rbac::roles._fields')

                        <button class="btn btn-primary" type="submit">Create</button>

                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                    </form>

                </div>
            </div>

        </div>
    </section>

@stop
