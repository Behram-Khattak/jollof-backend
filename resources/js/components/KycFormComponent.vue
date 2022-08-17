<template>

    <form class="kt-form kt-form--label-right"
          id="kt_profile_form"
          method="POST"
    >
        <loading :active.sync="loader.isLoading"
                 :is-full-page="loader.fullPage"
        />
        <div class="kt-portlet__body">
            <div class="kt-section kt-section--first">
                <div class="kt-section__body">

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label" for="business-category">
                            Business Category
                        </label>
                        <div class="col-lg-9 col-xl-6 d-flex">

                            <div class="flex-grow-1">
                                <select name="business_category"
                                        id="business-category"
                                        :class="{'form-select': true, 'custom-select': true, 'is-invalid': $v.form.business_category.$error }"
                                        :disabled="business.status == 'approved' ? true : false"
                                        v-model="form.business_category"
                                >
                                    <option value="" disabled hidden>
                                        Select Business Category
                                    </option>
                                    <option v-for="(category, index) in categories" :value="category"
                                            :key="index" >
                                        {{ category | toTitleCase }}
                                    </option>
                                </select>
                                <invalid-feedback-component
                                    :message="validationMsg($v.form.business_category)"/>
                            </div>

                            <button type="button"
                                    class="btn btn-sm btn-outline-info btn-circle btn-icon ml-2"
                                    v-b-popover.click.top="'Limited Companies are required to upload CAC registration documents, form C02 and form CO7.'"
                                    title=""
                            >
                                <i class="fa fa-question"></i>
                            </button>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label" for="bankName">
                            Bank Name
                        </label>
                        <div class="col-lg-9 col-xl-6">
                            <select name="bank_name"
                                    id="bankName"
                                    :class="{'form-select': true, 'custom-select': true, 'is-invalid': $v.form.bank_name.$error }"
                                    :disabled="business.status == 'approved' ? true : false"
                                    v-model="form.bank_name"
                            >
                                <option value="" disabled hidden>
                                    Select Bank
                                </option>
                                <option v-for="(bank, id) in banks" :value="bank.code" :key="bank.id">
                                    {{ bank.name }}
                                </option>
                            </select>
                            <invalid-feedback-component :message="validationMsg($v.form.bank_name)"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label" for="account-name">
                            Account Name
                        </label>
                        <div class="col-lg-9 col-xl-6">
                            <input type="text"
                                   :class="{'form-control': true, 'is-invalid': $v.form.account_name.$error }"
                                   placeholder="Enter Account Name"
                                   id="account-name"
                                   name="account_name"
                                   v-model="form.account_name"
                                   :disabled="business.status == 'approved' ? true : false"

                            >
                            <invalid-feedback-component :message="validationMsg($v.form.account_name)"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label" for="account-number">
                            Account Number
                        </label>
                        <div class="col-lg-9 col-xl-6">
                            <input type="text"
                                   :class="{'form-control': true, 'is-invalid': $v.form.account_number.$error }"
                                   placeholder="Enter Account Number"
                                   id="account-number"
                                   name="account_number"
                                   v-model="form.account_number"
                                   :disabled="business.status == 'approved' ? true : false"
                            >
                            <invalid-feedback-component :message="validationMsg($v.form.account_number)"/>
                        </div>
                    </div>

                    <div class="d-flex mt-2 justify-content-center">

                        <div v-if="Object.keys(kyc).length === 0 || business.status == 'declined'">
                            <!-- uppy uploader container start-->
                            <div id="uppy" v-show="form.business_category == 'limited'">

                                <invalid-feedback-component
                                    class="d-block"
                                    v-if="$v.form.cac_document.$error"
                                    message="Upload company registration documents"
                                />
                            </div>

                            <!-- uppy uploader container end -->
                        </div>

                        <div v-if="business.status !== 'declined'">
                            <ul>
                                <li v-for="item in kyc" :key="item.id">
                                    {{ item.file_name }}
                                </li>
                            </ul>
                        </div>


                    </div>
                </div>

            </div>
        </div>
        <div class="kt-portlet__foot" v-show="business.status !== 'approved'">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-3 col-xl-3">
                    </div>
                    <div class="col-lg-9 col-xl-9">
                        <button type="button" @click="submitKyc" class="btn btn-success">Submit</button>&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </form>

</template>

