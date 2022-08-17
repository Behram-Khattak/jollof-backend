<div class="kt-user-card-v4 kt-user-card-v4--skin-light kt-notification-item-padding-x">
    <div class="kt-user-card-v4__avatar">

        <!--use "kt-rounded" class for rounded avatar style-->
        <img class="kt-rounded-" alt="Pic" src="{{ asset('images/users/300_25.jpg') }}" />

        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
    </div>
    <div class="kt-user-card-v4__name">
        Sean Stone
        <small>{{ucwords(auth()->user()->roles->pluck('name')[0])}}</small>
    </div>
    <div class="kt-user-card-v4__badge kt-hidden">
        <span class="btn btn-label-primary btn-sm btn-bold btn-font-md">23 messages</span>
    </div>
</div>
<ul class="kt-nav kt-margin-b-10">
    <li class="kt-nav__item">
        <a href="#" class="kt-nav__link">
            <span class="kt-nav__link-icon"><i class="flaticon2-schedule"></i></span>
            <span class="kt-nav__link-text">My Profile</span>
        </a>
    </li>
    <li class="kt-nav__item">
        <a href="#" class="kt-nav__link">
            <span class="kt-nav__link-icon"><i class="flaticon2-writing"></i></span>
            <span class="kt-nav__link-text">Tasks</span>
        </a>
    </li>
    <li class="kt-nav__item">
        <a href="#" class="kt-nav__link">
            <span class="kt-nav__link-icon"><i class="flaticon2-mail-1"></i></span>
            <span class="kt-nav__link-text">Messages</span>
        </a>
    </li>
    <li class="kt-nav__item">
        <a href="#" class="kt-nav__link">
            <span class="kt-nav__link-icon"><i class="flaticon2-drop"></i></span>
            <span class="kt-nav__link-text">Settings</span>
        </a>
    </li>
    <li class="kt-nav__separator kt-nav__separator--fit"></li>
    <li class="kt-nav__custom kt-space-between">

        <a href="{{ route('logout') }}" class="btn btn-label-brand btn-upper btn-sm btn-bold" onclick="event.preventDefault();
           document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    </li>
</ul>
