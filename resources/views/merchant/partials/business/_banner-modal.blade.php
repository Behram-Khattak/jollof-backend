<div class="modal fade"
     id="businessBanner"
     tabindex="-1"
     role="dialog"
     aria-labelledby="businessBannerLabel"
     aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="businessBannerLabel">Upload Business Banner</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--begin::Form-->
            <div class="modal-body">

                <image-upload-component
                    route="{{ route('merchant.business.banner.store', $business) }}"
                    ratio="3"
                    placeholder="Select Business Banner"
                />

            </div>
        </div>
    </div>
</div>
