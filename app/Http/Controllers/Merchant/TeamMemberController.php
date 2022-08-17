<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Requests\StoreTeamMemberRequest;
use App\Http\Requests\UpdateTeamMemberRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class TeamMemberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Team                   $team
     * @param StoreTeamMemberRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Team $team, StoreTeamMemberRequest $request)
    {
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'username'   => $request->input('username'),
            'email'      => $request->input('email'),
            'telephone'  => phone($request->input('telephone'), 'NG')->formatE164(),
            'password'   => Hash::make($request->input('password')),
        ]);

        $user->assignRole($request->input('role'));

        $user->teams()->attach($team->id);

        return redirect()->back()->with([
            'message'    => 'User added to team successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the members of the given team.
     *
     * @param Team $team
     * @param      $username
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Team $team, $username)
    {
        $user = User::withTrashed()->where('username', $username)->first();

        return view('merchant.team.members.show', [
            'team' => $team,
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Team                    $team
     * @param User                    $user
     * @param UpdateTeamMemberRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Team $team, User $user, UpdateTeamMemberRequest $request)
    {
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'username'   => $request->input('username'),
            'email'      => $request->input('email'),
            'telephone'  => phone($request->input('telephone'), 'NG')->formatE164(),
        ]);

        return redirect()->route('merchant.teams_members.show', [$team, $user])->with([
            'message'    => 'User updated successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team $team
     * @param User $user
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Team $team, User $user)
    {
        $user->delete();

//        $user->detachTeam($team);

        return redirect()->back()->with([
            'message'    => 'User deleted successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Team $team
     * @param      $username
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function restore(Team $team, $username)
    {
        $user = User::withTrashed()->where('username', $username)->firstOrFail();

        $user->restore();

//        $user->teams()->attach($team->id);

        return redirect()->back()->with([
            'message'    => 'User restored successfully!',
            'alert-type' => 'success',
        ]);
    }
}
