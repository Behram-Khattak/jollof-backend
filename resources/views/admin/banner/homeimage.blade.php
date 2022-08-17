@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">

        <div class="row">
            <div class="col-md-12">
                <h5>Home Image Displays</h5>
            </div>
        </div>

        @include("partials._flash")

        @php
            $allsites = $sites;
        @endphp

        <div class="row">
            @foreach ($images as $image)
                <div class="col-md-4">
                    <div class="card card-custom mb-3">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">{{ $image->name }}</h3>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $publicUrl = $image->getFirstMediaUrl('homeblock');
                            @endphp
                            <img src="{{ $publicUrl }}" class="img-fluid" />
                        </div>
                        @can('update-banners')
                        <div class="card-toolbar text-center">
                            <a href="#" class="btn btn-sm btn-primary btn-hover-light-primary m-2 uploadimage"
                            data-toggle="modal" data-target="#uploadImage"
                            data-site="{{ $image->site }}">
                                Edit
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
                @php
                    unset($allsites[$image->site])
                @endphp
            @endforeach

            @if (count($allsites) > 0)
                @foreach ($allsites as $key => $site)
                    <div class="col-md-4">
                        <div class="card card-custom mb-3">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">{{ $site }}</h3>
                                </div>
                            </div>
                            <div class="card-body">
                            ...
                            </div>
                            @can('create-banners')
                            <div class="card-toolbar text-center">
                                <a href="#" class="btn btn-sm btn-primary btn-hover-light-primary m-2 uploadimage"
                                data-toggle="modal" data-target="#uploadImage"
                                data-site="{{ $key }}">
                                    Add
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="uploadImage" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Manage Home Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.home.image.update') }}" enctype="multipart/form-data" method="POST">
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <label>Microsite:</label>
                    <select name="site" id="sitename" class="form-control" required>
                        @foreach ($sites as $key => $site)
                            <option value="{{ $key }}">{{ $site }}</option>
                        @endforeach

                    </select>
                    <span class="form-text text-muted">Name of the microsite</span>
                </div>
                <div class="col-md-12 mt-4">
                    <label>Block Status:</label>
                    <select name="status" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    <span class="form-text text-muted">Will the block connect to a module?</span>
                </div>
                <div class="col-md-12 mt-4">
                    <label>Home Image:</label>
                    <input type="file" name="file_url" class="form-control" placeholder="Image File" required>
                    <span class="form-text text-muted">Image file for the microsite</span>
                </div>
                <div class="col-md-12 mt-4">
                    <label>Slogan</label>
                    <input type="text" min="30" max="35" name="slogan" class="form-control" placeholder="Slogan" required>
                    <span class="form-text text-muted">Brief slogan for the microsite</span>
                </div>
            </div>
            @csrf
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

@push('scripts')
<script>
$(function(){
    $('body').on("click", ".uploadimage", function(e){
        e.preventDefault();
        let site = $(this).data("site");
        $("#sitename").val(site);
    })
});
</script>
@endpush
