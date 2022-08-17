<div class="form-group">
    <label for="example-readonly">Coupon Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name') ? old('name') : $coupon->name }}" placeholder="Coupon Name" required>
    @error("name") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Coupon Type</label>
    <select name="type" class="form-control">
        <option value="public">Public</option>
        <option value="private">Private</option>
    </select>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="example-readonly">Minimum Price</label>
            <input type="number" name="min_price" min="0" class="form-control" value="{{ old('min_price') ? old('min_price') : $coupon->min_price }}" placeholder="Minimum Price" >
            @error("min_price") <small style="color: red;"> {{ $message }} </small> @enderror
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="example-readonly">Maximum Price</label>
            <input type="number" name="max_price" class="form-control" value="{{ old('max_price') ? old('max_price') : $coupon->max_price }}" placeholder="Maximum Price" >
            @error("max_price") <small style="color: red;"> {{ $message }} </small> @enderror
        </div>
    </div>
</div>
<div class="form-group">
    <label for="example-readonly">Receiver's Name</label>
    <input type="text" name="receivers_name" class="form-control" value="{{ old('receivers_name') ? old('receivers_name') : $coupon->receivers_name }}" placeholder="Receiver's Name">
    @error("receivers_name") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Receiver's Email</label>
    <input type="email" name="receivers_email" class="form-control" value="{{ old('receivers_email') ? old('receivers_email') : $coupon->receivers_email }}" placeholder="Receiver's Email">
    @error("receivers_email") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Number of Usage</label>
    <input type="number" name="number_of_usage" class="form-control" min="1" value="{{ old('number_of_usage') ? old('number_of_usage') : $coupon->number_of_usage }}" placeholder="E.G 5" required>
    @error("number_of_usage") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Description</label>
    <textarea name="description" class="form-control" placeholder="Description" required>{{ old('description') ? old('description') : $coupon->description }}</textarea>
    @error("description") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Coupon Code</label>
    <input type="text" name="code" class="form-control" value="{{ $coupon->code ? $coupon->code : strtoupper(Str::random(6)) }}" placeholder="Coupon Code" required>
    @error("code") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Percentage</label>
    <input type="number" max="100" name="percentage" class="form-control" value="{{ old('percentage') ? old('percentage') : $coupon->percentage }}" required>
    @error("percentage") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<!-- <div class="form-group">
    <label for="example-readonly">Coupon Category</label>
    <div class="alert alert-warning">
        <ul class="mb-0">
            <li><strong>Signup - </strong> newly regsistered users</li>
            <li><strong>Spending - </strong> How much spent on a cart</li>
            <li><strong>Loyalty - </strong> How how long a user has been on the site</li>
        </ul>
    </div>
    <select name="type" class="form-control" required>
        <option>Select a Coupon Type</option>
        <option value="SIGNUP">Signup</option>
        <option value="SPENDING">Spending</option>
        <option value="LOYALTY">Loyalty</option>
    </select>
    @error("type") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Coupon Category Value</label>
    <div class="alert alert-warning">
        <ul class="mb-0">
            <li><strong>if Signup - </strong> type <strong><i>30</i></strong> for last 30 days</li>
            <li><strong>Spending - </strong>  type <strong><i>3000</i></strong> for minimum of 3000 spending/cart</li>
            <li><strong>Loyalty - </strong>  type <strong><i>360</i></strong> for users that have been on the platform for 360 days</li>
        </ul>
    </div>
    <input type="text" name="type_value" class="form-control" value="{{ old('type_value') ? old('type_value') : $coupon->type_value }}" required>
    @error("type_value") <small style="color: red;"> {{ $message }} </small> @enderror
</div> -->

<!-- <div class="form-group">
    <label>Location of Coupon:</label>
    <div class="kt-checkbox-list">
        <label class="kt-checkbox">
            <input type="checkbox" class="all" name="location[]" value="SITE_WIDE" checked> Site Wide
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
            <input type="checkbox" class="location" name="location[]" value="FASHION_PAGE"> Fashion Homepage
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
</div> -->
<div class="form-group">
    <label>Duration of display</label>
    <input class="form-control daterange" type="text" value="{{ old('date_range') ? old('date_range') : (isset($coupon->start_date) ? $coupon->start_date : '') }}" name="date_range" required>
    <span class="form-text text-muted">Select date range for display</span>
</div>

{{--<div class="form-group">
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
</div> --}}

@csrf
