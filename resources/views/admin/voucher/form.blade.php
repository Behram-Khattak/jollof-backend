<div class="form-group">
    <label for="example-readonly">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title') ? old('title') : $voucher->title }}" placeholder="Title">
    @error("title") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Description</label>
    <textarea name="description" class="form-control" placeholder="Description">{{ old('description') ? old('description') : $voucher->description }}</textarea>
    @error("description") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Redemption Details</label>
    <textarea name="redemption_details" class="form-control" placeholder="Redemption Details">{{ old('redemption_details') ? old('redemption_details') : $voucher->redemption_details }}</textarea>
    @error("redemption_details") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label>Locations:</label>
    <div class="kt-checkbox-list">
        <label class="kt-checkbox">
            <input type="checkbox" class="all" name="location[]" {{ setlocation($locations, "SITE_WIDE") }} value="SITE_WIDE"> Site Wide
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" {{ setlocation($locations, "HOME_PAGE") }} value="HOME_PAGE"> Jollof Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" {{ setlocation($locations, "CUISINE_PAGE") }} value="CUISINE_PAGE"> Cuisine Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" {{ setlocation($locations, "FASHION_PAGE") }} value="FASHION_PAGE"> Fashion Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" {{ setlocation($locations, "LIFESTYLE_PAGE") }} value="LIFESTYLE_PAGE"> Lifestyle Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" {{ setlocation($locations, "MOVIES_PAGE") }} value="MOVIES_PAGE"> Movies Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" {{ setlocation($locations, "EVENTS_PAGE") }} value="EVENTS_PAGE"> Events Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" {{ setlocation($locations, "TRAVEL_PAGE") }} value="TRAVEL_PAGE"> Jollof Travel
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" {{ setlocation($locations, "TOURISM_PAGE") }} value="TOURISM_PAGE"> Tourism Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" {{ setlocation($locations, "BUSINESS_PAGE") }} value="BUSINESS_PAGE"> Business Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" {{ setlocation($locations, "SCHOLAR_PAGE") }} value="SCHOLAR_PAGE"> Scholar Homepage
            <span></span>
        </label>

    </div>
    <span class="form-text text-muted">Where do you want the vouocher to be used?</span>
</div>
<div class="form-group">
    <label>Validity Period</label>
    <input class="form-control daterange" type="text" value="" name="start_date">
    <span class="form-text text-muted">Select date range for display</span>
</div>

<div class="form-group">
    <label>Status</label>
    <div class="kt-radio-inline">
        <label class="kt-radio">
            <input type="radio" name="status" value="active" checked {{ ($voucher->status == "active") ? "checked" : "" }}>Active
            <span></span>
        </label>
        <label class="kt-radio">
            <input type="radio" name="status" value="inactive" {{ ($voucher->status == "inactive") ? "checked" : "" }}> Inactive
            <span></span>
        </label>
    </div>
    <span class="form-text text-muted">Active status will display banner while inactive status will hide banner</span>
</div>


@csrf
