<div class="kt-grid__item kt-app__toggle kt-app__aside kt-app__aside--sm kt-app__aside--fit"
     id="kt_profile_aside">

    <!--Begin:: Portlet-->
    <div class="kt-portlet">
        <div class="kt-portlet__body">
            <div class="kt-widget kt-widget--general-1">
                <div class="kt-media kt-media--brand kt-media--md kt-media--circle">
                    @if($user->hasMedia(\App\Enums\MediaCollectionNames::PROFILE))
                        <img
                            src="{{ asset($user->getFirstMediaUrl(\App\Enums\MediaCollectionNames::PROFILE), 'thumbnail') }}"
                            alt="profile photo">
                    @else
                        <span
                            class="kt-badge kt-badge--username kt-badge--lg kt-badge--brand kt-badge--bold">
                        {{ $user->first_name[0] }} {{ $user->last_name[0] }}
                    </span>
                    @endif
                </div>
                <div class="kt-widget__wrapper">
                    <div class="kt-widget__label">
                        <p class="kt-widget__title">
                            {{ $user->full_name }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__separator"></div>

        <div class="kt-portlet__body">
            <ul class="kt-nav kt-nav--bolder kt-nav--fit-ver kt-nav--v4" role="tablist">
                <li class="kt-nav__item {{ request()->routeIs('merchant.password.edit') ? 'active' : '' }}">
                    <a class="kt-nav__link" href="{{ route('merchant.password.edit') }}" role="tab">
                        <span class="kt-nav__link-icon"><i class="flaticon2-shield"></i></span>
                        <span class="kt-nav__link-text">Change Password</span>
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <!--End:: Portlet-->
</div>
