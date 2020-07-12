@extends($rbacLayout)
@section('title', __('rbac::roles.edit_role'))
@section('content')

    <section class="content container-fluid">
        <div class="row">
            <div class="col-12">

                <h2>{!! __('rbac::roles.edit_role') !!}: <a href="{{route('show_role', ['id' => $role->id])}}">{{ $role->name }}</a></h2>

                <form action="{{ route('update_role', ['role' => $role->id]) }}" method="post">

                    @include('rbac::roles._fields', ['edit' => true])

                    <button class="btn btn-primary" type="submit">{!! __('rbac::main.edit') !!}</button>

                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                </form>

            </div>
        </div>
    </section>

@stop
