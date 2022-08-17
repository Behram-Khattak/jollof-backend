@extends('merchant.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

@if ($business->isEmpty())
<div class="py-5 text-center">
    <p>No restaurants added yet</p>
</div>
@else
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Restaurants
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div
                        id="kt_table_1_wrapper"
                        class="kt_dataTables_wrapper"
                      >
                        <div class="row">
                          <div class="col-sm-12">
                            <table
                              class="kt-datatable"
                              id="roles-table"
                              width="100%"
                              role="grid"
                            >
                              <thead>
                                <tr>
                                    {{--  <th>Logo</th>  --}}
                                    <th>Name & Address</th>
                                    <th>Location</th>
                                    <th></th>
                                </tr>
                              </thead>

                              <tbody>
                                  @foreach ($business as $r)
                                  <tr role="row" class="odd">
                                    {{--  <td><img src="{{ ($business->getMedia(App\Enums\MediaCollectionNames::LOGO)->isEmpty()) ? 'images/vendor-one.png' : $business->getMedia(App\Enums\MediaCollectionNames::LOGO)[0]->getFullUrl() }}" class="img-fluid" alt=""></td>  --}}
                                    <td><strong><a href="{{ route('merchant.restaurant.menu', request()->route('business')) }}">{{ $r->name }}</a></strong><br>{{ $r->address }}</td>
                                    <td>{{ $r->name }}</td>
                                    <td>
                                        <a class="btn btn-outline-primary" href="{{ route('merchant.restaurant.settings', request()->route('business')) }}"><i class="fa fa-cog"></i></a>
                                          {{--<a class="btn btn-outline-primary" href="{{ route('merchant.restaurant.edit', ['any'=> $r->slug]) }}"><i class="fa fa-pen"></i></a>
                                           <a class="btn btn-outline-danger delete" href="#" data-toggle="modal" data-target=".delete-modal-sm" onclick="document.getElementById('delete-modal').action='/admin/restaurant/{{ $r->id }}'"><i class="fa fa-trash"></i></a> --}}
                                    </td>
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

@endif


<div class="modal fade delete-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Delete Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" class="delete-form" id="delete-modal">
                <div class="modal-body">

                    <p>Are you sure you want to delete the restaurant?</p>
                    @csrf
                    @method('DELETE')

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
