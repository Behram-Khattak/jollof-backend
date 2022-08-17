<b-form action="{{ route('login') }}" method="POST">

    @csrf

    <b-form-group id="input-group-1" label="Email or Username" label-for="email">

        <b-form-input
            name="email"
            id="email"
            value="{{ old('email') }}"
            :state="{{ $errors->has('email') ? 'false' : 'null' }}"
            required
            autofocus
        ></b-form-input>

        @error('email')
        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
        @enderror

    </b-form-group>

    <b-form-group id="input-group-2" label="Password" label-for="password">

        <b-form-input
            id="password"
            name="password"
            type="password"
            :state="{{ $errors->has('password') ? 'false' : 'null' }}"
            required
            autocomplete="current-password"
        ></b-form-input>

        @error('password')
        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
        @enderror

    </b-form-group>

    <div class="form-group form-check d-flex justify-content-between">
        <input id="remember"
               name="remember"
               class="form-check-input"
               type="checkbox"
            {{ old('remember') ? 'checked' : '' }}
        >
        <label class="form-check-label" for="remember">Remember Me</label>

        @if (Route::has('password.request'))
            <p>
                <b-link class="signin" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </b-link>
            </p>

        @endif

    </div>

    <b-button type="submit" class="btn btn-info btn-start text-white">Log In</b-button>

</b-form>
