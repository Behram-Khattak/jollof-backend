@extends('layouts.master')

@section('title', 'Shipping Address')

@section('content')

<main>
    <article>
        <div class="my-orders-wrapper mb-5">
            <div class="container">

                <br /><br />

                <div class="">
                    <h4>My Account</h4>
                    @include('user.partials._myAccount')
                </div>
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-uppercase">my settings</h6>
                    </div>

                    <div class="container" id="profile">

                        <div class="profile-div">
                            <form action="{{ route('user.settings.shipping.store') }}" method="POST">

                                <div class="text-capitalize font-weight-bold">
                                    <p>Shipping Address</p>
                                    <hr />
                                    @csrf
                                </div>
                                @if($shipping->isEmpty())
                                <div class="shippingAddress">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label for="">Street Address</label>
                                                <input type="text" class="form-control" value="" name="address[]" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label for="">Address Type</label>
                                                <select name="type[]" class="form-control" id="states" required style="margin-top:0px;">
                                                    <option value="home">Home</option>
                                                    <option value="office">Office</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">Your State</label>
                                                <select name="state[]" class="form-control states" id="states" required style="margin-top:0px;">
                                                    <option value="">Select State</option>
                                                    @foreach (get_states() as $state_id => $state)
                                                    <option value="{{ $state_id }}">{{ $state }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">Your City - Area</label>
                                                <select class="form-control userCity" name="city[]" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else

                                    @for($f = 0; $f <= 1; $f++)
                                    <div class="shippingAddress">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <h5>{{ isset($shipping[$f]) ? ucfirst($shipping[$f]->type) : "Add" }} Address</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="">Street Address</label>
                                                    <input type="text" class="form-control" value="{{ isset($shipping[$f]) ? $shipping[$f]->address : '' }}" name="address[]" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="">Address Type</label>
                                                    @if(isset($shipping[$f]->type))
                                                    <input type="text" class="form-control" readonly value="{{ empty($addressTypes) ? $shipping[$f]->type : $addressTypes }}" name="type[]" required>
                                                    @else
                                                    <select name="type[]" class="form-control" id="states" required style="margin-top:0px;">
                                                        <option value="home">Home</option>
                                                        <option value="office">Office</option>
                                                    </select>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="">Your State</label>
                                                    <select name="state[]" class="form-control states" id="" required style="margin-top:0px;">
                                                        <option value="">Select State</option>
                                                        @foreach (get_states() as $state_id => $state)
                                                        <option value="{{ $state_id }}" {{ (isset($shipping[$f]) && $state == $shipping[$f]->state) ? "selected" : "" }}>{{ $state }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="">Your City - Area</label>
                                                    <select class="form-control userCity" name="city[]" required>
                                                        @if(isset($shipping[$f]))
                                                            @foreach (locations_json($shipping[$f]->state) as $area)
                                                            <option value="{{ $area }}" {{ ($area == $shipping[$f]->city) ? "selected" : "" }}>{{ $area }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    @endfor
                                @endif

                                <button type="submit" class="btn btn-info btn-start">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</main>
<div id="state-data" style="display: none;">{{ json_encode(locations_json()) }}</div>
@endsection

@push('scripts')
<script>
    $(function(){
        $("body").on("change", ".states", function(){
            var state = $(this).val();
            var data = JSON.parse($("#state-data").html());
            var areas = data[state];
            var options = $(this).parents(".shippingAddress").find(".userCity");
            $.each(areas, function(index, value) {
                options.append("<option value='"+ index +"'>" + value + "</option>");
            });
        });
    });

</script>


@endpush
