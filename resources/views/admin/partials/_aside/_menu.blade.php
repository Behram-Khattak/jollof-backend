<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu" data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">
            @can('view-dashboard')
            <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{ route('admin.index') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-gear"></i>
                    <span class="kt-menu__link-text">Dashboard</span>
                </a>
            </li>
            @endcan
            @can('read-roles')
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-graphic"></i>
                    <span class="kt-menu__link-text">Role Management</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item" aria-haspopup="true">
                            <a href="{{ route('admin.roles.index') }}" class="kt-menu__link">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">All Roles</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('read-users')
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-graphic"></i>
                    <span class="kt-menu__link-text">User Management</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item" aria-haspopup="true">
                            <a href="{{ route('admin.users.index') }}" class="kt-menu__link">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">All Users</span>
                            </a>
                        </li>
                        @foreach($roles as $role)
                        <li class="kt-menu__item" aria-haspopup="true">
                            <a href="{{ route('admin.users.index', ['role' => $role->name]) }}" class="kt-menu__link">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">{{ \Illuminate\Support\Str::plural(ucfirst($role->name)) }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            @endcan
            @can('read-business')
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-graphic"></i>
                    <span class="kt-menu__link-text">Business Management</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item" aria-haspopup="true">
                            <a href="{{ route('admin.business.index') }}" class="kt-menu__link">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">All Businesses</span>
                            </a>
                        </li>
                        @foreach($businessTypes as $type)
                        <li class="kt-menu__item" aria-haspopup="true">
                            <a href="#" class="kt-menu__link">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">{{ ucfirst($type->name) }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            @endcan
            @can('read-banners')
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-graphic"></i>
                    <span class="kt-menu__link-text">Banners</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                            <span class="kt-menu__link">
                                <span class="kt-menu__link-text">Dashboards</span>
                            </span>
                        </li>
                        <li class="kt-menu__item" aria-haspopup="true">
                            <a href="/admin/slider" class="kt-menu__link">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">Slider</span>
                            </a>
                        </li>
                        <li class="kt-menu__item" aria-haspopup="true">
                            <a href="/admin/advert" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">Advert</span>
                            </a>
                        </li>
                        <li class="kt-menu__item" aria-haspopup="true">
                            <a href="/admin/popup" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">Pop Up</span>
                            </a>
                        </li>
                        <li class="kt-menu__item" aria-haspopup="true">
                            <a href="/admin/home-images" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">Home Images</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('read-notification')
            <li class="kt-menu__item" aria-haspopup="true">
                <a href="/admin/notification" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-gear"></i>
                    <span class="kt-menu__link-text">Notification</span>
                </a>
            </li>
            @endcan
            @can('read-coupon')
            <li class="kt-menu__item" aria-haspopup="true">
                <a href="/admin/coupon" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-gear"></i>
                    <span class="kt-menu__link-text">Coupon</span>
                </a>
            </li>
            @endcan
            @can('read-promo')
            <li class="kt-menu__item" aria-haspopup="true">
                <a href="/admin/promo" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-gear"></i>
                    <span class="kt-menu__link-text">Promos</span>
                </a>
            </li>
            @endcan
            @can('read-voucher')
            <li class="kt-menu__item" aria-haspopup="true">
                <a href="/admin/voucher" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-gear"></i>
                    <span class="kt-menu__link-text">Voucher</span>
                </a>
            </li>
            @endcan
            @can('handle-extras')
            <li class="kt-menu__item" aria-haspopup="true">
                <a href="/admin/extra" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-gear"></i>
                    <span class="kt-menu__link-text">Extras</span>
                </a>
            </li>
            @endcan
            @can('read-order')
            <li class="kt-menu__item" aria-haspopup="true">
                <a href="/admin/orders" class="kt-menu__link ">
                    <i class="kt-menu__link-icon fas fa-cart-arrow-down"></i>
                    <span class="kt-menu__link-text">Orders</span>
                </a>
            </li>
            @endcan
            @can('read-review')
            <li class="kt-menu__item" aria-haspopup="true">
                <a href="/admin/reviews" class="kt-menu__link ">
                    <i class="kt-menu__link-icon fas fa-cart-arrow-down"></i>
                    <span class="kt-menu__link-text">Reviews</span>
                </a>
            </li>
            @endcan
            @can('view-shipping-group')
            <li class="kt-menu__item {{ request()->routeIs('admin.shipping') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true">
                <a href="{{ route('admin.shipping') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon fas fa-shipping-fast"></i>
                    <span class="kt-menu__link-text">Shipping</span>
                </a>
            </li>
            @endcan
            @can('read-area')
            <li class="kt-menu__item {{ request()->routeIs('admin.locations') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true">
                <a href="{{ route('admin.locations') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon fas fa-location-arrow"></i>
                    <span class="kt-menu__link-text">Locations</span>
                </a>
            </li>
            @endcan
            @can('read-referrals')
            <li class="kt-menu__item {{ request()->routeIs('admin.refral') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true">
                <a href="{{ route('admin.referal') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon fas fa-location-arrow"></i>
                    <span class="kt-menu__link-text">Referrals</span>
                </a>
            </li>
            @endcan
            @can('handle-reports')
            <li class="kt-menu__item {{ request()->routeIs('admin.report') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true">
                <a href="{{ route('admin.report') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-graphic"></i>
                    <span class="kt-menu__link-text">Report</span>
                </a>
            </li>
            @endcan
            @can('read-billing')
            <li class="kt-menu__item {{ request()->routeIs('admin.billing') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true">
                <a href="{{ route('admin.billing') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-graphic"></i>
                    <span class="kt-menu__link-text">Billing</span>
                </a>
            </li>
            @endcan
            @can('read-error-logs')
            <li class="kt-menu__item {{ request()->routeIs('admin.billing') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true">
                <a href="{{ route('admin.error.logs') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-graphic"></i>
                    <span class="kt-menu__link-text">Error logs</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</div>

<!-- end:: Aside Menu -->
