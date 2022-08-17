<input name="setting_type_id" value="{{ $settingType->id }}" hidden>

<b-form-group id="input-group-1" label="Setting Name" label-for="name">

    <b-form-input
        name="name"
        id="name"
        required
        placeholder="Enter setting name"
        value="{{ old('name', $settings->name) }}"
        :state="{{ $errors->has('name') ? 'false' : 'null' }}"
    ></b-form-input>

    @error('name')
    <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
    @enderror

</b-form-group>

<b-form-group id="input-group-2" label="Settings Value" label-for="value">

    <b-form-textarea
        id="value"
        name="value"
        placeholder="Enter the setting value..."
        rows="3"
        max-rows="6"
        required
        no-resize
        :state="{{ $errors->has('value') ? 'false' : 'null' }}"
        value="{{ old('value', $settings->value) }}"
    ></b-form-textarea>

    @error('value')
    <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
    @enderror

</b-form-group>

<div class="btn-list d-flex justify-content-end my-4">

    <b-button variant="danger" class="{{ $showCancelButton ? '' : 'd-none' }}" @click="$bvModal.hide('create-settings-modal')">Cancel</b-button>

    <b-button type="submit" variant="primary" class="ml-2">
        <i class="la la-save"></i>
        {{ $buttonText }}
    </b-button>

</div>
