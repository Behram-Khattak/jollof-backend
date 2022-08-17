@extends('layouts.master')

@section('title', 'Confirm Password | Jollof')

@section('content')

    <main>

        <article>

            <div class="signup-div py-5">

                <div class="text-center">

                    <h5 class="font-weight-bold my-4">
                        {{ __('Confirm Password') }}
                    </h5>
                    <p>
                        {{ __('Please confirm your password before continuing.') }}
                    </p>
                    <hr/>
                </div>

                <b-form action="{{ route('password.confirm') }}" method="POST">

                    @csrf

                    <b-form-group id="input-group-1" label="Password" label-for="password">

                        <b-form-input
                            id="password"
                            name="password"
                            type="password"
                            :state="{{ $errors->has('password') ? 'false' : 'null' }}"
                            required
                            autocomplete="current-password"
                            autofocus
                        ></b-form-input>

                        @error('password')
                        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                        @enderror

                    </b-form-group>

                    <b-button type="submit" class="btn btn-info btn-start text-white">
                        {{ __('Confirm Password') }}
                    </b-button>

                </b-form>

                @if (Route::has('password.request'))
                    <p class="pt-4 text-center">Remember Password?
                        <b-link href="{{ route('password.request') }}" class="signin">
                            {{ __('Forgot Your Password?') }}
                        </b-link>
                    </p>
                @endif

            </div>

        </article>

    </main>

@endsection
