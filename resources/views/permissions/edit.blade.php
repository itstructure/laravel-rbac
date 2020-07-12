@extends($rbacLayout)
@section('title', __('rbac::permissions.edit_permission'))
@section('content')

    <section class="content container-fluid">
        <div class="row">
            <div class="col-12">

                <h2>{!! __('rbac::permissions.edit_permission') !!}: <a href="{{route('show_permission', ['id' => $permission->id])}}">{{ $permission->name }}</a></h2>

                <form action="{{ route('update_permission', ['permission' => $permission->id]) }}" method="post">

                    @include('rbac::permissions._fields', ['edit' => true])

                    <button class="btn btn-primary" type="submit">{!! __('rbac::main.edit') !!}</button>

                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                </form>

            </div>
        </div>
    </section>

@stop
