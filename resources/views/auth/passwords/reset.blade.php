@extends('layouts.master')

@section('title', 'Reset Password | Jollof')

@section('content')

    <main>
        <article>

            <div class="signup-div mb-5 py-5">

                <h4 class="text-center">Reset Password</h4>

                <b-form action="{{ route('password.update') }}" method="POST">

                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <b-form-group id="input-group-1" label="Email Address" label-for="email">

                        <b-form-input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $email) }}"
                            :state="{{ $errors->has('email') ? 'false' : 'null' }}"
                            required
                            readonly
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
                            autocomplete="new-password"
                        ></b-form-input>

                        @error('password')
                        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                        @enderror

                    </b-form-group>

                    <b-form-group id="input-group-3" label="Confirm Password" label-for="password-confirm">

                        <b-form-input
                            id="password-confirm"
                            name="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                        ></b-form-input>

                    </b-form-group>

                    <b-button type="submit" class="btn btn-info btn-start text-white mt-4">
                        Reset Password
                    </b-button>

                </b-form>

            </div>

        </article>

    </main>

@endsection
