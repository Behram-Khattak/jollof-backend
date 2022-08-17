<div class="kt-section kt-section--first">
    <div class="form-group">
        <label>Title:</label>
        <input type="text" name="title" value="{{ old('title', ($banner) ? $banner->title: null) }}" class="form-control" placeholder="Title">
        <span class="form-text text-muted">Title of the banner upload</span>
    </div>
    <div class="form-group">
        <label>Duration of display</label>
        <input class="form-control daterange" type="text" value="{{ $duration }}" name="start_date">
        <span class="form-text text-muted">Select date range for display</span>
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
                <input type="checkbox" name="can_view[]" value="NON_LOGGEDIN_USERS"> Loggedin Users
                <span></span>
            </label>
        </div>
        <span class="form-text text-muted">Well never share your email with anyone else</span>
    </div>
    <div class="form-group">
        <label>Status</label>
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
