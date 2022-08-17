<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     */
    public function index()
    {
        $sliders = Banner::all();

        return view('admin.slider.index', compact(['sliders']));
    }

    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     *
     * @param mixed $site
     */
    public function microsite($site)
    {
        $location = microsites(ucfirst($site));
        $banners = Banner::where('microsite', $site)->where('banner_type', 'slider')->get();

        return view('admin.slider.microsite', compact(['location', 'banners']));
    }

    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     *
     * @throws conditon
     *
     * @return type
     */
    public function create()
    {
        $banner = new Banner();
        $location = [];
        $duration = date('m/d/Y') . ' - ' . date('m/d/Y');

        return view('admin.slider.create', compact(['banner', 'location', 'duration']));
    }

    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     *
     * @throws conditon
     *
     * @return type
     */
    public function store(Request $request)
    {
        $data = $this->validateData();

        //convert array to string
        $data['can_view'] = implode(',', $data['can_view']);

        //calculate expiry date
        $date = explode(' - ', $data['start_date']);
        $data['start_date'] = date('Y-m-d', strtotime($date[0]));
        $data['expiry_date'] = date('Y-m-d', strtotime($date[1]));

        $microsite = $data['microsite'];
        $images = $data['file_url'];
        $links = $data['link'];
        unset($data['file_url'], $data['link']);

        //add application data to database
        $banner = Banner::create($data);

        //upload and add file to media
        for ($i = 0; $i < count($images); $i++) {
            //foreach ($images as $image) {
            $banner->addMedia($images[$i])->withCustomProperties(['link' => $links[$i]])->toMediaCollection();
        }

        //rediret to applications details page
        return redirect("/admin/slider/p/{$microsite}")->with([
            'message'    => 'Slider created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     *
     * @param mixed $id
     */
    public function show($id)
    {
        $banner = Banner::findorfail($id);

        return view('admin.slider.show', compact(['banner']));
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
    public function edit($id)
    {
        $banner = Banner::findorfail($id);
        $banner_type = $banner->banner_type;
        $location = explode(',', $banner->location);
        $duration = date('m/d/Y', strtotime($banner->start_date)) . ' - ' . date('m/d/Y', strtotime($banner->expiry_date));

        return view('admin.slider.edit', compact(['banner', 'banner_type', 'location', 'duration']));
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
    public function update(Request $request, $id)
    {
        $data = $this->validateData();

        $banner = Banner::findorfail($id);

        //convert array to string
        $data['can_view'] = implode(',', $data['can_view']);

        //calculate expiry date
        $date = explode(' - ', $data['start_date']);
        $data['start_date'] = date('Y-m-d', strtotime($date[0]));
        $data['expiry_date'] = date('Y-m-d', strtotime($date[1]));

        $microsite = $banner->microsite;

        Banner::where('id', $id)->update($data);

        return redirect("/admin/slider/p/{$microsite}")->with([
            'message'    => 'slider updated successfully',
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
    public function destroy($id)
    {
        $banner = Banner::findorfail($id);

        if ($banner == null) {
            //redirect with message
            redirect("/admin/slide/{$id}")->with([
                'message'    => 'There was a problem deleting the slider!',
                'alert-type' => 'error',
            ]);
        }
        $microsite = $banner->microsite;
        $banner->delete();

        return redirect("/admin/slider/p/{$microsite}")->with([
            'message'    => 'Slider deleted successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     *
     * @param Type  $var   Description
     * @param mixed $id
     * @param mixed $index
     *
     * @throws conditon
     *
     * @return type
     */
    public function destroy_slide($id, $index)
    {
        $banner = Banner::findorfail($id);

        if ($banner == null) {
            //redirect with message
            redirect("/admin/slider/{$id}")->with([
                'message'    => 'There was a problem deleting the slide!',
                'alert-type' => 'error',
            ]);
        }
        $slides = $banner->getMedia();
        $slides[$index]->delete();

        return redirect("/admin/slider/{$id}")->with([
            'message'    => 'Slide deleted successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     *
     * @throws conditon
     *
     * @return type
     */
    public function validateData()
    {
        $request_data = [
            'title'      => 'required',
            'can_view'   => 'required',
            'can_view.*' => 'required',
            'start_date' => 'required',
            'link'       => '',
            'status'     => 'required',
        ];

        if (isset(request()->microsite)) {
            $request_data['microsite'] = 'required';
        }

        if (isset(request()->slot)) {
            $request_data['slot'] = 'required';
        }

        if (isset(request()->banner_type)) {
            $request_data['banner_type'] = 'required';
        }

        if (request()->hasfile('file_url')) {
            $request_data['file_url'] = 'required';
            $request_data['file_url.*'] = 'mimes:JPEG,jpeg,bmp,jpg,JPG,png,gif,GIF,gif,Gif|max:500';
        }

        return request()->validate($request_data);
    }
}
