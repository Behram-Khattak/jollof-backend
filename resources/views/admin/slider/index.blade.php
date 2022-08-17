@extends('admin.layouts.master')


@section('title', ''))

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title">Sliders</h3>
                        </div>
                    </div>
                </div>
                <div class="row p-4">
                    @foreach (microsites() as $m => $params)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $m }}</h5>
                                    <a href="{{ url('admin/slider/p/'.strtolower($m)) }}" class="btn btn-primary">See {{ $m }} Sliders</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>



            </div>
        </div>
    </div>
</div>


@endsection
