@extends($rbacLayout)
@section('title', __('rbac::users.assign_roles'))
@section('content')

    <section class="content container-fluid">
        <div class="row">
            <div class="col-12">

                <h2>{!! __('rbac::users.assign_roles_for_user') !!}: <a href="{{route('show_user', ['id' => $user->memberKey])}}">{{ $user->memberName }}</a></h2>

                <form action="{{ route('update_user', ['id' => $user->memberKey]) }}" method="post">

                    @include('rbac::users._fields')

                    <button class="btn btn-primary" type="submit">{!! __('rbac::main.edit') !!}</button>

                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                </form>

            </div>
        </div>
    </section>

@stop
