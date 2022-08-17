<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Areas;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LocationController extends Controller
{
    /**
     * Show all location created in the database
     * Return view.
     */
    public function index()
    {
        $locations = States::with('areas')->get();

        return view('admin.locations.index', compact(['locations']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        //add data to database
        $consumable = States::create($data);

        //rediret to details page
        return redirect('/admin/locations')->with([
            'message'    => 'State created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        $data = $this->validateData($request);

        $id = $data['stateid'];
        unset($data['stateid']);

        $state = States::findorfail($id);

        //add data to database
        States::whereId($id)->update($data);

        //rediret to details page
        return redirect(route('admin.locations'))->with([
            'message'    => 'State updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show all location created in the database
     * Return view.
     *
     * @param mixed $id
     */
    public function show($id)
    {
        $location = States::findorfail($id);
        $location->load('areas');
        return view('admin.locations.show', compact(['location']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $id
     *
     * @return Response
     */
    public function store_area(Request $request, $id)
    {
        $data = $this->validateAreaData($request);

        //add data to database
        $consumable = Areas::create($data);

        //rediret to details page
        return redirect(route('admin.location.show', ['id'=>$id]))->with([
            'message'    => 'Area created successfully',
            'alert-type' => 'success',
        ]);
    }


    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     *
     * @param Type  $var Description
     * @param mixed $id
     *
     * @throws conditon
     *
     * @return type
     */
    public function delete_area(Request $request)
    {
        $area = Areas::findorfail($request->input('id'));

        $stateId = $area->states_id;
        if ($area == null) {
            //redirect with message
            redirect(route('admin.location.show', ['id'=>$stateId]))->with([
                'message'    => 'There was a problem deleting the area!',
                'alert-type' => 'error',
            ]);
        }

        $area->delete();

        return redirect(route('admin.location.show', ['id'=>$stateId]))->with([
            'message'    => 'Area deleted successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Get all states and areas in JSON format.
     */
    public function json()
    {
        $all = States::all();
        if (!$all->isEmpty()) {
            return false;
        }

        $data = json_decode(Storage::get('states.json'), true);
        foreach ($data as $d) {
            $dbData = [
                'state'  => $d['state'],
                'status' => ($d['state'] == 'Lagos') ? 'active' : 'inactive',
            ];

            $state = States::create($dbData);

            if ($d['state'] == 'Lagos') {
                foreach ($d['lgas'] as $lga) {
                    foreach ($lga as $key => $areas) {
                        foreach ($areas as $area) {
                            $lgaData = [
                                'states_id' => $state->id,
                                'area'      => "{$key} - {$area}",
                                'status'    => 'active',
                            ];

                            Areas::create($lgaData);
                        }
                    }
                }
            } else {
                foreach ($d['lgas'] as $lga) {
                    $lgaData = [
                        'states_id' => $state->id,
                        'area'      => $lga,
                        'status'    => 'inactive',
                    ];
                    Areas::create($lgaData);
                }
            }
        }

        return States::with('areas')->get();
    }

    /**
     *  Validate Input.
     *
     * @param mixed $request
     */
    public function validateData($request)
    {
        return $request->validate([
            'state' => 'required',
            'status' => 'required',
            'stateid' => 'required',
        ]);
    }

    /**
     *  Validate Input.
     *
     * @param mixed $request
     */
    public function validateAreaData($request)
    {
        return $request->validate([
            'area' => 'required',
            'states_id' => 'required',
        ]);
    }

}
