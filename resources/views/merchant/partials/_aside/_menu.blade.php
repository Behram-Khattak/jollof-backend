<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu"
         class="kt-aside-menu"
         data-ktmenu-vertical="1"
         data-ktmenu-scroll="1"
         data-ktmenu-dropdown-timeout="500"
    >
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item {{ request()->routeIs('merchant.index') ? 'kt-menu__item--active' : '' }}"
                aria-haspopup="true">
                <a href="{{ route('merchant.index') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-architecture-and-city"></i>
                    <span class="kt-menu__link-text">Dashboard</span>
                </a>
            </li>
            <li class="kt-menu__item kt-menu__item--submenu"
                aria-haspopup="true"
                data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;"
                   class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-list-1"></i>
                    <span class="kt-menu__link-text">Businesses</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        @foreach ($businesses as $business)
                            <li class="kt-menu__item"
                                aria-haspopup="true">
                                <a href="{{ route('merchant.business.show', $business) }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">{{ Str::limit($business->name, 20) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            @if (request()->route('business'))
                <li class="kt-menu__item kt-menu__item--submenu {{ request()->is('merchant/business*') ? 'kt-menu__item--open kt-menu__item--here' : '' }}"
                    aria-haspopup="true"
                    data-ktmenu-submenu-toggle="hover"
                >
                    <a href="javascript:;"
                       class="kt-menu__link kt-menu__toggle">
                        <i class="kt-menu__link-icon flaticon2-indent-dots"></i>
                        <span class="kt-menu__link-text">Business Profile</span>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="kt-menu__submenu">
                        <span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item {{ request()->routeIs('merchant.business.show') ? 'kt-menu__item--active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('merchant.business.show', request()->route('business')) }}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">Profile</span>
                                </a>
                            </li>
                            <li class="kt-menu__item {{ request()->routeIs('merchant.business.kyc.create') ? 'kt-menu__item--active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('merchant.business.kyc.create', request()->route('business')) }}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">KYC</span>
                                </a>
                            </li>
                            <li class="kt-menu__item {{ request()->routeIs('merchant.business.location.index') ? 'kt-menu__item--active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('merchant.business.location.index', request()->route('business')) }}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">Locations</span>
                                </a>
                            </li>
                            <li class="kt-menu__item {{ request()->is('merchant/business/*/teams*') ? 'kt-menu__item--active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('merchant.teams.index', request()->route('business')) }}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">Teams</span>
                                </a>
                            </li>
                            <li class="kt-menu__item {{ request()->is('merchant/business/*/reviews*') ? 'kt-menu__item--active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('merchant.review', request()->route('business')) }}"
                                   class="kt-menu__link">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">Reviews</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if (request()->route('business'))

                @if (request()->route('business')->type->name == \App\Enums\BusinessTypeEnum::FASHION)
                    <li class="kt-menu__item kt-menu__item--submenu {{ request()->is('merchant/*/fashion*') ? 'kt-menu__item--open kt-menu__item--here' : '' }}"
                        aria-haspopup="true"
                        data-ktmenu-submenu-toggle="hover">
                        <a href="javascript:;"
                           class="kt-menu__link kt-menu__toggle">
                            <i class="kt-menu__link-icon flaticon2-tag"></i>
                            <span class="kt-menu__link-text">Fashion</span>
                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="kt-menu__submenu">
                            <span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item {{ request()->routeIs('merchant.fashion.index') ? 'kt-menu__item--active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('merchant.fashion.index', request()->route('business')) }}"
                                       class="kt-menu__link ">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="kt-menu__link-text">All Products</span>
                                    </a>
                                </li>
                                <li class="kt-menu__item {{ request()->routeIs('merchant.fashion.create') ? 'kt-menu__item--active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('merchant.fashion.create', request()->route('business')) }}"
                                       class="kt-menu__link ">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="kt-menu__link-text">Create Product</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (request()->route('business')->type->name == \App\Enums\BusinessTypeEnum::CUISINE)
                    <li class="kt-menu__item kt-menu__item--submenu {{ request()->routeIs('merchant.restaurant*') ? 'kt-menu__item--open kt-menu__item--here' : '' }}"
                        aria-haspopup="true"
                        data-ktmenu-submenu-toggle="hover">
                        <a href="javascript:;"
                           class="kt-menu__link kt-menu__toggle">
                            <i class="kt-menu__link-icon fas fa-hamburger"></i>
                            <span class="kt-menu__link-text">Restaurant Menu</span>
                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="kt-menu__submenu">
                            <span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item {{ request()->routeIs('merchant.restaurants') ? 'kt-menu__item--active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('merchant.restaurants', request()->route('business')) }}" class="kt-menu__link ">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="kt-menu__link-text">My Restaurants</span>
                                    </a>
                                </li>
                                <li class="kt-menu__item {{ request()->routeIs('merchant.restaurant.menu') ? 'kt-menu__item--active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('merchant.restaurant.menu', request()->route('business')) }}" class="kt-menu__link ">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="kt-menu__link-text">Menu</span>
                                    </a>
                                </li>
                                <li class="kt-menu__item {{ request()->routeIs('merchant.restaurant.create.menu') ? 'kt-menu__item--active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('merchant.restaurant.create.menu', request()->route('business')) }}" class="kt-menu__link ">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="kt-menu__link-text">Create Menu</span>
                                    </a>
                                </li>
                                <li class="kt-menu__item {{ request()->routeIs('merchant.restaurant.category') ? 'kt-menu__item--active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('merchant.restaurant.category', request()->route('business')) }}" class="kt-menu__link ">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="kt-menu__link-text">Menu Category</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

            @endif

            <li class="kt-menu__item {{ request()->routeIs('orders') ? 'kt-menu__item--active' : '' }}"
                aria-haspopup="true">
                <a href="{{ route('merchant.restaurant.orders') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon fas fa-cart-arrow-down"></i>
                    <span class="kt-menu__link-text">Orders</span>
                </a>
            </li>

            <li class="kt-menu__item {{ request()->routeIs('merchant.report') ? 'kt-menu__item--active' : '' }}"
                aria-haspopup="true">
                <a href="{{ route('merchant.report') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-graphic"></i>
                    <span class="kt-menu__link-text">Report</span>
                </a>
            </li>

            <li class="kt-menu__item kt-menu__item--submenu {{ request()->is('merchant/settings*') ? 'kt-menu__item--open kt-menu__item--here' : '' }}"
                aria-haspopup="true"
                data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;"
                   class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-gear"></i>
                    <span class="kt-menu__link-text">Settings</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item {{ request()->routeIs('merchant.password.edit') ? 'kt-menu__item--active' : '' }}"
                            aria-haspopup="true"
                        >
                            <a href="{{ route('merchant.password.edit') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">Change Password</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>

<!-- end:: Aside Menu -->
