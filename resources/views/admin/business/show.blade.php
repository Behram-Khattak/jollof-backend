@extends('admin.layouts.master')

@section('title', 'Business Review | Jollof')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

    <!--Begin::App-->
    <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

        <!--Begin:: App Aside Mobile Toggle-->
        <button class="kt-app__aside-close" id="kt_profile_aside_close">
            <i class="la la-close"></i>
        </button>

        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">{{ ucwords($business->name) }} Details</h3>
                    </div>
                    @if ($business->status === \App\Enums\BusinessStates::PENDING)
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-group">
                            <form style="display: inline-block;" action="{{ route('admin.business.approve', $business) }}" method="post">
                                @csrf

                                @method('PATCH')
                                @can('approve-business')
                                <button type="submit" class="btn btn-outline-success btn-bold btn-sm btn-upper">
                                    Approve
                                </button>
                                @endcan
                            </form>
                            @can('unapprove-business')
                            <button type="button" class="btn btn-outline-danger btn-bold btn-sm btn-upper" data-toggle="modal" data-target="#decline">
                                Decline
                            </button>
                            @endcan
                        </div>
                    </div>
                    @endif

                    @if ($business->status === \App\Enums\BusinessStates::APPROVED)
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-group">
                            <form style="display: inline-block;" action="{{ route('admin.business.unapprove', $business) }}" method="post">
                                @csrf

                                @method('PATCH')
                                @can('unapprove-business')
                                <button type="submit" class="btn btn-outline-success btn-bold btn-sm btn-upper">
                                    UnApprove
                                </button>
                                @endcan

                            </form>
                        </div>
                    </div>
                    @endif
                </div>
                <form class="kt-form kt-form--label-right" id="kt_profile_form">
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label" for="business-owner">
                                        {{ $business->owner ? 'Business Owner' : 'Business Manager' }}
                                    </label>
                                    <div class="col-lg-9 col-xl-6 align-self-center">
                                        @if($business->owner)
                                        <a href="{{ route('admin.users.show', $business->owner) }}">
                                            {{ $business->owner->full_name }}
                                        </a>
                                        @else
                                        <a href="{{ route('admin.users.show', $business->manager) }}">
                                            {{ $business->manager->full_name }}
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label" for="business-type">
                                        Business Type
                                    </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <select class="form-control" id="business-type" name="business_type" {{ $business->status == \App\Enums\BusinessStates::PENDING ? 'disabled' : '' }}>
                                            <option value="" selected disabled hidden>
                                                -- Please select an option --
                                            </option>
                                            @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old('business_type', $business->type->name) == $type->name ? 'selected' : '' }}>
                                                {{ ucwords($type->name) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Business Category</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <select class="form-control" id="business-type" name="business_type" {{ $business->status == \App\Enums\BusinessStates::PENDING ? 'disabled' : '' }}>
                                            <option value="" selected disabled hidden>
                                                -- Please select an option --
                                            </option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ old('business_category', $business->category) == $category ? 'selected' : '' }}>
                                                {{ ucfirst($category) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label" for="business-name">
                                        Business Name
                                    </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" type="text" id="business-name" name="business_name" value="{{ $business->name }}" {{ $business->status == \App\Enums\BusinessStates::PENDING ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label" for="business-email">Business
                                        Email</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-at"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="business-email" value="{{ old('business_email', $business->email) }}" aria-describedby="basic-addon1" name="business_email" {{ $business->status == \App\Enums\BusinessStates::PENDING ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label" for="business-telephone">
                                        Telephone
                                    </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-phone"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="business-telephone" value="{{ old('business_telephone', $business->telephone) }}" aria-describedby="basic-addon2" name="business_telephone" {{ $business->status == \App\Enums\BusinessStates::PENDING ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label" for="business-whatsapp">WhatsApp</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-whatsapp"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="business-whatsapp" value="{{ old('business_whatsapp', $business->whatsapp) }}" aria-describedby="basic-addon2" name="business_whatsapp" {{ $business->status == \App\Enums\BusinessStates::PENDING ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label" for="description">
                                        Description
                                    </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <textarea id="description" name="business_description" class="form-control w-100 @error('business_description') is-invalid @enderror" rows="4" required {{ $business->status == \App\Enums\BusinessStates::PENDING ? 'disabled' : '' }}>{{ old('business_description', $business->description) }}</textarea>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label" for="description">
                                            Approval Status
                                        </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select class="form-control" name="status">
                                                <option value="approved" {{ ($business->status == 'approved') ?? 'selected' }}>Approved</option>
                                <option value="pending" {{ ($business->status == 'pending') ?? 'selected' }}>Pending</option>
                                <option value="declined" {{ ($business->status == 'declined') ?? 'selected' }}>Declined</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label" for="description">
                                KYC Documents
                            </label>
                            <div class="col-lg-9 col-xl-6">
                                @forelse($kyc as $media)
                                <div class="kt-widget-7">
                                    <div class="kt-widget-7__items p-0">
                                        <div class="kt-widget-7__item">
                                            <div class="kt-widget-7__item-info">
                                                <a href="{{ $media->getUrl() }}" class="kt-widget-7__item-title">
                                                    {{ $media->file_name }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @empty

                                <div class="kt-widget-7">
                                    <div class="kt-widget-7__items p-0">
                                        <div class="kt-widget-7__item">
                                            <div class="kt-widget-7__item-info">
                                                <div class="kt-widget-7__item-desc">
                                                    Not Available
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforelse
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        @if ($business->status !== \App\Enums\BusinessStates::PENDING)
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-3 col-xl-3">
                    </div>
                    <div class="col-lg-9 col-xl-9">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        </form>
    </div>
</div>

<!--End:: App Content-->
</div>

<!--End::App-->
</div>

<div class="modal fade" id="decline" tabindex="-1" role="dialog" aria-labelledby="declineLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="declineLabel">Decline Business</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--begin::Form-->
            <div class="modal-body">

                <form method="POST" action="{{ route('admin.business.decline', $business) }}" class="kt-form">
                    @csrf

                    @method('PATCH')

                    <b-form-group id="input-group-22" label="Reason(s) for declining" label-for="comment">

                        <b-form-textarea class="w-100" id="comment" type="text" name="comment" value="{{ old('comment') }}" :state="{{ $errors->has('comment') ? 'false' : 'null' }}" rows="3" max-rows="6"></b-form-textarea>

                        @error('comment')
                        <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                        @enderror

                    </b-form-group>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>

                </form>
                <!--end::Form-->
            </div>

        </div>
    </div>
</div>


@endsection

@push('scripts')

@endpush
