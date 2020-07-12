@extends($rbacLayout)
@section('title', __('rbac::users.users'))
@section('content')

    <section class="content container-fluid">

        @if ($errors->has('items'))
            <div class="row">
                <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3 text-center">
                    <div class="alert alert-danger px-3 py-2" role="alert">
                        <strong>{{ $errors->first('items') }}</strong>
                    </div>
                </div>
            </div>
        @endif

        @php
            $gridData = [
                'dataProvider' => $dataProvider,
                'paginatorOptions' => [
                    'pageName' => 'p',
                ],
                'rowsPerPage' => $rbacRowsPerPage,
                'title' =>  __('rbac::users.users'),
                'rowsFormAction' => route('delete_user'),
                'columnFields' => [
                    [
                        'label' => 'ID',
                        'attribute' => 'memberKey',
                        'htmlAttributes' => [
                            'width' => '5%',
                        ],
                        'filter' => false,
                        'sort' => $authIdentifierName
                    ],
                    [
                        'label' => __('rbac::users.name'),
                        'value' => function ($user) {
                            return '<a href="' . route('show_user', ['id' => $user->memberKey]) . '">' . $user->memberName .'</a>';
                        },
                        'filter' => [
                            'class' => Itstructure\GridView\Filters\TextFilter::class,
                            'name' => 'name'
                        ],
                        'sort' => 'name',
                        'format' => 'html',
                    ],
                    [
                        'label' =>  __('rbac::roles.roles'),
                        'value' => function ($user) {
                            $output = '<ul class="list-group list-group-flush">';
                            foreach($user->roles as $role) {
                                $output .= '<li class="list-group-item p-2"><a href="' . route('show_role', ['id' => $role->id]) . '">' . $role->name . '</a></li>';
                            }
                            return $output . '</ul>';
                        },
                        'filter' => false,
                        'sort' => false,
                        'format' => 'html',
                    ],
                    [
                        'label' => __('rbac::main.created'),
                        'attribute' => 'created_at',
                        'filter' => false,
                    ],
                    [
                        'class' => Itstructure\GridView\Columns\ActionColumn::class,
                        'actionTypes' => [
                            'view' => function ($user) {
                                return route('show_user', ['id' => $user->memberKey]);
                            },
                            'edit' => function ($user) {
                                return route('edit_user', ['id' => $user->memberKey]);
                            }
                        ],
                        'htmlAttributes' => [
                            'width' => '130',
                        ],
                    ],
                    [
                        'class' => Itstructure\GridView\Columns\CheckboxColumn::class,
                        'field' => 'items',
                        'attribute' => 'memberKey',
                        'display' => function ($user) {
                            return Gate::allows(Itstructure\LaRbac\Models\Permission::DELETE_MEMBER_FLAG, $user->memberKey);
                        }
                    ],
                ],
            ];
        @endphp

        @gridView($gridData)

    </section>

@endsection
