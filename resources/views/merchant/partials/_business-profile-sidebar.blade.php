<div class="kt-portlet">
    <div class="kt-portlet__body">
        <div class="kt-widget kt-widget--general-1">
            <div class="kt-media kt-media--brand kt-media--md kt-media--circle">
                <img src="{{ asset($business->getFirstMediaUrl('logo')) }}" alt="profile picture">
            </div>
            <div class="kt-widget__wrapper">
                <div class="kt-widget__label">
                    <a href="#" class="kt-widget__title">
                        {{ $business->name }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__separator"></div>

    <div class="kt-portlet__body">
        <ul class="kt-nav kt-nav--bolder kt-nav--fit-ver kt-nav--v4" role="tablist">
            <li class="kt-nav__item  active ">
                <a class="kt-nav__link active" href="{{ route('merchant.business.show', $business) }}" role="tab">
                    <span class="kt-nav__link-icon"><i class="flaticon2-user"></i></span>
                    <span class="kt-nav__link-text">Business Profile</span>
                </a>
            </li>
            <li class="kt-nav__item">
                <a class="kt-nav__link" href="{{ route('merchant.business.location.index', $business) }}" role="tab">
                    <span class="kt-nav__link-icon"><i class="flaticon2-pin"></i></span>
                    <span class="kt-nav__link-text">Business Locations</span>
                </a>
            </li>
            <li class="kt-nav__item  ">
                <a class="kt-nav__link" href="{{ route('merchant.business.kyc.create', $business) }}" role="tab">
                    <span class="kt-nav__link-icon"><i class="flaticon2-arrow-up"></i></span>
                    <span class="kt-nav__link-text">KYC</span>
                </a>
            </li>
        </ul>
    </div>

</div>
