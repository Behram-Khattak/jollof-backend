<!--begin: User Bar -->
<div class="kt-header__topbar-item kt-header__topbar-item--user">
    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">

        <!--use "kt-rounded" class for rounded avatar style-->
        <div class="kt-header__topbar-user kt-rounded-">
            <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
            <span class="kt-header__topbar-username kt-hidden-mobile">{{ $user->first_name }}</span>
            @if(auth()->user()->hasMedia(\App\Enums\MediaCollectionNames::PROFILE))
                <img alt="profile photo"
                     src="{{ asset(auth()->user()->getFirstMediaUrl(\App\Enums\MediaCollectionNames::PROFILE), 'thumbnail') }}"
                     class="kt-rounded-"/>

            @else
                <span
                    class="kt-badge kt-badge--username kt-badge--lg kt-badge--brand kt-badge--bold">
                        {{ auth()->user()->first_name[0] }} {{ auth()->user()->last_name[0] }}
                </span>
            @endif
        </div>
    </div>
    <div
        class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-sm">

        @include('merchant.partials._topbar.dropdown.user-light')

    </div>
</div>

<!--end: User Bar -->
