@extends('layouts.master')

@section('title', 'Log In | Jollof')

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

            <div class="signup-div py-5">

                <h4 class="text-center my-4">Welcome back</h4>

                @include('auth.loginForm')

                <p class="pt-4 text-center">Don't have an account?
                    <b-link href="/user/register" class="signin">
                        User Sign Up
                    </b-link> |
                    <b-link href="/merchant/register" class="signin">
                        Merchant Sign Up
                    </b-link>
                </p>

            </div>

        </article>

    </main>

@endsection
