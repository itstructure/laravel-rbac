<div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
    <div class="container">
        <div class="row">
            <label class="col-md-4 control-label">Roles</label>
        </div>
    </div>

    <div class="container">
        <div class="row">
            @foreach($allRoles as $role)
                <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                       @if(!Auth::user()->canAssignRole($user, $role)) onclick="window.event.returnValue=false" @endif
                       @if(isset($currentRoles) && in_array($role->id, $currentRoles)) checked @endif >{{ $role->name }}
                <br>
            @endforeach
        </div>
    </div>

    @if ($errors->has('roles'))
        <span class="help-block">
            <strong>{{ $errors->first('roles') }}</strong>
        </span>
    @endif
</div>
