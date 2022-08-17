<div class="kt-portlet kt-widget kt-widget--fit kt-widget--general-3">
    <div class="kt-portlet__body">
        <div class="kt-widget__top">
            <div class="kt-media kt-media--xl kt-media--circle">
                @if($business->logo != '')
                    <img src="{{ asset($business->logo) }}" alt="business logo">
                @else
                    <span
                        class="kt-badge kt-badge--username kt-badge--lg kt-badge--brand kt-badge--bold">
                        {{ $business->name[0] }}
                    </span>
                @endif
            </div>

            <div class="kt-widget__wrapper">
                <div class="kt-widget__label">
                    <p class="kt-widget__title mb-1">
                        {{ $business->name }}
                    </p>
                    <span class="kt-widget__desc">
                        {{ $business->type->name }}
                    </span>
                </div>
                <div class="kt-widget__links">
                    <div class="kt-widget__cont">
                        <div class="kt-widget__link">
                            <i class="flaticon-multimedia"></i>
                            <p class="mb-1">{{ $business->email }}</p>
                        </div>
                        <div class="kt-widget__link">
                            <i class="fa fa-phone-alt"></i>
                            <p class="mb-1">{{ $business->telephone ?? 'Not Available' }}</p>
                        </div>
                        <div class="kt-widget__link">
                            <i class="flaticon-whatsapp kt-font-success"></i>
                            <p>{{ $business->whatsapp ?? 'Not Available' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__foot kt-portlet__foot--fit">
        <div class="kt-widget__nav ">
            <ul class="nav nav-tabs nav-tabs-space-xl nav-tabs-line nav-tabs-clear nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand kt-portlet__space-x"
                role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('merchant.business.show') ? 'active' : '' }}"
                       href="{{ route('merchant.business.show', $business) }}">
                        <i class="flaticon2-calendar-3"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('merchant.business.kyc.create') ? 'active' : '' }}"
                       href="{{ route('merchant.business.kyc.create', $business) }}">
                        <i class="flaticon2-protected"></i>
                        KYC
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('merchant.business.location.index') ? 'active' : '' }}"
                       href="{{ route('merchant.business.location.index', $business) }}">
                        <i class="flaticon2-location"></i>
                        Locations
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('merchant/business/*/teams*') ? 'active' : '' }}"
                       href="{{ route('merchant.teams.index', $business) }}">
                        <i class="flaticon2-group"></i>
                        Teams
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="#"
                       data-toggle="modal"
                       data-target="#businessLogo"
                    >
                        <i class="flaticon2-photo-camera"></i>
                        Upload Business Logo
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="#"
                       data-toggle="modal"
                       data-target="#businessBanner"
                    >
                        <i class="flaticon-upload-1"></i>
                        Upload Business Banner
                    </a>
                </li>
                <li class="nav-item">
                    @if ($onboard->profile && $onboard->kyc && $onboard->locations && $onboard->teams && $onboard->logo && $onboard->banner)
                        <form style="display: inline-block;"
                              action="{{ route('merchant.business.approval', $business)}}"
                              method="post">
                            @csrf

                            <b-button type="submit" class="btn btn-brand">
                                Finish
                            </b-button>

                        </form>
                    @else
                        <b-button type="submit" class="btn btn-brand disabled">
                            Finish
                        </b-button>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
