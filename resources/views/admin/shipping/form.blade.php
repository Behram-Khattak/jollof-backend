<div class="form-group">
    <label for="example-readonly">Min. Shippment Quantity</label>
    <input name="min_shipment_qty" type="text" class="form-control" value="{{ $group->min_shipment_qty ? old('min_shipment_qty', $group->min_shipment_qty) : '' }}" placeholder="Min. Shipment Quantity">
    @error("min_shipment_qty") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Max. Shipment Quantity</label>
    <input name="max_shipment_qty" type="text" class="form-control" value="{{ $group->max_shipment_qty ? old('max_shipment_qty', $group->max_shipment_qty) : '' }}" placeholder="Max. Shipment Quantity">
    @error("max_shipment_qty") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Shipment Price</label>
    <input name="shipment_price" type="text" class="form-control" value="{{ $group->shipment_price ? old('shipment_price', $group->shipment_price) : '' }}" placeholder="Shipping Price">
    @error("shipment_price") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Shipment Locations</label>
    <select name="areas[]" class="form-control select2" multiple="multiple">
        @foreach ($state->areas as $area)
            <option value="{{ $area->id }}">{{ $area->area }}</option>
        @endforeach

    </select>
    <input type="hidden" name="state" value="{{ $state->id }}">
    @error("areas") <small style="color: red;"> {{ $message }} </small> @enderror
</div>


@push('scripts')
<script>
    $(function(){
        $('.select2').select2();
    });
</script>


@endpush
