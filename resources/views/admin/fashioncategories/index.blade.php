@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">

      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Fashion Categories
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <!-- <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow. -->
              <div class="row">
                  <div class="col-lg-12">

                      <div class="kt-portlet kt-portlet--mobile">
                          <div class="kt-portlet__head">
                              <div class="kt-portlet__head-label">
                                  <h3 class="kt-portlet__head-title">
                                      Fashion Categories
                                  </h3>
                              </div>
                              <div class="kt-portlet__head-toolbar">
                                  <a class="btn btn-primary" href="/admin/categories/create" role="button"><i class="la la-plus"></i> Add New caegory</a>
                                </div>
                                <div class="kt-portlet__head-toolbar">
                                <a class="btn btn-primary" href="" data-toggle="modal" data-target="#addmaterial" role="button"><i class="la la-plus"></i> Add New Material</a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Layaway settings
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <form action="{{route('admin.layaway.settings')}}" method="post">
                @csrf
                <div class="form-group">
                  <label for="exampleFormControlInput1">Service Fee</label>
                  <input type="number" name="service_fee" class="form-control" placeholder="Enter Service fee. E.G 1500" value="{{$layaway->service_fee ?? ''}}">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput2">Down Payment Percentage(In %)</label>
                  <input type="number" name="down_percentage" min="1" max="100" class="form-control" placeholder="Enter Down payment Percentage" value="{{$layaway->down_percentage ?? ''}}">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput3">Cancellation Fee</label>
                  <input type="number" name="cancellation_fee" class="form-control" placeholder="Enter Cancellation Fee" value="{{$layaway->cancellation_fee ?? ''}}">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput4">Price Limit</label>
                  <input type="number" name="price_limit" class="form-control" placeholder="Enter Price Limit" value="{{$layaway->price_limit ?? ''}}">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput4">Layaway period (In weeks)</label>
                  <input type="number" name="period" class="form-control" placeholder="Enter Period Limit. E.g 4" value="{{$layaway->period ?? ''}}">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput4">Extension limits (In weeks)</label>&nbsp;<small style="color:red">How many weeks per extension*</small>
                  <input type="number" name="extension_limit" class="form-control" placeholder="Enter How many weeks per extension. E.g 1" value="{{$layaway->extension_limit ?? ''}}">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput4">Maximum number of extension (In weeks)</label>&nbsp;<small style="color:red">How many times can a user extends*</small>
                  <input type="number" name="number_of_extension" class="form-control" placeholder="Enter How many times can a user extends. E.g 3" value="{{$layaway->number_of_extension ?? ''}}">
                </div>
                <div>
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>

              </form>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Jollof Point settings
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <form action="{{route('admin.jollofpoint.settings')}}" method="post">
                  @csrf
                  <div class="form-group">
                    <label for="exampleFormControlInput4">How much is a point?</label>&nbsp;
                    <input type="number" name="amount_per_point" class="form-control" value="{{$jollofpoint->amount_per_point ?? ''}}" placeholder="Enter How many times can a user extends. E.g 3" value="{{$layaway->number_of_extension ?? ''}}">
                  </div>
                  <div>
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>


<div class="modal fade" id="addmaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new material</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/admin/material/add" method="post">
      @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="subcategory">Enter new material</label>
                <input type="text" class="form-control" name="material" placeholder="Enter Material name" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
