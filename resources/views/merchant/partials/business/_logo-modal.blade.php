<div class="modal fade"
     id="businessLogo"
     tabindex="-1"
     role="dialog"
     aria-labelledby="businessLogoLabel"
     aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="businessLogoLabel">Upload Business Logo</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--begin::Form-->
            <div class="modal-body">

                <image-upload-component
                    route="{{ route('merchant.business.logo.store', $business) }}"
                    ratio="1"
                    placeholder="Select Business Logo"
                />

            </div>
        </div>
    </div>
</div>
