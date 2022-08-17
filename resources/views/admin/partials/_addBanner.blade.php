<div class="modal fade  update-banner-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Add Banner Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('admin.banner.update') }}" enctype="multipart/form-data" method="POST">
                <div class="modal-body">

                    <div class="form-group row slide">
                        <div class="col">
                            <label>Banner Image:</label>
                            <input type="file" name="file_url" class="form-control" placeholder="Image File" required>
                            <span class="form-text text-muted">Image file of the advert</span>
                        </div>
                        <div class="col">
                            <label>Banner Link:</label>
                            <input type="text" name="link" value="" class="form-control" placeholder="Image Link/URL" required>
                            <span class="form-text text-muted">Optional: URL link of the advert</span>
                        </div>
                        <input type="hidden" name="banner" value="{{ $banner->id }}">
                    </div>
                    @csrf


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Banner Image</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
