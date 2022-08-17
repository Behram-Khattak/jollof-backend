<template>

    <div class="card">
        <div class="card-body">
            <form-wizard>
                <tab-content title="Profile">
                    <form class="kt-form kt-form--label-right" id="kt_profile_form">
                        <div class="kt-portlet__body">
                            <div class="kt-section kt-section--first">
                                <div class="kt-section__body">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Business Name</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control" type="text" value="Nick">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Business Description</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <textarea id="description"
                                                      name="business_description"
                                                      class="form-control w-100"
                                                      rows="4"
                                                      required
                                            ></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h3 class="kt-section__title kt-section__title-sm">Contact Info:</h3>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                                                <input type="text" class="form-control" value="+35278953712" placeholder="Phone" aria-describedby="basic-addon1">
                                            </div>
                                            <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                                <input type="text" class="form-control" value="nick.bold@loop.com" placeholder="Email" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-last row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Company Site</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Username" value="loop">
                                                <div class="input-group-append"><span class="input-group-text">.com</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </tab-content>
                <tab-content title="KYC">
                    <form class="kt-form kt-form--label-right" id="kt_kyc_form">
                        <div class="kt-portlet__body">
                            <div class="kt-section kt-section--first">
                                <div class="kt-section__body">
                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h3 class="kt-section__title kt-section__title-sm">Customer Info:</h3>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control" type="text" value="Nick">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control" type="text" value="Bold">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Company Name</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control" type="text" value="Loop Inc.">
                                            <span class="form-text text-muted">If you want your invoices addressed to a company. Leave blank to use your full name.</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h3 class="kt-section__title kt-section__title-sm">Contact Info:</h3>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                                                <input type="text" class="form-control" value="+35278953712" placeholder="Phone" aria-describedby="basic-addon1">
                                            </div>
                                            <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                                <input type="text" class="form-control" value="nick.bold@loop.com" placeholder="Email" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-last row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Company Site</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Username" value="loop">
                                                <div class="input-group-append"><span class="input-group-text">.com</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </tab-content>
                <tab-content title="Locations">
                    Yuhuuu! This seems pretty damn simple
                </tab-content>
                <tab-content title="Teams">
                    Yuhuuu! This seems pretty damn simple
                </tab-content>
                <tab-content title="Upload Logo">
                    Yuhuuu! This seems pretty damn simple
                </tab-content>
                <tab-content title="Upload Banner">
                    Yuhuuu! This seems pretty damn simple
                </tab-content>
            </form-wizard>
        </div>
    </div>

<!--    <div class="kt-portlet__content">-->
<!--    </div>-->



</template>

<script>
    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'

    export default {
        name: "MerchantWelcomeComponent",
        components: {
            FormWizard,
            TabContent
        }
    }
</script>

<style scoped>

</style>
