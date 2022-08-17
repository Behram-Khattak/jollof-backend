<div class="row">

    <div class="form-group col-md-4">
        <label for="role-name">Name</label>
        <input type="text" class="form-control @error('role_name') is-invalid @enderror" id="role-name" name="role_name" value="{{ old('role_name', $role->name) }}" required {{ $role->can_be_renamed ? '' : 'disabled' }}>
        @error('role_name')
        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
        @enderror
    </div>

    <div class="form-group col-md-8">
        <label for="role-description">Description</label>
        <input type="text" class="form-control @error('role_description') is-invalid @enderror" id="role-description" name="role_description" value="{{ old('role_description', $role->description) }}">
        @error('role_description')
        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
        @enderror
    </div>

</div>

<div class="form-group">
    <label>
        All Permissions
    </label>
    <div class="kt-checkbox-inline d-flex justify-content-between">
        <div class="row">
            @foreach($permissions as $permission)
            <div class="col-md-3">
                <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                    <input type="checkbox" name="permissions[]" value="{{$permission->id}}" {{ $role->checkPermissionTo($permission->name) ? "checked" : " " }}>
                    <span></span>
                    {{str_replace('-', ' ', ucwords($permission->name))}}
                </label>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- @foreach($permissions as $key => $groupedPermissions)

    <div class="form-group">

        <label>
            {{ Str::singular(ucfirst($key)) }} Permissions
</label>

<div class="kt-checkbox-inline d-flex justify-content-between">
    @foreach($groupedPermissions as $permission)
    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ $role->checkPermissionTo($permission->name) ? "checked" : " " }}>
        {{ $permission->display_name }}
        <span></span>
    </label>
    @endforeach
</div>
</div>

@endforeach --}}

<hr>

<div class="kt-form__actions d-flex justify-content-between">
    <div>
        <b-button type="submit" class="btn btn-primary mr-2">
            <i class="la la-save"></i>
            {{ $buttonText }}
        </b-button>
        <b-link href="{{ route('admin.roles.index') }}" role="button" class="btn btn-secondary">
            <i class="la la-times"></i>
            Cancel
        </b-link>
    </div>

    @if ($role->trashed())
    <b-button type="button" class="btn btn-outline-brand {{ $showDeleteButton ? '' : 'd-none' }}" onclick="document.getElementById('restore-role-{{ $role->id }}').submit();">
        <i class="la la-refresh"></i>
        Restore Role
    </b-button>
    @else
    <b-button type="button" class="btn btn-outline-danger {{ $showDeleteButton ? '' : 'd-none' }} js-delete-trigger" id="role-{{ $role->id }}">
        <i class="la la-trash"></i>
        Delete Role
    </b-button>
    @endif

</div>
