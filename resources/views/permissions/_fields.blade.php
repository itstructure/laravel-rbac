<div class="row">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
        <div class="form-group">
            <label for="permission_name">{!! __('rbac::main.name') !!}</label>
            <input id="permission_name" type="text" class="form-control @if ($errors->has('name')) is-invalid @endif"
                   name="name" value="{{ old('name', isset($permission) ? $permission->name : null) }}" required autofocus>
            @if ($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
        <div class="form-group">
            <label for="permission_description">{!! __('rbac::main.description') !!}</label>
            <input id="permission_description" type="text" class="form-control @if ($errors->has('description')) is-invalid @endif"
                   name="description" value="{{ old('description', isset($permission) ? $permission->description : null) }}" required autofocus>
            @if ($errors->has('description'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('description') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>

@if($edit)
    <div class="row">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
            <div class="form-group">
                <label for="permission_slug">{!! __('rbac::main.slug') !!} ({!! __('rbac::main.generated_automatically') !!})</label>
                <input id="permission_slug" type="text" class="form-control" value="{{ $permission->slug }}" disabled>
            </div>
        </div>
    </div>
@endif