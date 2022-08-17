<div class="modal fade"
     id="profilePhoto"
     tabindex="-1"
     role="dialog"
     aria-labelledby="profilePhotoLabel"
     aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="profilePhotoLabel">Upload Profile Picture</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--begin::Form-->
            <div class="modal-body">

                <image-upload-component
                    route="{{ route('merchant.photo.store') }}"
                    ratio="1"
                    placeholder="Select Profile Picture"
                />

            </div>
        </div>
    </div>
</div>
