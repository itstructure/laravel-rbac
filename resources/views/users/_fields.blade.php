<div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
    <div class="container">
        <div class="row">
            <label class="col-md-4 control-label">Roles</label>
        </div>
    </div>

    <div class="container">
        <div class="row">
            @foreach($allRoles as $id => $name)
                <input type="checkbox" name="roles[]" value="{{ $id }}" @if(isset($currentRoles) && in_array($id, $currentRoles)) checked @endif >{{ $name }}<br>
            @endforeach
        </div>
    </div>

    @if ($errors->has('roles'))
        <span class="help-block">
            <strong>{{ $errors->first('roles') }}</strong>
        </span>
    @endif
</div>
