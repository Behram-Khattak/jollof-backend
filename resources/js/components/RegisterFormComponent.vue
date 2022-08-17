<template>

    <div class="signup-div">

        <div class="text-center">

            <h5 class="font-weight-bold">Get Started on Jollof</h5>
            <p>Create your account to be part of this great community</p>

        </div>

        <b-form
            method="POST"
            :action="route"
        >
            <slot>
                <!-- Laravel CSRF token -->
            </slot>

            <div class="form-row">

                <input hidden name="role" v-model="form.role">
                <input hidden name="user_role" v-model="form.user_role">
                <input hidden name="referal" :value="refer">

                <b-form-group id="input-group-1" label="First Name" label-for="first-name" class="col-md-6 required">

                    <b-form-input
                        name="first_name"
                        id="first-name"
                        autocomplete="given-name"
                        v-model="form.first_name"
                        required
                        :state="hasError('first_name') ? false : null"
                    ></b-form-input>

                    <invalid-feedback-component v-if="hasError('first_name')" :message="getError('first_name')"/>

                </b-form-group>

                <b-form-group id="input-group-2" label="Last Name" label-for="last-name" class="col-md-6">

                    <b-form-input
                        name="last_name"
                        id="last-name"
                        autocomplete="family-name"
                        v-model="form.last_name"
                        required
                        :state="hasError('last_name') ? false : null"
                    ></b-form-input>

                    <invalid-feedback-component v-if="hasError('last_name')" :message="getError('last_name')"/>

                </b-form-group>

                <b-form-group id="input-group-4" label="Email" label-for="email" class="col-md-6">

                    <b-form-input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="email"
                        v-model="form.email"
                        required
                        :state="hasError('email') ? false : null"
                    ></b-form-input>

                    <invalid-feedback-component v-if="hasError('email')" :message="getError('email')"/>

                </b-form-group>

                <b-form-group id="input-group-3" label="Username" label-for="username" class="col-md-6">

                    <b-form-input
                        name="username"
                        id="username"
                        autocomplete="username"
                        v-model="form.username"
                        required
                        :state="hasError('username') ? false : null"
                    ></b-form-input>

                    <invalid-feedback-component v-if="hasError('username')" :message="getError('username')"/>

                </b-form-group>

                <b-form-group
                              id="input-group-5"
                              label="Phone Number"
                              label-for="telephone"
                              class="col-md-12"
                >

                    <vue-tel-input v-model="telephone"
                                   inputId="input-group-5"
                                   defaultCountry="NG"
                                   name="telephone"
                                   :validCharactersOnly="true"
                                   placeholder=""
                                   :wrapperClasses="{'is-invalid': hasError('telephone')}"
                                   :inputClasses="{'form-control': true, 'is-invalid': hasError('telephone') }"
                                   @input="setTelephoneNumber"
                    ></vue-tel-input>

                    <invalid-feedback-component v-if="hasError('telephone')" :force="true"
                                                :message="getError('telephone')"/>
                </b-form-group>

                <b-form-group id="input-group-6" label="Password" label-for="password" class="col-md-6">

                    <b-form-input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        required
                        v-model="form.password"
                        :state="hasError('password') ? false : null"
                    ></b-form-input>

                    <invalid-feedback-component v-if="hasError('password')" :message="getError('password')"/>

                </b-form-group>

                <b-form-group id="input-group-7" label="Confirm Password" label-for="password-confirm" class="col-md-6">

                    <b-form-input
                        id="password-confirm"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        v-model="form.password_confirmation"
                        :state="hasError('password_confirmation') ? false : null"
                    ></b-form-input>

                    <invalid-feedback-component v-if="hasError('password_confirmation')"
                                                :message="getError('password_confirmation')"/>

                </b-form-group>

                <b-form-group v-if="form.role === 'merchant'" label="Are you the business owner?" class="col-md-6">

                    <b-form-radio-group
                        v-model="form.business_owner"
                        :options="radioOptions"
                        name="business_owner"
                        required
                    ></b-form-radio-group>

                </b-form-group>

            </div>

            <template v-if="form.role === 'merchant'">
                <div class="text-capitalize font-weight-bold mt-3">
                    <p>Business Information</p>
                    <hr/>
                </div>

                <b-form-group id="input-group-11" label="Business Type" label-for="business-type">

                    <b-form-select id="business-type"
                                   name="business_type"
                                   class="form-control custom-select"
                                   v-model="form.business_type"
                                   :state="hasError('business_type') ? false : null"
                    >
                        <template v-slot:first>
                            <b-form-select-option :value="null" disabled>-- Please select an option --
                            </b-form-select-option>
                        </template>

                        <b-form-select-option v-for="(type, index) in businessTypes" :key="type.id" :value="type.id">
                            {{ type.name }}
                        </b-form-select-option>

                    </b-form-select>

                    <invalid-feedback-component v-if="hasError('business_type')" :message="getError('business_type')"/>

                </b-form-group>

                <b-form-group id="input-group-8" label="Business Name" label-for="business-name">

                    <b-form-input
                        id="business-name"
                        name="business_name"
                        v-model="form.business_name"
                        :state="hasError('business_name') ? false : null"
                    ></b-form-input>

                    <invalid-feedback-component v-if="hasError('business_name')" :message="getError('business_name')"/>

                </b-form-group>

                <b-form-group id="input-group-9" label="Business Description" label-for="business-description">

                    <b-form-textarea
                        id="textarea"
                        name="business_description"
                        rows="3"
                        max-rows="6"
                        v-model="form.business_description"
                        :state="hasError('business_description') ? false : null"
                    ></b-form-textarea>

                    <invalid-feedback-component v-if="hasError('business_description')"
                                                :message="getError('business_description')"/>

                </b-form-group>

                <b-form-group id="input-group-19"
                              label="Business Email"
                              label-for="business-email"
                >

                    <b-form-input
                        id="business-email"
                        type="email"
                        name="business_email"
                        autocomplete="email"
                        v-model="form.business_email"
                        :state="hasError('business_email') ? false : null"
                    ></b-form-input>

                    <invalid-feedback-component v-if="hasError('business_email')" :force="true"
                                                :message="getError('business_email')"/>

                </b-form-group>

                <div class="form-row">

                    <b-form-group id="input-group-20" label="Business Phone" label-for="business-phone"
                                  class="col-md-6">

                        <vue-tel-input v-model="business_phone"
                                       defaultCountry="NG"
                                       name="business_phone"
                                       inputId="input-group-20"
                                       placeholder=""
                                       :validCharactersOnly="true"
                                       :wrapperClasses="{'is-invalid': hasError('business_phone')}"
                                       :inputClasses="{'form-control': true, 'is-invalid': hasError('business_phone') }"
                                       @input="setBusinessPhoneNumber"
                        ></vue-tel-input>

                        <invalid-feedback-component v-if="hasError('business_phone')" :force="true"
                                                    :message="getError('business_phone')"/>

                    </b-form-group>

                    <b-form-group id="input-group-15" label="Business WhatsApp" label-for="input-group-15"
                                  class="col-md-6">

                        <vue-tel-input v-model="whatsapp"
                                       defaultCountry="NG"
                                       name="whatsapp"
                                       inputId="input-group-15"
                                       placeholder=""
                                       :validCharactersOnly="true"
                                       :wrapperClasses="{'is-invalid': hasError('whatsapp')}"
                                       :inputClasses="{'form-control': true, 'is-invalid': hasError('whatsapp') }"
                                       @input="setWhatsAppNumber"
                        ></vue-tel-input>

                        <invalid-feedback-component v-if="hasError('whatsapp')" :force="true"
                                                    :message="getError('whatsapp')"/>
                    </b-form-group>
                </div>

                <div class="text-capitalize font-weight-bold mt-3">
                    <p>Business Location</p>
                    <hr/>
                </div>

                <state-lga-select
                    :state-prop="stateProp"
                    :old-lga="oldInput('city')"
                    :old-state="oldInput('state')"
                    :state-error="getError('state')"
                    :lga-error="getError('city')"
                ></state-lga-select>

                <b-form-group id="input-group-10" label="Address" label-for="address">

                    <b-form-input
                        id="address"
                        name="address"
                        autocomplete="street-address"
                        v-model="form.address"
                        :state="hasError('address') ? false : null"
                    ></b-form-input>

                    <invalid-feedback-component v-if="hasError('address')" :message="getError('address')"/>
                </b-form-group>

            </template>

            <div class="form-group form-check">

                <input id="terms"
                       name="terms"
                       :class="{'form-check-input' : true, 'is-invalid': hasError('terms') }"
                       type="checkbox"
                       v-model="form.terms"
                >
                <label class="form-check-label align-top" for="terms">
                    I accept the
                    <b-link href="/terms-and-conditions" class="signin">Terms &amp; Conditions</b-link>
                </label>

                <invalid-feedback-component v-if="hasError('terms')" :message="getError('terms')"/>

            </div>

            <p>
                Please note that Jollof.com is GDPR compliant. By completing the above form, you hereby give consent to
                Jollof.com to collect, process and store your data for the purpose of which it is given only.
            </p>

            <b-button type="submit" class="btn btn-info btn-start text-white">Register</b-button>

        </b-form>

        <p class="pt-4 text-center">Already have an account?
            <b-link href="/login" class="signin">Sign In</b-link>
        </p>

    </div>

