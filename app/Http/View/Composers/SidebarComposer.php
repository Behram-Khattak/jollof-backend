<?php

namespace App\Http\View\Composers;

use App\Enums\DefaultRoles;
use App\Models\BusinessType;
use App\Models\Role;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('roles', Role::where('name', '!=', DefaultRoles::SUPER_ADMIN)
            ->orderBy('name')
            ->get());

        $view->with('businessTypes', BusinessType::orderBy('name')->get());
    }
}
