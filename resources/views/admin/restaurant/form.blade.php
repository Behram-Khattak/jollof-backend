<div class="form-group">
    <label for="example-readonly">Restaurant Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name') ? old('name') : $restaurant->name }}" placeholder="Restaurant Name">
    @error("name") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<input type="hidden" name="business_type" value="cuisine">
<div class="form-group">
    <label for="example-readonly">About</label>
    <textarea name="about" class="form-control" placeholder="About Restaurant">{{ old('about') ? old('about') : $restaurant->about }}</textarea>
    @error("about") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Address</label>
    <textarea name="address" class="form-control" placeholder="Address">{{ old('address') ? old('address') : $restaurant->address }}</textarea>
    @error("address") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Restaurant Email</label>
    <input type="email" name="business_email" class="form-control" value="{{ old('business_email') ? old('business_email') : $restaurant->business_email }}" placeholder="Restaurant Email">
    @error("business_email") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <div class="row">
        <div class="col">
            <label for="example-readonly">Restaurant Telephone</label>
            <input type="tel" name="business_phone" class="form-control" value="{{ old('business_phone') ? old('business_phone') : $restaurant->business_phone }}" placeholder="Restaurant Telephone">
            @error("business_phone") <small style="color: red;"> {{ $message }} </small> @enderror
        </div>
        <div class="col">
            <label for="example-readonly">Restaurant Whatsapp</label>
            <input type="tel" name="business_whatsapp" class="form-control" value="{{ old('business_whatsapp') ? old('business_whatsapp') : $restaurant->business_whatsapp }}" placeholder="Restaurant Whatsapp">
            @error("business_whatsapp") <small style="color: red;"> {{ $message }} </small> @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="example-readonly">State</label>
    <select name="state" class="form-control select2" id="states">
        <option value="">Select State</option>
        @foreach (get_states() as $state_id => $state)
        <option value="{{ $state_id }}" {{ ($state_id == $restaurant->state) ? "selected" : "" }}>{{ $state }}</option>
        @endforeach
    </select>
    @error("state") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">City(area)</label>
    <select name="city" class="form-control select2" id="areas">
    </select>
    @error("state") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Minimum Order(NGN)</label>
    <input type="number" name="min_order" class="form-control" value="{{ old('min_order') ? old('min_order') : $restaurant->min_order }}" placeholder="Minimum Order">
    @error("min_order") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Delivery Fee(NGN)</label>
    <input type="number" name="delivery_fee" class="form-control" value="{{ old('delivery_fee') ? old('delivery_fee') : $restaurant->delivery_fee }}" placeholder="Delivery Fee">
    @error("delivery_fee") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Delivery Time <small class="text-muted">(in minutes)</small></label>
    <input type="number" name="delivery_time" class="form-control" value="{{ old('delivery_time') ? old('delivery_time') : $restaurant->delivery_time }}" placeholder="Delivery Time">
    @error("delivery_time") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label>Payment Otions Available</label>
    <div class="kt-checkbox-list">
        <label class="kt-checkbox">
            <input type="checkbox" name="delivery_options[]" value="PICK_UP"> Pick Up
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" name="delivery_options[]" value="DELIVER_TO_LOCATION"> Deliver to location
            <span></span>
        </label>
    </div>
    <span class="form-text text-muted">what payment options are available</span>
</div>

<div class="form-group">
    <label for="example-readonly">Package Fee(NGN)</label>
    <input type="number" name="disposable" class="form-control" value="{{ old('disposable') ? old('disposable') : $restaurant->disposable }}" placeholder="Plastic/Disposable pack">
    @error("disposable") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label>Payment Otions Available</label>
    <div class="kt-checkbox-list">
        <label class="kt-checkbox">
            <input type="checkbox" name="payment_types[]" value="CASH_ON_DELIVERY"> Cash on delivery
            <span></span>
        </label>
        <label class="kt-checkbox">
            <input type="checkbox" name="payment_types[]" value="DEBIT_CARD"> Debit Card
            <span></span>
        </label>
    </div>
    <span class="form-text text-muted">what payment options are available</span>
</div>

<div class="form-group">
    <label>Logo</label>
    <input class="form-control daterange" type="file" name="logo">
    <span class="form-text text-muted">Logo of resaurantt</span>
</div>

<div class="form-group">
    <label>Cover Picture</label>
    <input class="form-control daterange" type="file" name="cover">
    <span class="form-text text-muted">Cover image/picture to display on restaurant page</span>
</div>

<div class="form-group">
    <label>Featured</label>
    <div class="kt-radio-inline">
        <label class="kt-radio">
            <input type="radio" name="featured" value="1" {{ ($restaurant->featured) ? "checked" : "" }}>Featured
            <span></span>
        </label>
        <label class="kt-radio">
            <input type="radio" name="featured" value="0" {{ (!$restaurant->status) ? "checked" : "" }}> Not Featured
            <span></span>
        </label>
    </div>
    <span class="form-text text-muted">Featured Restaurants will display on cuisine home</span>
</div>

<div class="form-group">
    <label>Status</label>
    <div class="kt-radio-inline">
        <label class="kt-radio">
            <input type="radio" name="status" value="active"{{ ($restaurant->status == "active") ? "checked" : "" }}>Active
            <span></span>
        </label>
        <label class="kt-radio">
            <input type="radio" name="status" value="inactive" {{ ($restaurant->status == "inactive") ? "checked" : "" }}> Inactive
            <span></span>
        </label>
    </div>
    <span class="form-text text-muted">Active status will display restaurant</span>
</div>

@csrf