</template>

<script>

import {VueTelInput} from 'vue-tel-input'
import StateLgaSelect from "./StateLgaSelect";
import InvalidFeedbackComponent from "./InvalidFeedbackComponent";

export default {
    name: "RegisterFormComponent",
    components: {
        VueTelInput,
        StateLgaSelect,
        InvalidFeedbackComponent
    },
    props: {
        role: {
            type: Object,
            required: true,
        },
        businessTypes: {
            type: Object,
            required: true
        },
        refer: {
            type: String,
            required: true
        },
        route: {
            type: String,
            required: true,
        },
        stateProp: {
            type: Array,
            required: true,
        },
        old: {
            type: [Object, Array]
        },
        errors: {
            type: [Object, Array]
        }
    },
    data() {
        return {
            form: {
                role: '',
                refer: '',
                first_name: this.oldInput('first_name') ?? '',
                last_name: this.oldInput('last_name') ?? '',
                username: this.oldInput('username') ?? '',
                email: this.oldInput('email') ?? '',
                password: '',
                password_confirmation: '',
                business_owner: '',
                user_role: '',
                telephone: '',
                whatsapp: '',
                business_type: this.oldInput('business_type') ?? null,
                business_name: this.oldInput('business_name') ?? '',
                business_description: this.oldInput('business_description') ?? '',
                business_email: this.oldInput('business_email') ?? '',
                business_phone: '',
                address: this.oldInput('address') ?? '',
                terms: this.oldInput('terms') ?? false
            },
            telephone: this.oldInput('telephone') ?? '',
            whatsapp: this.oldInput('whatsapp') ?? '',
            business_phone: this.oldInput('business_phone') ?? '',
            radioOptions: [
                {text: 'Yes', value: 'yes'},
                {text: 'No', value: 'no'},
            ],
            selectOptions: [
                {text: 'Manager', value: 'manager'},
            ]
        }
    },
    methods: {
        setSelectedRole() {
            this.form.role = this.oldInput('role') ?? this.role.name;
        },
        setTelephoneNumber(formattedNumber, {number, valid, country}) {
            this.form.telephone = number.e164;
        },
        setWhatsAppNumber(formattedNumber, {number, valid, country}) {
            this.form.whatsapp = number.e164;
        },
        setBusinessPhoneNumber(formattedNumber, {number, valid, country}) {
            this.form.business_phone = number.e164;
        },
        getError(field) {
            return this.errors[field] ? this.errors[field][0] : '';
        },
        hasError(field) {
            return Object.keys(this.errors).includes(field);
        },
        oldInput(field) {
            if (this.old[field]) {
                return this.old[field]
            }
        }
    },
    mounted() {
        this.setSelectedRole();
    },
    watch: {
        'form.business_owner': function () {
            this.form.user_role = this.form.business_owner === 'no' ? 'manager' : '';
        },
    },
    filters: {
        capitalize(value) {
            return typeof value !== 'string' ? '' : value.charAt(0).toUpperCase() + value.slice(1);
        }
    },
}
</script>

<style scoped lang="scss">
.vue-tel-input:focus-within {
    box-shadow: none;
}

.vue-tel-input {
    border: 1px solid #ced4da;
}

.vue-tel-input.is-invalid {
    border-color: #dc3545;
}

</style>
