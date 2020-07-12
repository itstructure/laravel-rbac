@extends($rbacLayout)
@section('title', __('rbac::roles.roles'))
@section('content')

    <section class="content container-fluid">

        <p><a class="btn btn-success" href="{{ route('create_role') }}">{!! __('rbac::roles.create_role') !!}</a></p>

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
                'title' => __('rbac::roles.roles'),
                'rowsFormAction' => route('delete_role'),
                'columnFields' => [
                    [
                        'label' => 'ID',
                        'attribute' => 'id',
                        'htmlAttributes' => [
                            'width' => '5%',
                        ],
                        'filter' => false
                    ],
                    [
                        'label' => __('rbac::main.name'),
                        'value' => function ($role) {
                            return '<a href="' . route('show_role', ['id' => $role->id]) . '">' . $role->name .'</a>';
                        },
                        'filter' => [
                            'class' => Itstructure\GridView\Filters\TextFilter::class,
                            'name' => 'name'
                        ],
                        'sort' => 'name',
                        'format' => 'html',
                    ],
                    [
                        'label' => __('rbac::main.slug'),
                        'attribute' => 'slug',
                    ],
                    [
                        'label' => __('rbac::main.description'),
                        'attribute' => 'description',
                        'filter' => false,
                        'sort' => false
                    ],
                    [
                        'label' => __('rbac::permissions.permissions'),
                        'value' => function ($role) {
                            $output = '<ul class="list-group list-group-flush">';
                            foreach($role->permissions as $permission) {
                                $output .= '<li class="list-group-item p-2"><a href="' . route('show_permission', ['id' => $permission->id]) . '">' . $permission->name . '</a></li>';
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
                            'view' => function ($role) {
                                return route('show_role', ['id' => $role->id]);
                            },
                            'edit' => function ($role) {
                                return route('edit_role', ['role' => $role->id]);
                            }
                        ],
                        'htmlAttributes' => [
                            'width' => '130',
                        ],
                    ],
                    [
                        'class' => Itstructure\GridView\Columns\CheckboxColumn::class,
                        'field' => 'items',
                        'attribute' => 'id'
                    ],
                ],
            ];
        @endphp

        @gridView($gridData)

    </section>

@endsection
