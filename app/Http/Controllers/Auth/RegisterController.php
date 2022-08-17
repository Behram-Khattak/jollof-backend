<?php

namespace App\Http\Controllers\Auth;

use App\Enums\DefaultRoles;
use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\BusinessType;
use App\Models\Refer;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::INDEX;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @param mixed $name
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showRegistrationForm($name, $referal = null)
    {
        $role = Role::whereName($name)->first();

        if (!$role || ($role->name != DefaultRoles::USER && $role->name != DefaultRoles::MERCHANT)) {
            return redirect(route('index'))->with('message', [
                'type' => 'danger',
                'body' => 'Route not found!',
            ]);
        }
        $states = json_decode(file_get_contents((base_path('nigeria-state-and-lgas.json'))), true);

        $businessTypes = BusinessType::all(['id', 'name'])->sortBy('name');

        $refer = ($referal) ? $referal : "";

        return view('auth.register', compact('businessTypes', 'states', 'role', 'refer'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     *
     * @throws \Throwable
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function register(RegisterRequest $request)
    {
        \DB::beginTransaction();
        try {
            $user = $this->createUser($request->validated(), $request);
            \Log::error($user);

            if ($request->input('role') === DefaultRoles::MERCHANT) {
                $business = $this->createBusiness($user, $request->validated(), $request);
                \Log::error($business);
            }

            \DB::commit();

            event(new Registered($user));

            //TODO::process referal
            if ($request->input('referal') != '0') {
                $this->updateReferal($request->input('referal'));
            }

            return redirect()->back()->with('message', [
                'type' => 'success',
                'body' => 'Registration successful! A verification link has been sent to your email.',
            ]);
        } catch (\Exception $exception) {
            \DB::rollBack();

            \Log::error($exception);

            return redirect()->back()->withInput()->with('message', [
                'type' => 'danger',
                'body' => $exception->getMessage(),
                // 'body' => 'Something went wrong. Please try again!',
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array           $data
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|User
     */
    protected function createUser(array $data, RegisterRequest $request)
    {
        if ($request->filled('telephone')) {
            $telephone = phone($data['telephone'], 'NG')->formatE164();
        }

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'username'   => $data['username'],
            'email'      => $data['email'],
            'telephone'  => $telephone ?? null,
            'password'   => Hash::make($data['password']),
        ]);

        if ($request->filled('user_role')) {
            $role = Role::whereName($data['user_role'])->where('type', RoleTypes::TEAM)->first();
        } else {
            $role = Role::whereName($data['role'])->where('type', RoleTypes::DEFAULT)->first();
        }

        $user->assignRole($role);

        return $user;
    }

    protected function createBusiness(User $user, array $data, RegisterRequest $request)
    {
        if ($request->filled('business_phone')) {
            $businessPhone = phone($data['business_phone'], 'NG')->formatE164();
        }

        if ($request->filled('whatsapp')) {
            $whatsApp = phone($data['whatsapp'], 'NG')->formatE164();
        }

        $business = Business::create([
            'owner_id'         => $request->input('business_owner') == 'yes' ? $user->id : null,
            'manager_id'       => $request->input('business_owner') == 'no' ? $user->id : null,
            'business_type_id' => $data['business_type'],
            'name'             => $data['business_name'],
            'email'            => $data['business_email'],
            'telephone'        => $businessPhone ?? $data['business_phone'],
            'whatsapp'         => $whatsApp ?? $data['whatsapp'],
            'description'      => $data['business_description'],
        ]);

        $location = BusinessLocation::create([
            'business_id' => $business->id,
            'state'       => $data['state'],
            'city'        => $data['city'],
            'area'        => $data['area'] ?? null,
            'address'     => $data['address'],
            'default'     => true,
        ]);

        if (checkMicrosite($data['business_type'],  'Cuisine')) {
            Restaurant::create([
                'business_id' => $business->id,
                'business_location_id' => $location->id,
            ]);
        }
    }


    protected function updateReferal($referalCode)
    {
        //check if referal code exits
        $hasReferer = Refer::where('code', $referalCode)->first();
        //check if referal already clicked
        if (!$hasReferer->signed_up_at) {
            //updated referal signed_up_date
            Refer::where('code', $referalCode)->update([
                'signed_up_at' => now()
            ]);
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     *
     * @throws \Throwable
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function registerback(RegisterRequest $request)
    {
        \DB::beginTransaction();
        try {
            $user = $this->createUser($request->validated(), $request);
            \Log::error($user);

            if ($request->input('role') === DefaultRoles::MERCHANT) {
                $business = $this->createBusiness($user, $request->validated(), $request);
                \Log::error($business);
            }

            \DB::commit();



            return redirect()->back()->with('message', [
                'type' => 'success',
                'body' => 'Registration successful!. Login with your email/username and password',
            ]);
        } catch (\Exception $exception) {
            \DB::rollBack();

            \Log::error($exception);

            return redirect()->back()->withInput()->with('message', [
                'type' => 'danger',
                'body' => $exception->getMessage(),
                // 'body' => 'Something went wrong. Please try again!',
            ]);
        }
    }
}
