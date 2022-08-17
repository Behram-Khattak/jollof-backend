@extends('merchant.layouts.master')

@section('title', config('app.name', 'Laravel'))


@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                @include('partials._flash')

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Restaurant Settings
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div id="kt_table_1_wrapper" class="kt_dataTables_wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="list-group">
                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">Minimum Order</h5>
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#minorder">Edit</a>
                                            </div>
                                            <small>Manage the mnimum amount an order can be on your online store</small>
                                            <p class="mt-2">NGN {{ $restaurant->min_order }}</p>
                                        </div>

                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="">Delivery Time</h5>
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#deliverytime">Edit</a>
                                            </div>
                                            <small>What is the average time it takes for an order to be delivered to the customer</small>
                                            <p class="mt-3">{{ $restaurant->delivery_time }} minutes</p>
                                        </div>

                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">Open hours</h5>
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#openhours">Edit</a>
                                            </div>
                                            <small>What are your working hours? This enable customers to make orders only when you are open</small>

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Day</th>
                                                        <th>Status</th>
                                                        <th>Open</th>
                                                        <th>Close</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($hours as $day => $hour)

                                                    <tr>
                                                        <td>{{ $day }}</td>
                                                        <td>{{ (isset($isopen[$day]) && $isopen[$day] == 1) ? 'Opened' : 'Closed' }}</td>
                                                        <td>{{ $hour[0] }}</td>
                                                        <td>{{ $hour[1] }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                      </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="minorder" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Minimum Order Amount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form method="POST" action="{{ route('merchant.restaurant.setting.update', request()->route('business')) }}">
                @csrf
                @method('PATCH')
            <div class="modal-body">
                <label>Minimum Order Amount</label>
                <input type="number" class="form-control" name="min_order" min="0" placeholder="Minimum Order Amount" value="{{ $restaurant->min_order }}" required />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deliverytime" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Average Delivery Time</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form method="POST" action="{{ route('merchant.restaurant.setting.update', request()->route('business')) }}">
                @csrf
                @method('PATCH')
            <div class="modal-body">
                <label>Average Delivery Time (In mins)</label>
                <input type="text" class="form-control" name="delivery_time" placeholder="20-50" value="{{ $restaurant->delivery_time }}" required />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="openhours" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Restaurant opening hours</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form method="POST" action="{{ route('merchant.restaurant.setting.update', request()->route('business')) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="hours" value="1" />
            <div class="modal-body">
                <label>Set Opening Hours</label>
                <table class="table">

                @foreach ($hours as $day => $hour)

                    @php

                        $open = explode(':', $hour[0]);
                        $close = explode(':', $hour[1]);
                        $status = isset($isopen[$day]) ? $isopen[$day] : 0;
                    @endphp
                    <tr>
                        <td><input name="day[]" class="form-control plaintext" value="{{ $day }}" readonly  /></td>
                        <td>
                            <select name="status[]" class="form-control">
                                <option value="1" {{ ($status) ? 'selected' : '' }}>Opened</option>
                                <option value="0" {{ (!$status) ? 'selected' : '' }}>Closed</option>
                            </select>
                        </td>
                        <td><input type="number" min="0" max="23" name="open[]" class="form-control plain-text" value="{{ $open[0] }}" required /></td>
                        <td><input type="number" min="0" max="23" name="close[]" class="form-control plain-text" value="{{ $close[0] }}" required /></td>
                    </tr>

                @endforeach
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')



@endpush

