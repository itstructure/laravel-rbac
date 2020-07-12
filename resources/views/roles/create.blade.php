@extends($rbacLayout)
@section('title', __('rbac::roles.create_role'))
@section('content')

    <section class="content container-fluid">
        <div class="row">
            <div class="col-12">

                <h2>{!! __('rbac::roles.create_role') !!}</h2>

                <form action="{{ route('store_role') }}" method="post">

                    @include('rbac::roles._fields', ['edit' => false])

                    <button class="btn btn-primary" type="submit">{!! __('rbac::main.create') !!}</button>

                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                </form>

            </div>
        </div>
    </section>

@stop
