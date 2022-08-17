@extends('layouts.master')

@section('title', 'Register | Jollof')

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

            <register-form-component :role="{{ $role }}"
                                     :business-types="{{ $businessTypes }}"
                                     refer="{{ ($refer) ? $refer : 0 }}"
                                     route="{{ route('register.create', $role) }}"
                                     :state-prop="{{ json_encode($states) }}"
                                     :old="{{ json_encode(Session::getOldInput()) }}"
                                     :errors="{{ json_encode($errors->getMessages()) }}"
            >
                @csrf
            </register-form-component>

        </article>

    </main>
@endsection
