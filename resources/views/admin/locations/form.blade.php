<div class="form-group">
    <label for="example-readonly">Coupon Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name') ? old('name') : $coupon->name }}" placeholder="Coupon Name">
    @error("name") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Description</label>
    <textarea name="description" class="form-control" placeholder="Description">{{ old('description') ? old('description') : $coupon->description }}</textarea>
    @error("description") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Coupon Code</label>
    <input type="text" name="code" class="form-control" value="{{ old('code') ? old('code') : $coupon->code }}" placeholder="Coupon Code">
    @error("code") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Percentage</label>
    <input type="text" name="percentage" class="form-control" value="{{ old('percentage') ? old('percentage') : $coupon->percentage }}">
    @error("percentage") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Coupon Category</label>
    <select name="type" class="form-control">
        <option>Select a Coupon Type</option>
        <option value="SIGNUP">Signup</option>
        <option value="SPENDING">Spending</option>
        <option value="LOYALTY">Loyalty</option>
        <option value="REFERAL">Referal</option>
    </select>
    @error("type") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Coupon Category Value</label>
    <input type="text" name="type_value" class="form-control" value="{{ old('type_value') ? old('type_value') : $coupon->type_value }}">
    @error("type_value") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label>Location of Coupon:</label>
    <div class="kt-checkbox-list">
        <label class="kt-checkbox">
            <input type="checkbox" class="all" name="location[]" value="SITE_WIDE"> Site Wide
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" value="HOME_PAGE"> Jollof Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" value="CUISINE_PAGE"> Cuisine Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" value="LIFESTYLE_PAGE"> Lifestyle Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" value="MOVIES_PAGE"> Movies Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" value="EVENTS_PAGE"> Events Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" value="TRAVEL_PAGE"> Jollof Travel
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" value="TOURISM_PAGE"> Tourism Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" value="BUSINESS_PAGE"> Business Homepage
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" class="location" name="location[]" value="SCHOLAR_PAGE"> Scholar Homepage
            <span></span>
        </label>

    </div>
    <span class="form-text text-muted">Where do you want the banner to display?</span>
</div>
<div class="form-group">
    <label>Duration of display</label>
    <input class="form-control daterange" type="text" value="{{ old('start_date') ? old('start_date') : (isset($coupon->start_date) ? $coupon->start_date : '') }}" name="start_date">
    <span class="form-text text-muted">Select date range for display</span>
</div>

<div class="form-group">
    <label>Status</label>
    <div class="kt-radio-inline">
        <label class="kt-radio">
            <input type="radio" name="status" value="active" {{ ($coupon->status == "active") ? "checked" : "" }}>Active
            <span></span>
        </label>
        <label class="kt-radio">
            <input type="radio" name="status" value="inactive" {{ ($coupon->status == "inactive") ? "checked" : "" }}> Inactive
            <span></span>
        </label>
    </div>
    <span class="form-text text-muted">Active status will display coupon</span>
</div>

@csrf
