<div class="kt-section kt-section--first">
    <div class="form-group">
        <label>Title:</label>
        <input type="text" name="title" value="{{ old('title', ($banner) ? $banner->title: null) }}" class="form-control" placeholder="Title">
        <input type="hidden" name="banner_type" value="{{ $banner_type }}" >
        <span class="form-text text-muted">Title of the banner upload</span>
    </div>
    @if ($banner_type == "slider")
        <div class="form-group row slide">
            <div class="col">
                <label>Image File URL:</label>
                <input type="file" name="file_url[]" class="form-control" placeholder="Image File">
                <span class="form-text text-muted">Image file of the banner</span>
            </div>
            <div class="col">
                <label>Image Link:</label>
                <input type="text" name="link[]" value="" class="form-control" placeholder="Image Link/URL">
                <span class="form-text text-muted">Optional: URL link of the banner</span>
            </div>
        </div>
        <div class="form-group row slide">
            <div class="col">
                <label>Image File URL:</label>
                <input type="file" name="file_url[]" class="form-control" placeholder="Image File">
                <span class="form-text text-muted">Image file of the banner</span>
            </div>
            <div class="col">
                <label>Image Link:</label>
                <input type="text" name="link[]" value="" class="form-control" placeholder="Image Link/URL">
                <span class="form-text text-muted">Optional: URL link of the banner</span>
            </div>
        </div>
        <div class="form-group row slide">
            <div class="col">
                <label>Image File URL:</label>
                <input type="file" name="file_url[]" class="form-control" placeholder="Image File">
                <span class="form-text text-muted">Image file of the banner</span>
            </div>
            <div class="col">
                <label>Image Link:</label>
                <input type="text" name="link[]" value="" class="form-control" placeholder="Image Link/URL">
                <span class="form-text text-muted">Optional: URL link of the banner</span>
            </div>
        </div>

        <div class="form-group text-right" id="slidebox">
            <a href="#" class="" id="addslider"><i class="la la-plus"></i> add another slider</a>
        </div>
    @else
        <div class="form-group row">
            <div class="col">
                <label>Image File URL:</label>
                <input type="file" name="file_url[]" class="form-control" placeholder="Image File">
                <span class="form-text text-muted">Image file of the banner</span>
            </div>
            <div class="col">
                <label>Image Link:</label>
                <input type="text" name="link[]" value="" class="form-control" placeholder="Image Link/URL">
                <span class="form-text text-muted">Optional: URL link of the banner</span>
            </div>
        </div>
    @endif

    <div class="form-group">
        <label>Location of Banner:</label>
        <div class="kt-checkbox-list">
            <label class="kt-checkbox">
                <input type="checkbox" class="all" name="location[]" {{ setlocation($location, "SITE_WIDE") }} value="SITE_WIDE"> Site Wide
                <span></span>
            </label>
            <label class="kt-checkbox">
                <input type="checkbox" class="location" name="location[]" {{ setlocation($location, "HOME_PAGE") }} value="HOME_PAGE"> Jollof Homepage
                <span></span>
            </label>
            <label class="kt-checkbox">
                <input type="checkbox" class="location" name="location[]" {{ setlocation($location, "CUISINE_PAGE") }} value="CUISINE_PAGE"> Cuisine Homepage
                <span></span>
            </label>
            <label class="kt-checkbox">
                <input type="checkbox" class="location" name="location[]" {{ setlocation($location, "LIFESTYLE_PAGE") }} value="LIFESTYLE_PAGE"> Lifestyle Homepage
                <span></span>
            </label>
            <label class="kt-checkbox">
                <input type="checkbox" class="location" name="location[]" {{ setlocation($location, "MOVIES_PAGE") }} value="MOVIES_PAGE"> Movies Homepage
                <span></span>
            </label>
            <label class="kt-checkbox">
                <input type="checkbox" class="location" name="location[]" {{ setlocation($location, "EVENTS_PAGE") }} value="EVENTS_PAGE"> Events Homepage
                <span></span>
            </label>
            <label class="kt-checkbox">
                <input type="checkbox" class="location" name="location[]" {{ setlocation($location, "TRAVEL_PAGE") }} value="TRAVEL_PAGE"> Jollof Travel
                <span></span>
            </label>
            <label class="kt-checkbox">
                <input type="checkbox" class="location" name="location[]" {{ setlocation($location, "TOURISM_PAGE") }} value="TOURISM_PAGE"> Tourism Homepage
                <span></span>
            </label>
            <label class="kt-checkbox">
                <input type="checkbox" class="location" name="location[]" {{ setlocation($location, "BUSINESS_PAGE") }} value="BUSINESS_PAGE"> Business Homepage
                <span></span>
            </label>
            <label class="kt-checkbox">
                <input type="checkbox" class="location" name="location[]" {{ setlocation($location, "SCHOLAR_PAGE") }} value="SCHOLAR_PAGE"> Scholar Homepage
                <span></span>
            </label>

        </div>
        <span class="form-text text-muted">Where do you want the banner to display?</span>
    </div>
    <div class="form-group">
        <label>Duration of display</label>
        <input class="form-control daterange" type="text" value="{{ $duration }}" name="start_date">
        <span class="form-text text-muted">Select date range for display</span>
    </div>
    <div class="form-group">
        <label>Who Can view Banner::</label>
        <div class="kt-checkbox-list">
            <label class="kt-checkbox">
                <input type="checkbox" name="can_view[]" value="EVERYONE"> Everyone
                <span></span>
            </label>
            <label class="kt-checkbox">
                <input type="checkbox" name="can_view[]" value="LOGGEDIN_USERS"> Loggedin Users
                <span></span>
            </label>
        </div>
        <span class="form-text text-muted">Well never share your email with anyone else</span>
    </div>
    <div class="form-group">
        <label>Status of Banner</label>
        <div class="kt-radio-inline">
            <label class="kt-radio">
                <input type="radio" name="status" value="active" checked {{ ($banner->status == "active") ? "checked" : "" }}>Active
                <span></span>
            </label>
            <label class="kt-radio">
                <input type="radio" name="status" value="inactive" {{ ($banner->status == "inactive") ? "checked" : "" }}> Inactive
                <span></span>
            </label>
        </div>
        <span class="form-text text-muted">Active status will display banner while inactive status will hide banner</span>
    </div>
</div>
