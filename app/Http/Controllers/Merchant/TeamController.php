<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\RoleTypes;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mpociot\Teamwork\Exceptions\UserNotInTeamException;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Business $business
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Business $business)
    {
        $teams = Team::with('location')->whereHas('location', function (Builder $query) use ($business) {
            $query->where('business_id', $business->id);
        })->paginate();

        $locations = BusinessLocation::whereBusinessId($business->id)->whereDoesntHave('team')->get();

        return view('merchant.team.index', [
            'teams'     => $teams,
            'business'  => $business,
            'locations' => $locations,
        ]);
    }

    /**
     * @param Business $business
     * @param Team     $team
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Business $business, Team $team)
    {
        $team->load(['location', 'users' => function ($query) {
            $query->withTrashed();
        }]);

        return view('merchant.team.show', [
            'team'     => $team,
            'business' => $business,
            'roles'    => Role::where('type', RoleTypes::TEAM)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Business                 $business
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request, Business $business)
    {
        $request->validate([
            'name'     => ['required', 'string'],
            'location' => ['required', 'string'],
        ]);

        $owner = $business->owner_id ? $business->owner_id : $business->manager_id;

        $team = Team::create([
            'name'        => $request->input('name'),
            'owner_id'    => $owner,
            'location_id' => $request->input('location'),
        ]);

        User::find($owner)->attachTeam($team);

        return redirect()->back()->with([
            'message'    => 'Team created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Business                 $business
     * @param Team                     $team
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Business $business, Team $team, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);

        $team->update(['name' => $request->input('name')]);

        return redirect()->back()->with([
            'message'    => 'Team updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Switch to the given team.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function switchTeam($id)
    {
        $teamModel = config('teamwork.team_model');
        $team = $teamModel::findOrFail($id);
        try {
            auth()->user()->switchTeam($team);
        } catch (UserNotInTeamException $e) {
            abort(403);
        }

        return redirect(route('teams.index'));
    }

    /**
     * Remove the specified resource from storage.
     *d.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teamModel = config('teamwork.team_model');

        $team = $teamModel::findOrFail($id);
        if (!auth()->user()->isOwnerOfTeam($team)) {
            abort(403);
        }

        $team->delete();

        $userModel = config('teamwork.user_model');
        $userModel::where('current_team_id', $id)
            ->update(['current_team_id' => null]);

        return redirect(route('teams.index'));
    }
}
