@extends($rbacLayout)
@section('title', __('rbac::permissions.create_permission'))
@section('content')

    <section class="content container-fluid">
        <div class="row">
            <div class="col-12">

                <h1>{!! __('rbac::permissions.create_permission') !!}</h1>

                <form action="{{ route('store_permission') }}" method="post">

                    @include('rbac::permissions._fields', ['edit' => false])

                    <button class="btn btn-primary" type="submit">{!! __('rbac::main.create') !!}</button>

                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                </form>

            </div>
        </div>
    </section>

@stop
