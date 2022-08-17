<div class="form-group">
    <label for="example-readonly">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title') ? old('title') : $notification->title }}" placeholder="Title">
    @error("title") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Type</label>
    <select name="type" class="form-control">
        <option value="">Select a Notification Type</option>
        <option value="NONE">None</option>
        <option value="ANNOUNCEMENT">Announcement</option>
        <option value="NOTICE">Notice</option>
        {{-- <option value="mercedes">Mercedes</option>
        <option value="audi">Audi</option> --}}
    </select>
    @error("business_name_alt") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Notification Message</label>
    <textarea name="message" class="form-control" placeholder="Message">{{ old('message') ? old('message') : $notification->message }}</textarea>
    @error("message") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label>Location</label>
    <div class="kt-checkbox-list">
        <label class="kt-checkbox">
            <input type="checkbox" class="all" name="locations[]" {{ setlocation($location, "SITE_WIDE") }} value="SITE_WIDE"> Site Wide
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="locations[]" {{ setlocation($location, "HOME_PAGE") }} value="HOME_PAGE"> Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="locations[]" {{ setlocation($location, "CUISINE_PAGE") }} value="CUISINE_PAGE"> Cuisine
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="locations[]" {{ setlocation($location, "FASHION_PAGE") }} value="FASHION_PAGE"> Fashion
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="locations[]" {{ setlocation($location, "LIFESTYLE_PAGE") }} value="LIFESTYLE_PAGE"> Lifestyle
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="locations[]" {{ setlocation($location, "MOVIES_PAGE") }} value="MOVIES_PAGE"> Movies
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="locations[]" {{ setlocation($location, "EVENTS_PAGE") }} value="EVENTS_PAGE"> Events
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="locations[]" {{ setlocation($location, "TRAVEL_PAGE") }} value="TRAVEL_PAGE"> Travel
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="locations[]" {{ setlocation($location, "TOURISM_PAGE") }} value="TOURISM_PAGE"> Tourism
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="locations[]" {{ setlocation($location, "BUSINESS_PAGE") }} value="BUSINESS_PAGE"> Business
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="locations[]" {{ setlocation($location, "SCHOLAR_PAGE") }} value="SCHOLAR_PAGE"> Scholar
            <span></span>
        </label>

    </div>
    <span class="form-text text-muted">Where do you want the banner to display?</span>
</div>

<div class="form-group">
    <label for="example-readonly">Duration</label>
    <div class="input-group date">
        <input type="text" name="start_date" class="form-control daterange" value="{{ $duration }}" readonly="">
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="la la-calendar"></i>
            </span>
        </div>
    </div>
    @error("start_date") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label>Who Can view</label>
    <div class="kt-checkbox-list">
        <label class="kt-checkbox">
            <input type="checkbox" name="can_view[]" value="EVERYONE"> Everyone
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" name="can_view[]" value="LOGGEDIN_USERS"> Loggedin Users
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" name="can_view[]" value="NON_LOGGEDIN_USERS"> Non-Loggedin Users
            <span></span>
        </label>
    </div>
    <span class="form-text text-muted">Well never share your email with anyone else</span>
</div>

<div class="form-group">
    <label>Status</label>
    <div class="kt-radio-inline">
        <label class="kt-radio">
            <input type="radio" name="status" value="active" checked {{ ($notification->status == "active") ? "checked" : "" }}>Active
            <span></span>
        </label>
        <label class="kt-radio">
            <input type="radio" name="status" value="inactive" {{ ($notification->status == "inactive") ? "checked" : "" }}> Inactive
            <span></span>
        </label>
    </div>
    <span class="form-text text-muted">Active status will display notification while inactive status will hide notification</span>
</div>

@csrf
