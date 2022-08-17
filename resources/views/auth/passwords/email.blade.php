@extends('layouts.master')

@section('title', 'Forgot Password | Jollof')

@section('content')

    <main>

        <article>

            @if (session('status'))
                <alert-component
                    variant="success"
                    body="{{ session('status') }}"
                    :dismissible="true"
                    :icon="false"
                >
                </alert-component>
            @endif

            <div class="signup-div py-5">

                <h4 class="text-center my-4">Forgot Password</h4>

                <b-form action="{{ route('password.email') }}" method="POST">

                    @csrf

                    <b-form-group id="input-group-1" label="Email Address" label-for="email">

                        <b-form-input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="mb-4"
                            :state="{{ $errors->has('email') ? 'false' : 'null' }}"
                            required
                            autocomplete="email"
                        ></b-form-input>

                        @error('email')
                        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                        @enderror

                    </b-form-group>

                    <b-button type="submit" class="btn btn-info btn-start text-white">
                        Send Password Reset Link
                    </b-button>

                </b-form>

                <p class="pt-4 text-center">Remember Password?
                    <b-link href="{{ route('login') }}" class="signin">
                        Log In
                    </b-link>
                </p>

            </div>

        </article>

    </main>

@endsection
