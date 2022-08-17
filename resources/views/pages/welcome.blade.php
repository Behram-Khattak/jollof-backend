@extends('layouts.master')

@section('title', 'Welcome Back | Jollof')

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
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="signup-div">

                <div class="text-center">

                    <h5 class="font-weight-bold">Welcome</h5>
                    <p>Finish setting up your account</p>

                </div>

                <form method="POST" action="{{ route('register.welcome.store') }}">

                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Do you want to sell on Jollof?</label>
                            <div role="radiogroup" aria-required="true" class="bv-no-focus-ring" >
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" id="business_owner1" name="business_owner" required="required" aria-required="true" class="custom-control-input" value="yes">
                                    <label class="custom-control-label" for="business_owner1"><span>Yes</span></label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" id="business_owner2" name="business_owner" required="required" aria-required="true" class="custom-control-input" value="no" checked>
                                    <label class="custom-control-label" for="business_owner2"><span>No</span></label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>First Name</label>
                            <input
                                name="first_name"
                                id="first-name"
                                class="form-control"
                                autocomplete="given-name"
                                required
                            />

                            @error('first_name')
                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">

                            <label>Last Name</label>
                            <input
                                name="last_name"
                                id="last-name"
                                class="form-control"
                                autocomplete="family-name"
                                required
                                :state="{{ $errors->has('last_name') ? 'false' : 'null' }}"
                            />

                            @error('last_name')
                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                            @enderror

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label label-for="email">Email</label>

                            <input
                                id="email"
                                class="form-control"
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                autocomplete="email"
                            />

                            @error('email')
                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                            @enderror

                        </div>

                        <div class="form-group col-md-6">
                            <label label-for="username">Username</label>

                            <input
                                name="username"
                                id="username"
                                class="form-control"
                                autocomplete="username"
                                required
                            />

                            @error('username')
                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                            @enderror

                        </div>
                    </div>

                    <div class="form-row">

                        <b-form-group id="input-group-20" label="Phone" label-for="phone" class="col-md-12">

                        <vue-tel-input
                                    defaultCountry="NG"
                                    name="telephone"
                                    inputId="input-group-20"
                                    placeholder=""
                        ></vue-tel-input>

                        </b-form-group>

                        @error('telephone')
                        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                        @enderror

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label label-for="password">Password</label>

                            <input
                                id="password"
                                class="form-control"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                required
                            />

                            @error('password')
                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label label-for="password-confirm">Confirm Password</label>

                            <input
                                id="password-confirm"
                                class="form-control"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                required
                            />
                            <input hidden name="role" value="{{ \App\Enums\DefaultRoles::USER }}">
                            <input hidden name="user_role" value="user">
                            @error('password_confirmation')
                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                            @enderror
                        </div>
                    </div>

                    <div id="merchantblock">

                    </div>


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

                    <button type="submit" class="btn btn-info btn-start text-white">Finish</button>

                </form>

                <p class="pt-4 text-center">Already have an account?
                    <b-link href="{{ route('login') }}" class="signin">Sign In</b-link>
                </p>

            </div>

        </article>

    </main>


    <div id="merchanthide" style="display:none;">
        <div class="text-capitalize font-weight-bold mt-3">
            <p>Business Information</p>
            <hr/>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label label-for="business-type">Business Type</label>

                <select
                    id="business-type"
                    name="business_type"
                    class="form-control custom-select"
                >
                    <option>
                        <b-form-select-option :value="null" disabled>-- Please select an option --
                        </b-form-select-option>
                    </option>
                    @foreach ($businessTypes as $type)
                    <option value="{{ $type->id }}">
                        {{ $type->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <b-form-group id="input-group-8" label="Business Name" label-for="business-name">

                    <b-form-input
                        id="business-name"
                        name="business_name"
                    ></b-form-input>
                </b-form-group>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <b-form-group id="input-group-9" label="Business Description" label-for="business-description">

                    <b-form-textarea
                        id="textarea"
                        name="business_description"
                        rows="3"
                        max-rows="6"
                    ></b-form-textarea>
                </b-form-group>
            </div>
        </div>

        <b-form-group id="input-group-19"
                      label="Business Email"
                      label-for="business-email"
        >

        <div class="form-row">
            <div class="form-group col-md-12">
                <b-form-input
                    id="business-email"
                    type="email"
                    name="business_email"
                    autocomplete="email"
                ></b-form-input>

                </b-form-group>
            </div>
        </div>

        <div class="form-row">

            <b-form-group id="input-group-20" label="Business Phone" label-for="business-phone"
                          class="col-md-6">

                <vue-tel-input
                               defaultCountry="NG"
                               name="business_phone"
                               inputId="input-group-20"
                               placeholder=""
                ></vue-tel-input>

            </b-form-group>

            <b-form-group id="input-group-15" label="Business WhatsApp" label-for="input-group-15"
                          class="col-md-6">

                <vue-tel-input
                               defaultCountry="NG"
                               name="whatsapp"
                               inputId="input-group-15"
                               placeholder=""
                ></vue-tel-input>


            </b-form-group>
        </div>

        <div class="text-capitalize font-weight-bold mt-3">
            <p>Business Location</p>
            <hr/>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <b-form-group id="input-group-10" label="Address" label-for="address">

                    <b-form-input
                        id="address"
                        name="address"
                        autocomplete="street-address"

                    ></b-form-input>
                </b-form-group>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label label-for="State">State</label>

                <select
                    id="state"
                    name="state_id"
                    class="form-control custom-select"
                >
                    <option>
                        <b-form-select-option :value="null" disabled>-- Please select an option --
                        </b-form-select-option>
                    </option>
                    @foreach ($states as $state)
                    <option value="{{ $state['state'] }}">
                        {{ $state['state'] }}
                    </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>

    $(function(){
        $('#merchanthide').hide();

        $('input[type=radio][name=business_owner]').change(function() {
            if (this.value == 'yes') {
               $('#merchantblock').html($('#merchanthide').html());
               $('input[name=role]').val({{ \App\Enums\DefaultRoles::MERCHANT }});
               $('input[name=user_role]').val('merchant');
            }
            else if (this.value == 'no') {
                $('#merchantblock').html('');
                $('input[name=role]').val({{ \App\Enums\DefaultRoles::USER }});
                $('input[name=user_role]').val('user');
            }
        });
    });

</script>
@endpush
