<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Enums\BusinessTypeEnum;
use App\Models\HomeImage;

class BannerController extends Controller
{

    var $sites = [
        'cuisine' => BusinessTypeEnum::CUISINE,
        'fashion' => BusinessTypeEnum::FASHION,
        'lifestyle' => BusinessTypeEnum::LIFESTYLE,
        'scholar' => BusinessTypeEnum::SCHOLAR,
        'business' => BusinessTypeEnum::BUSINESS,
        'giftportal' => BusinessTypeEnum::GIFT_PORTAL
    ];
    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     */
    public function updateBanner(Request $request)
    {
        $data = request()->validate([
            'banner'        => 'required|numeric',
            'link'          => 'required',
            'file_url'      => 'required|mimes:JPEG,jpeg,bmp,jpg,JPG,png,PNG,GIF,gif,Gif|max:500'
        ]);

        $banner = Banner::findorfail($data['banner']);
        $images = $data['file_url'];
        $links = $data['link'];
        $banner->addMedia($images)->withCustomProperties(['link' => $links])->toMediaCollection();

        return redirect(url()->previous())->with([
            'alertType' => 'success',
            'message' => 'Banner added successfully.'
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
    public function homeImages()
    {

        $sites = $this->sites;
        $images = HomeImage::with('media')->get();

        return view("admin.banner.homeimage", compact(['sites', 'images']));
    }


    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     */
    public function updateImage(Request $request)
    {
        $data = request()->validate([
            'site'        => 'required',
            'status'        => 'required',
            'slogan'        => 'required',
            'file_url'      => 'required|mimes:JPEG,jpeg,bmp,jpg,JPG,png,PNG,GIF,gif,Gif|max:500'
        ]);

        $site = $data['site'];
        $status = $data['status'];
        $name = $this->sites[$site];
        $images = $data['file_url'];
        unset($data['file_url']);

        $home = HomeImage::updateOrCreate(['site' => $site], ['name' => $name, 'status' => $status, 'slogan' => $data['slogan']]);
        $home->addMedia($images)->toMediaCollection('homeblock');

        return redirect(url()->previous())->with([
            'alertType' => 'success',
            'message' => 'Banner added successfully.'
        ]);
    }
}
