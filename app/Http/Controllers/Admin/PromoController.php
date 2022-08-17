<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promos = Promo::all();
        return view('admin.promo.index', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $promo = new promo();
        return view('admin.promo.create', compact('promo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validateData();
        $date = explode(' - ', $data['date_range']);
        unset($data['date_range']);
        $data['start'] = date('Y-m-d', strtotime($date[0]));
        $data['expire'] = date('Y-m-d', strtotime($date[1]));

        $status = $this->getPromoStatus($data['start'], $data['expire']);
        $data['status'] = $status;

        Promo::create($data);

        return redirect('/admin/promo')->with([
            'message'    => 'Promo created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function show(Promo $promo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function edit(Promo $promo)
    {
        $promo->date_range = date('m-d-Y', strtotime($promo->start)) . ' - ' . date('m-d-Y', strtotime($promo->expire));

        return view('admin.promo.edit', compact(['promo']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promo $promo)
    {
        $data = $this->validateData();
        $date = explode(' - ', $data['date_range']);
        unset($data['date_range']);

        $data['start'] = date('Y-m-d', strtotime($date[0]));
        $data['expire'] = date('Y-m-d', strtotime($date[1]));

        $status = $this->getPromoStatus($data['start'], $data['expire']);
        $data['status'] = $status;
        // return $data;
        $promo->update($data);

        return redirect('/admin/promo')->with([
            'message'    => 'Promo updated successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect('/admin/promo')->with([
            'message'    => 'Promo Deleted successfully!',
            'alert-type' => 'success',
        ]);
    }

    public function validateData()
    {
        return request()->validate([
            'name'        => 'required',
            'description' => 'required',
            'date_range'  => 'required',
        ]);
    }

    public function getPromoStatus($start = null, $end = null)
    {
        $now = strtotime(now());
        if ($now >= strtotime($start) && $now <= strtotime($end)) {
            return 'active';
        } else {
            return 'inactive';
        }
    }
}
