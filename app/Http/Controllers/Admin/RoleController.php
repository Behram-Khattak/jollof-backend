<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DefaultRoles;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Get all roles except super-admin and authenticated user's roles.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view', Role::class);

        $roles = Role::withTrashed()
            ->where('name', '!=', DefaultRoles::SUPER_ADMIN)
            ->where('name', '!=', DefaultRoles::USER)
            ->where('name', '!=', DefaultRoles::MERCHANT)
            ->whereNotIn('name', auth()->user()->getRoleNames())
            ->get();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        $permissions = Permission::get();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoleRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create([
            'name'        => $request->input('role_name'),
            'description' => $request->input('role_description'),
        ]);

        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('admin.roles.index')->with([
            'message'    => 'Role created successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     */
    public function show(Role $role)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        $permissions = Permission::get();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRoleRequest $request
     * @param Role             $role
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreRoleRequest $request, Role $role)
    {
        if ($role->can_be_renamed) {
            $role->name = $request->input('role_name');
        }
        $role->description = $request->input('role_description');
        $role->save();

        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('admin.roles.edit', $role)->with([
            'message'    => 'Role updated successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     *
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        $role->syncPermissions([]);
        $role->delete();

        return back()->with([
            'message'    => 'Role deleted successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Role $role
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function restore(Role $role)
    {
        $this->authorize('delete', $role);

        $role->restore();

        return back()->with([
            'message'    => 'Role restored successfully!',
            'alert-type' => 'success',
        ]);
    }
}
