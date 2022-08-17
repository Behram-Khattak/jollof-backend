<?php

namespace App\Providers;

use App\Http\View\Composers\HeaderMenuComposer;
use App\Http\View\Composers\SidebarComposer;
use App\Models\Business;
use App\Models\Category;
use App\Models\OnboardingFlow;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('admin.partials._header-menu', HeaderMenuComposer::class);
        View::composer('admin.partials._aside._menu', SidebarComposer::class);
        View::composer('merchant.partials._header.topbar._user', function ($view) {
            $view->with('user', auth()->user()->load('roles'));
        });
        View::composer('merchant.partials._aside._menu', function ($view) {
            $view->with('businesses', Business::whereOwnerId(auth()->id())->get());
        });
        View::composer('merchant.partials.business._profile-header', function ($view) {
            $view->with('onboard', OnboardingFlow::whereBusinessId(request()->route('business')->id)->first());
        });
    }
}
