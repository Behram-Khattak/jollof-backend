<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsRequest;
use App\Models\Settings;
use App\Models\SettingType;

class SettingsController extends Controller
{
    /**
     * Display all application settings by its setting type.
     *
     * @param SettingType $settingType
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(SettingType $settingType)
    {
        $this->authorize('view', Settings::class);

        $settings = Settings::whereSettingTypeId($settingType->id)->get();

        return view('admin.settings.index', compact('settings', 'settingType'));
    }

    /**
     * Store a newly created Settings in storage.
     *
     * @param SettingType          $settingType
     * @param StoreSettingsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SettingType $settingType, StoreSettingsRequest $request)
    {
        Settings::create([
            'setting_type_id' => $request->input('setting_type_id'),
            'name'            => $request->input('name'),
            'value'           => $request->input('value'),
        ]);

        return redirect()->route('admin.settings.index', $settingType)->with([
            'message'    => 'Setting created successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SettingType $settingType
     * @param Settings    $settings
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(SettingType $settingType, Settings $settings)
    {
        $this->authorize('update', $settings);

        return view('admin.settings.edit', compact('settingType', 'settings'));
    }

    public function update(SettingType $settingType, Settings $settings, StoreSettingsRequest $request)
    {
    }
}
