@extends('layouts.master')

@section('title', 'Account Setup | Jollof')

@push('styles')

    <style>
        .signup-div {
            margin: 70px auto 85px auto;
        }

        .signup-div select {
            border-radius: 8px;
        }

        .signup-div textarea {
            background: #E0E0E0;
            border-radius: 8px;
            padding-top: 5px;
            margin-bottom: 25px;
            color: #545B62;
            font-size: var(--input-text);
        }
    </style>

@endpush


@section('content')
    <main>
        <article>

            @if (session('message'))
                <alert-component
                    variant="{{ session('message.type') }}"
                    body="{{ session('message.body') }}"
                    :dismissible="true"
                >
                </alert-component>
            @endif

            <div class="signup-div">

                <div class="text-center">

                    <h5 class="font-weight-bold">Welcome</h5>
                    <p>Finish setting up your account</p>

                </div>

                <b-form method="POST" action="{{ route('account.setup.finish') }}">

                    @csrf

                    <input type="hidden" name="id" value="{{ $id }}">

                    <b-form-group id="input-group-4" label="Email" label-for="email">

                        <b-form-input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            :state="{{ $errors->has('email') ? 'false' : 'null' }}"
                            required
                            readonly
                            autocomplete="email"
                        ></b-form-input>

                        @error('email')
                        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                        @enderror

                    </b-form-group>

                    <b-form-group id="input-group-6" label="Password" label-for="password">

                        <b-form-input
                            id="password"
                            name="password"
                            type="password"
                            :state="{{ $errors->has('password') ? 'false' : 'null' }}"
                            autocomplete="new-password"
                            required
                        ></b-form-input>

                        @error('password')
                        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                        @enderror

                    </b-form-group>

                    <b-form-group id="input-group-7" label="Confirm Password" label-for="password-confirm">

                        <b-form-input
                            id="password-confirm"
                            name="password_confirmation"
                            type="password"
                            :state="{{ $errors->has('password_confirmation') ? 'false' : 'null' }}"
                            autocomplete="new-password"
                            required
                        ></b-form-input>

                        @error('password_confirmation')
                        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                        @enderror

                    </b-form-group>

                    <div class="form-group form-check">

                        <input id="terms"
                               name="terms"
                               class="form-check-input @error('terms') is-invalid @enderror"
                               type="checkbox"
                               required
                        >
                        <label class="form-check-label align-top" for="terms">
                            I accept the Terms &amp; Conditions
                        </label>

                        @error('terms')
                        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                        @enderror

                    </div>

                    <b-button type="submit" class="btn btn-info btn-start text-white">Finish</b-button>

                </b-form>

                <p class="pt-4 text-center">Already have an account?
                    <b-link href="{{ route('login') }}" class="signin">Sign In</b-link>
                </p>

            </div>

        </article>

    </main>
@endsection
