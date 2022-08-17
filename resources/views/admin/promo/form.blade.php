<div class="form-group">
    <label for="example-readonly">promo Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name') ? old('name') : $promo->name }}" placeholder="promo Name" required>
    @error("name") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Description</label>
    <textarea name="description" class="form-control" placeholder="Description" required>{{ old('description') ? old('description') : $promo->description }}</textarea>
    @error("description") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label>Duration of display</label>
    <input class="form-control daterange" type="text" value="{{ old('date_range') ? old('date_range') : (isset($promo->start_date) ? $promo->start_date : '') }}" name="date_range" required>
    <span class="form-text text-muted">Select date range for display</span>
</div>


@csrf
