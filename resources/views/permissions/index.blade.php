@extends($rbacLayout)
@section('title', __('rbac::permissions.permissions'))
@section('content')

    <section class="content container-fluid">

        <p><a class="btn btn-success" href="{{ route('create_permission') }}">{!! __('rbac::permissions.create_permission') !!}</a></p>

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
                'title' => __('rbac::permissions.permissions'),
                'rowsFormAction' => route('delete_permission'),
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
                        'value' => function ($permission) {
                            return '<a href="' . route('show_permission', ['id' => $permission->id]) . '">' . $permission->name .'</a>';
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
                        'label' => __('rbac::main.created'),
                        'attribute' => 'created_at',
                        'filter' => false,
                    ],
                    [
                        'class' => Itstructure\GridView\Columns\ActionColumn::class,
                        'actionTypes' => [
                            'view' => function ($permission) {
                                return route('show_permission', ['id' => $permission->id]);
                            },
                            'edit' => function ($permission) {
                                return route('edit_permission', ['permission' => $permission->id]);
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
