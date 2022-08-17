@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('css/select2-bootstrap.min.css') }}" rel="stylesheet" />
    <style>

        .select2-container--bootstrap .select2-selection--single{
            border-radius: 4px;
            padding: .65rem 1rem;
        }
        .select2-container .select2-selection--single {
            height: fit-content;
            border-radius: 0px;
            border: 1px solid #ced4da;
        }
    </style>
@endpush

<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="location" role="tabpanel" aria-labelledby="location-tab">
        <form action="{{ route('restaurant.search') }}" method="POST">
            <label for="">Delivery location</label>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="form-input">
                        <select name="state" class="form-control select2" id="states" style="margin-top:0px;" required>
                            <option value="">Select State</option>
                            @foreach (get_states() as $state_id => $state)
                            <option value="{{ $state_id }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-input">
                        <select name="city" class="form-control select2" id="areas" style="margin-top:0px;" required>
                        </select>
                        @csrf
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <button type="submit" class="btn btn-info btn-join">SEARCH</button>
                </div>
            </div>
        </form>
    </div>
    <div class="tab-pane fade" id="name" role="tabpanel" aria-labelledby="name-tab">
        <form action="{{ route('restaurant.search') }}" method="POST">
            <label for="">Enter name of restaurant</label>
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="form-input">

                        <select name="restaurant" class="form-control select2" id="restaurants" style="margin-top:0px;" required>
                            <option value="0">All</option>
                            @foreach ($allRestaurants as $res)
                            <option value="{{ $res->name }}">{{ $res->name }}</option>
                            @endforeach
                        </select>
                        @csrf
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <button type="submit" class="btn btn-info btn-join">SEARCH</button>
                </div>
            </div>
        </form>
    </div>
</div>
