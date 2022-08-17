@can('read-order')
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu"
         class="kt-aside-menu"
         data-ktmenu-vertical="1"
         data-ktmenu-scroll="1"
         data-ktmenu-dropdown-timeout="500"
    >
        <ul class="kt-menu__nav ">

            <li class="kt-menu__item kt-menu__item--submenu {{ (request()->is('dispatch/orders*')) ? 'kt-menu__item--open kt-menu__item--here' : '' }}"
                aria-haspopup="true"
                data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;"
                   class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-tag"></i>
                    <span class="kt-menu__link-text">Orders</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item {{ request()->routeIs('dispatch.orders.index') ? 'kt-menu__item--active' : '' }}"
                            aria-haspopup="true">
                            <a href="{{ route('dispatch.orders.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">Orders</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
@endcan
