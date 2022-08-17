<div class="kt-user-card-v4 kt-user-card-v4--skin-light kt-notification-item-padding-x">
    <div class="kt-user-card-v4__avatar">

        @if(auth()->user()->hasMedia(\App\Enums\MediaCollectionNames::PROFILE))
            <img alt="profile photo"
                 src="{{ asset(auth()->user()->getFirstMediaUrl(\App\Enums\MediaCollectionNames::PROFILE), 'thumbnail') }}"
                 class="kt-rounded"
            />

        @else
            <span
                class="kt-badge kt-badge--username kt-badge--lg kt-badge--brand kt-badge--bold">
                {{ auth()->user()->first_name[0] }}
            </span>
        @endif

    <!--use "kt-rounded" class for rounded avatar style-->

    </div>
    <div class="kt-user-card-v4__name">
        {{ $user->full_name }}
        <small>
            {{ $user->roles->pluck('name')->implode(' | ') }}
        </small>
    </div>
    <div class="kt-user-card-v4__badge kt-hidden">
        <span class="btn btn-label-primary btn-sm btn-bold btn-font-md">23 messages</span>
    </div>
</div>
<ul class="kt-nav kt-margin-b-10">
    <li class="kt-nav__item">
        <a href="{{ route('merchant.profile.show') }}" class="kt-nav__link">
            <span class="kt-nav__link-icon"><i class="flaticon2-user-1"></i></span>
            <span class="kt-nav__link-text">My Profile</span>
        </a>
    </li>
    <li class="kt-nav__item">
        <a href="{{ route('merchant.password.edit') }}" class="kt-nav__link">
            <span class="kt-nav__link-icon"><i class="flaticon2-protected"></i></span>
            <span class="kt-nav__link-text">Change Password</span>
        </a>
    </li>
    <li class="kt-nav__separator kt-nav__separator--fit"></li>
    <li class="kt-nav__custom kt-space-between">
        <a href="{{ route('logout') }}"
           class="btn btn-label-brand btn-upper btn-sm btn-bold"
           onclick="event.preventDefault();
           document.getElementById('logout-form').submit();"
        >
            {{ __('Logout') }}
        </a>

        <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    </li>
</ul>