<script>
    import FileUpload from 'vue-upload-component'
    import {validationMessage} from 'vuelidate-messages'
    import {required, requiredIf, numeric} from "vuelidate/lib/validators";
    import Loading from 'vue-loading-overlay';
    import InvalidFeedbackComponent from './InvalidFeedbackComponent'
    import Uppy from "@uppy/core";
    import Dashboard from "@uppy/dashboard";

    const nuban = (value) => value.length === 10;

    export default {
        name: "KycFormComponent",
        components: {
            FileUpload,
            InvalidFeedbackComponent,
            validationMessage,
            Loading,
            Uppy,
            Dashboard
        },
        props: {
            route: {
                required: true,
                type: String
            },
            business: {
                required: true,
                type: Object,
            },
            banks: {
                required: true,
                type: Array
            },
            kyc: {
                required: true,
                type: [Object, Array]
            },
            categories: {
                required: true,
                type: Object
            },
            onboard: {
                required: true,
                type: Object
            },
        },
        data() {
            return {
                uppy: {},
                uppyFiles: null,
                loader: {
                    isLoading: false,
                    fullPage: true,
                },
                form: {
                    business_category: this.business.category ? this.business.category : '',
                    bank_name: this.business.bank_account ? this.business.bank_account.bank.code : '',
                    account_name: this.business.bank_account ? this.business.bank_account.account_name : '',
                    account_number: this.business.bank_account ? this.business.bank_account.account_number : '',
                    cac_document: [],
                },
            }
        },
        validations() {
            return {
                form: {
                    business_category: {
                        required
                    },
                    bank_name: {
                        required,
                    },
                    account_name: {
                        required,
                    },
                    account_number: {
                        required,
                        numeric,
                        nuban
                    },
                    cac_document: {
                        required: requiredIf(function () {
                            return this.form.business_category === 'limited';
                        }),
                    },
                },
            }
        },
        methods: {
            convertFilesToBase64() {
                this.uppyFiles.forEach(function (file) {
                    let reader = new FileReader();
                    reader.onload = (event) => {
                        this.form.cac_document.push(event.target.result);
                    };
                    reader.readAsDataURL(file.data);
                }.bind(this));
            },
            formatBytes(bytes, decimals = 2) {
                if (bytes === 0) {
                    return '0 Bytes';
                }

                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));

                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            },
            validationMsg: validationMessage({
                required: () => 'This field is required',
                nuban: () => 'This field should be a NUBAN account number',
                numeric: () => 'This field should only contain numbers',
            }),
            submitKyc: function () {
                this.$v.$touch();
                if (this.$v.$invalid) {
                    return;
                }

                this.loader.isLoading = true;
                console.log(this.form);
                axios({
                    method: 'post',
                    url: `${this.route}`,
                    data: this.form,
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                    },
                })
                    .then(function (response) {
                        this.loader.isLoading = false;
                        window.location.reload();
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error.response.data);
                        this.loader.isLoading = false;
                    }.bind(this));
            },
        },
        mounted() {
            let uppy;
            this.uppy = uppy = new Uppy({
                debug: true,
                allowMultipleUploads: false,
                autoProceed: false,
                restrictions: {
                    maxFileSize: 1024 * 1024,
                    maxNumberOfFiles: 5,
                    allowedFileTypes: ['.jpg', '.jpeg', '.png', '.pdf']
                },
            })
                .use(Dashboard, {
                    inline: true,
                    height: 400,
                    width: 400,
                    locale: {
                        strings: {
                            'dropPaste': 'Drop files here or %{browse} to upload company registration documents',
                            'browse': 'click',
                        }
                    },
                    target: '#uppy',
                    proudlyDisplayPoweredByUppy: false,
                    hideUploadButton: true,
                    note: `Only images and documents are supported. Maximum of 1 file; up to ${this.formatBytes(1024 * 1024)}`,
                })
                .on('file-added', () => {
                    this.uppyFiles = uppy.getFiles();
                })
                .on('file-removed', () => {
                    this.uppyFiles = uppy.getFiles();
                });
        },

        filters: {
            toTitleCase(phrase) {
                return phrase
                    .toLowerCase()
                    .split(' ')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
            },
        },
        watch: {
            uppyFiles(value) {
                this.form.cac_document = [];
                this.convertFilesToBase64();
            }
        },
    }
</script>

<style scoped>

</style>
