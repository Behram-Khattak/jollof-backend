<?php

namespace App\Http\View\Composers;

use App\Models\SettingType;
use Illuminate\View\View;

class HeaderMenuComposer
{
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('settingTypes', SettingType::all());
    }
}
