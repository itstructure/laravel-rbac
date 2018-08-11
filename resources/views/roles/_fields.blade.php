<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Name</label>

    <input id="name" type="text" class="form-control" name="name"
           value="{{ old('name', isset($role) ? $role->name : null) }}" required autofocus>

    @if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>

<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    <label for="description" class="col-md-4 control-label">Description</label>

    <input id="description" type="text" class="form-control" name="description"
           value="{{ old('description', isset($role) ? $role->description : null) }}" required autofocus>

    @if ($errors->has('description'))
        <span class="help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
    @endif
</div>

<div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
    <div class="container">
        <div class="row">
            <label class="col-md-4 control-label">Permissions</label>
        </div>
    </div>

    <div class="container">
        <div class="row">
            @foreach($allPermissions as $id => $name)
                <input type="checkbox" name="permissions[]" value="{{ $id }}"
                       @if(isset($currentPermissions) && in_array($id, $currentPermissions)) checked @endif >{{ $name }}
                <br>
            @endforeach
        </div>
    </div>

    @if ($errors->has('permissions'))
        <span class="help-block">
            <strong>{{ $errors->first('permissions') }}</strong>
        </span>
    @endif
</div>
