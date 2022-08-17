<b-modal id="create-settings-modal"
         title="Create New Setting"
         size="lg"
         header-close-content=""
         centered
         hide-footer
         :visible="{{ session('create-setting-modal-open') ?? 'false' }}"
>

    <b-form action="{{ route('admin.settings.store', $settingType) }}" method="POST" class="mx-3">

        @csrf

        @include('admin.settings._form-create-edit', ['settings' => new \App\Models\Settings, 'buttonText' => 'Create Setting', 'showCancelButton' => true])

    </b-form>

</b-modal>
