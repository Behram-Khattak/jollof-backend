<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DefaultRoles;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Mail\WelcomeBack;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\BusinessType;
use App\Models\JollofUser;
use App\Models\Orders;
use App\Models\Refer;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use App\Notifications\AccountSetupNotification;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Get all users by their role.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('view', User::class);

        if ($request->query('role')) {
            $role = Role::whereName($request->query('role'))->first();

            if (!$role) {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Role not found.']);
            }

            $users = User::withTrashed()
                ->role($role->name)
                ->where('id', '!=', auth()->id())
                ->latest()
                ->get();
        } else {
            $users = User::withTrashed()
                ->where('id', '!=', auth()->id())
                ->with('roles')
                ->latest()
                ->get();
        }

        $roles = Role::where('name', '!=', DefaultRoles::SUPER_ADMIN)->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show a specific user.
     *
     * @param User $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        $roles = Role::where('name', '!=', DefaultRoles::SUPER_ADMIN)
            ->where('name', '!=', DefaultRoles::MERCHANT)
            ->get();

        return view('admin.users.show', [
            'user' => $user->load('business.type'),
            'role' => $user->getRoleNames()[0],
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param null|mixed $role
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create($role = null)
    {
        $this->authorize('create', User::class);

        $roles = null;

        $states = json_decode(file_get_contents((base_path('nigeria-state-and-lgas.json'))), true);

        $businessTypes = BusinessType::all(['id', 'name'])->sortBy('name');

        if (isset($role)) {
            $role = Role::whereName($role)->first();

            if (!$role) {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Role not found.']);
            }
        } else {
            $roles = Role::where('name', '!=', DefaultRoles::MERCHANT)
                // ->where('name', '!=', DefaultRoles::MERCHANT)
                ->get();
        }

        return view('admin.users.create', compact('states', 'businessTypes', 'roles', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateUserRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function store(CreateUserRequest $request)
    {
        $this->authorize('create', User::class);

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'username'   => $request->input('username'),
            'email'      => $request->input('email'),
            'telephone'  => $request->input('telephone'),
        ]);

        if ($request->filled('role')) {
            if ($request->input('role') === DefaultRoles::MERCHANT) {
                $business = Business::create([
                    'owner_id'         => $user->id,
                    'business_type_id' => $request->input('business_type'),
                    'name'             => $request->input('business_name'),
                    'email'            => $request->input('business_email'),
                    'telephone'        => phone($request->input('business_phone'), 'NG')->formatE164(),
                    'whatsapp'         => phone($request->input('whatsapp'), 'NG')->formatE164(),
                    'description'      => $request->input('business_description'),
                ]);

                BusinessLocation::create([
                    'business_id' => $business->id,
                    'state'       => $request->input('state'),
                    'city'        => $request->input('city'),
                    'area'        => $request->input('area'),
                    'address'     => $request->input('address'),
                ]);
            }

            $user->assignRole($request->input('role'));
        }

        if ($request->filled('roles')) {
            $user->assignRole($request->input('roles'));
        }

        $user->notify(new AccountSetupNotification());

        return redirect()->route('admin.users.index')->with([
            'alert-type' => 'success',
            'message'    => 'User created successfully! An account setup link has been sent to the user.',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User    $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'username'   => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
            'role'       => ['required', 'string', 'max:100'],
            'email'      => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'telephone'  => ['nullable', 'string', new PhoneNumber(), Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'username'   => $request->input('username'),
            'email'      => $request->input('email'),
            'telephone'  => phone($request->input('telephone'), 'NG')->formatE164(),
        ]);

        if ($request->filled('role')) {
            $user->removeRole($user->getRoleNames()[0]);
            $user->assignRole($request->input('role'));
        }

        return redirect()->route('admin.users.show', $user)->with([
            'message'    => 'User updated successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return back()->with([
            'message'    => 'User deleted successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param User $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function restore(User $user)
    {
        $this->authorize('delete', $user);

        $user->restore();

        return back()->with([
            'message'    => 'User restored successfully!',
            'alert-type' => 'success',
        ]);
    }


    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function move_users()
    {

        $jollof = JollofUser::where('status', 0)->get();
        foreach ($jollof as $u) {
            $user = User::create([
                'first_name' => $u->first_name,
                'last_name'  => $u->last_name,
                'username'   => $u->email,
                'email'      => $u->email,
                'telephone'  => $u->telephone,
            ]);

            //update JollofUser Table
            JollofUser::where('id', $u->id)->update(['status' => 1]);

            //Send Email
            Mail::to($u->email)->send(new WelcomeBack($u));

            dd('Process ran successfully.');
        }
    }

    public function orders(User $user)
    {
        $orders = Orders::where('status', '!=', 'cancelled')
        ->where('user_id', '=', $user->id)
        ->paginate();
        // dd($orders);
        // return $orders;
        return view('admin.users.includes.orders', compact('orders','user'));
    }

    public function referrals(User $user)
    {
        // Get user id referrals
        $referrals = Refer::with('user')->where('user_id', '=', $user->id)->paginate();
        return view('admin.users.includes.referrals', compact('referrals','user'));

    }

    public function reviews(User $user)
    {
        $reviews = Review::with('user')->where('user_id', '=', $user->id)->paginate();

        return view('admin.users.includes.reviews', compact('reviews','user'));
    }

    public function rewards(User $user)
    {
        return view('admin.users.includes.rewards', compact('user'));
    }

    public function promos(User $user)
    {
        return $user;
    }
}
