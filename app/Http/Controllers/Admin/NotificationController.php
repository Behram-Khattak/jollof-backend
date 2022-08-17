<?php

/**
 * Notification Controller manages (show, edit, delete) the notification messages showing on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $notifications = Notification::all();

        return view('admin.notification.index', compact(['notifications']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $notification = new Notification();
        $location = [];
        $duration = date('m/d/Y') . ' - ' . date('m/d/Y');

        return view('admin.notification.create', compact(['notification', 'location', 'duration']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $this->validateData();

        //convert array to string
        $data['can_view'] = implode(',', $data['can_view']);
        $data['locations'] = implode(',', $data['locations']);

        //calculate expiry date
        $date = explode(' - ', $data['start_date']);
        $data['start_date'] = date('Y-m-d', strtotime($date[0]));
        $data['expire_date'] = date('Y-m-d', strtotime($date[1]));

        //add application data to database
        Notification::create($data);

        //rediret to applications details page
        return redirect('/admin/notification')->with([
            'message'    => 'Notification created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notification = Notification::findorfail($id);
        $location = explode(',', $notification->locations);
        $duration = date('m/d/Y', strtotime($notification->start_date)) . ' - ' . date('m/d/Y', strtotime($notification->expire_date));

        return view('admin.notification.edit', compact(['notification', 'location', 'duration']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validateData();

        //calculate expiry date
        $date = explode(' - ', $data['start_date']);
        $data['start_date'] = date('Y-m-d', strtotime($date[0]));
        $data['expire_date'] = date('Y-m-d', strtotime($date[1]));

        //convert array to string
        $data['locations'] = implode(',', $data['locations']);

        Notification::where('id', $id)->update($data);

        return redirect('/admin/notification');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notification = Notification::findorfail($id);

        if ($notification == null) {
            //redirect with message
            redirect('/admin/notification')->with([
                'message'    => 'There was a problem deleting the notification!',
                'alert-type' => 'error',
            ]);
        }

        Notification::where('id', $id)->delete();

        return redirect('/admin/notification')->with([
            'message'    => 'Notification deleted successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Validate form data.
     *
     * @param Type $var Description
     *
     * @throws conditon
     *
     * @return type
     */
    public function validateData()
    {
        return request()->validate([
            'title'       => 'required',
            'type'        => 'required',
            'message'     => 'required',
            'locations'   => 'required',
            'locations.*' => 'required',
            'can_view'    => 'required',
            'can_view.*'  => 'required',
            'start_date'  => 'required',
            'status'      => 'required',
        ]);
    }
}
