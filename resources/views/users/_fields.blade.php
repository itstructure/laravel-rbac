<div class="row">
    <div class="col-12">
        <label for="roles_form_group">{!! __('rbac::roles.roles') !!}</label>
        <div class="form-group" id="roles_form_group">
            @foreach($allRoles as $key => $role)
                <div class="form-check">
                    <input class="form-check-input @if($errors->has('roles')) is-invalid @endif" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_checkbox_{{$key}}"
                           @cannot(Itstructure\LaRbac\Models\Permission::ASSIGN_ROLE_FLAG, Itstructure\LaRbac\Classes\MemberToRole::make($user, $role)) disabled @endcannot
                           @if(isset($currentRoles) && in_array($role->id, $currentRoles)) checked @endif >
                    <label class="form-check-label" for="role_checkbox_{{$key}}">
                        {{ $role->name }}
                    </label>
                </div>

                @if(isset($currentRoles) && in_array($role->id, $currentRoles))
                    @cannot(Itstructure\LaRbac\Models\Permission::ASSIGN_ROLE_FLAG, Itstructure\LaRbac\Classes\MemberToRole::make($user, $role))
                        <input type="hidden" name="roles[]" value="{{ $role->id }}">
                    @endcannot
                @endif
            @endforeach
        </div>
    </div>
</div>

@if ($errors->has('roles'))
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6 col-xl-4 text-center">
            <div class="alert alert-danger px-3 py-2" role="alert">
                <strong>{{ $errors->first('roles') }}</strong>
            </div>
        </div>
    </div>
@endif