@section('title', 'Create Permission')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="permission-create">

            <div class="row">
                <div class="col-md-4">

                    <h1>Create permission</h1>

                    <form action="{{ route('store_permission') }}" method="post">

                        @include('rbac::permissions._fields')

                        <button class="btn btn-primary" type="submit">Create</button>

                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                    </form>

                </div>
            </div>

        </div>
    </section>

@stop
