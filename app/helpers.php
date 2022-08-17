<?php

use App\Enums\DefaultRoles;
use App\Enums\RoleTypes;
use App\Enums\TeamRoles;
use App\Models\Banner;
use App\Models\BusinessType;
use App\Models\Notification;
use App\Models\Role;
use App\Models\States;
use Carbon\Carbon;

if (!function_exists('adminMiddlewareRoles')) {
    /**
     * Get all admin roles that will be applied to middleware.
     *
     * @param float|int $ttl
     *
     * @return mixed
     */
    function adminMiddlewareRoles($ttl = 60)
    {
        return Cache::remember('adminMiddlewareRoles', $ttl, function () {
            if (Schema::hasTable('roles')) {
                return Role::where('name', '!=', DefaultRoles::USER)
                    ->where('name', '!=', DefaultRoles::MERCHANT)
                    // ->where('name', '!=', DefaultRoles::DISPATCH)
                    // ->where('type', RoleTypes::DEFAULT)
                    ->get()
                    ->implode('name', '|');
            }

            $filtered = collect(DefaultRoles::values())->reject(function ($value, $key) {
                return $value == DefaultRoles::USER || $value == DefaultRoles::MERCHANT || $value == DefaultRoles::DISPATCH;
            });

            return $filtered->implode('|');
        });
    }
}

if (!function_exists('merchantMiddlewareRoles')) {
    /**
     * Get all admin roles that will be applied to middleware.
     *
     * @param float|int $ttl
     *
     * @return mixed
     */
    function merchantMiddlewareRoles($ttl = 60 * 60)
    {
        return Cache::remember('merchantMiddlewareRoles', $ttl, function () {
            if (Schema::hasTable('roles')) {
                return Role::where('type', RoleTypes::TEAM)
                    ->orWhere('name', DefaultRoles::MERCHANT)->get()
                    ->implode('name', '|');
            }

            $filtered = collect(DefaultRoles::values())->reject(function ($value, $key) {
                return $value != DefaultRoles::MERCHANT;
            });

            return collect(TeamRoles::values())->merge($filtered)->implode('|');
        });
    }
}

if (!function_exists('applicationGuards')) {
    /**
     * Get all application guards.
     *
     * @return mixed
     */
    function applicationGuards()
    {
        return collect(config('auth.guards'))->keys();
    }
}

if (!function_exists('setlocation')) {
    /**
     * Get all application guards.
     *
     * @param mixed $location_array
     * @param mixed $check_value
     *
     * @return mixed
     */
    function setlocation($location_array, $check_value)
    {
        return (in_array($check_value, $location_array)) ? 'checked' : '';
    }
}

if (!function_exists('show_notification')) {
    function show_notification()
    {
        $today = date('Y-m-d');
        $notification = Notification::where('start_date', '<=', $today)->where('expire_date', '>=', $today)->where('status', 'active')->first();

        if (empty($notification)) {
            return false;
        }

        return view('partials._notifications', compact(['notification']));
    }
}

if (!function_exists('str_to_list')) {
    /**
     * Get all application guards.
     *
     * @param mixed $params
     *
     * @return mixed
     */
    function str_to_list($params)
    {
        $param_array = explode(',', $params);
        $list = '<ul>';
        foreach ($param_array as $p) {
            $list .= '<li>' . $p . '</li>';
        }
        $list .= '</ul>';

        return $list;
    }
}

if (!function_exists('get_states')) {
    function get_states(): array
    {
        $allStates = [];
        $states = States::where('status', 'active')->orderBy('state', 'desc')->get();
        foreach ($states as $state) {
            $allStates[$state->state] = $state->state;
        }

        return $allStates;
    }
}

if (!function_exists('microsites')) {
    /**
     * Get all application guards.
     *
     * @param null|mixed $location
     *
     * @return mixed
     */
    function microsites($location = null)
    {
        $slots = [
            'Jollof'      => ['ad_slot_1', 'ad_slot_2'],
            'Cuisine'     => ['ad_slot_1', 'ad_slot_2'],
            'Fashion'     => ['ad_slot_1', 'ad_slot_2'],
            'Movies'      => ['slider', 'popup'],
            'Events'      => ['slider', 'popup'],
            'Tourism'     => ['slider', 'popup'],
            'Travels'     => ['slider', 'popup'],
            'Gift portal' => ['slider', 'popup'],
            'Business'    => ['slider', 'popup'],
            'Scholar'     => ['slider', 'popup'],
        ];
        if (!$location) {
            return $slots;
        }

        return $slots[$location];
    }
}

if (!function_exists('show_banner')) {
    function show_banner($microsite, $slot)
    {
        $today = Carbon::today();
        $banner = Banner::where('microsite', $microsite)
            ->where('slot', $slot)
            ->where('status', 'active')
            ->whereDate('expiry_date', '>=', $today)
            ->first();

        return view('admin.partials._banner', compact(['banner', 'slot']));
    }
}

if (!function_exists('show_popup')) {
    function show_popup()
    {
        if (count(Request::segments()) > 1) {
            return false;
        }

        $microsite = Request::segment(1);
        $microsite = !$microsite ? 'Jollof' : $microsite;
        $popup = Banner::where('microsite', $microsite)->where('slot', 'popup')->where('status', 'active')->first();

        if (empty($popup)) {
            return false;
        }

        return view('admin.partials._popup', compact(['popup']));
    }
}

if (!function_exists('get_image_url')) {
    function get_image_url($images, $type)
    {
        if (!empty($images)) {
            foreach ($images as $im) {
                $properties = $im->custom_properties;
                if (isset($properties['type']) && $properties['type'] == $type) {
                    return $im->getFullUrl();
                }

                if (isset($properties['type']) && $properties['type'] == $type) {
                    return $im->getFullUrl();
                }
            }
        }
    }
}

if (!function_exists('getImageSrc')) {
    function getImageSrc($images)
    {
        if (!empty($images)) {
            return $images->getFirstMediaUrl('menu');
        }
    }
}

if (!function_exists('locations_json')) {
    function locations_json($state = null)
    {
        $all_locations = [];
        if ($state) {
            $location = States::with('areas')->orderBy('state', 'desc')->where('state', $state)->first();
            foreach ($location->areas as $a) {
                $all_locations[$a->area] = $a->area;
            }
        } else {
            $locations = States::with('areas')->orderBy('state', 'desc')->get();
            foreach ($locations as $l) {
                foreach ($l->areas as $a) {
                    $all_locations[$l->state][$a->area] = $a->area;
                }
            }
        }

        return $all_locations;
    }
}

if (!function_exists('merchantOrderStatus')) {
    function merchantOrderStatus($status, $id)
    {
        $actionButton = '';
        if ($status == 'pending') {
            $actionButton .= "<a href='#' class='btn btn-success processing mr-2' data-toggle='modal' data-target='.process-modal-sm' data-id='" . $id . "' data-status='processing'>Processs</a>";
            //$actionButton .= "<a href='#' class='btn btn-danger'>Not Process</a>";
        } elseif ($status == 'processing') {
            $actionButton .= 'Processing';
        } elseif ($status == 'pickedup') {
            $actionButton .= 'Picked up';
        } elseif ($status == 'delivered') {
            $actionButton .= 'Delivered';
        }

        return $actionButton;
    }
}

if (!function_exists('orderstatusmessage')) {
    function orderstatusmessage($status, $delivery_time, $pickedup_time, $process_time, $duration)
    {
        $message = '';
        if ($status == 'delivered' && $delivery_time != null) {
            $message = 'Delivered ' . (\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $delivery_time))->format('M-d-Y H:i a');;
            // $message = 'Delivered '.(\Carbon\Carbon::parse($delivery_time))->diffForHumans();
        } elseif ($status == 'pickedup' && $pickedup_time != null) {
            $message  = 'Picked up ' . (\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pickedup_time))->format('M-d-Y H:i a');;
            // $message = 'Picked Up '.(\Carbon\Carbon::parse($pickedup_time))->diffForHumans(). '<br> Ready in about '. $duration .'mins';
            $message .= '<br> Delivered in about ' . $duration . 'mins';
        } elseif ($status == 'processing' && $process_time != null) {
            // $format = \Carbon\Carbon::parse($process_time)->format('Y M D h:i A');
            // $formattedDate = date($process_time);
            // $message = 'Processed '. $formattedDate;
            $message = 'Processed on ' . (\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $process_time))->format('M-d-Y H:i a');

            $message .= '<br> Ready in about ' . $duration . 'mins';
        } else {
            $message = '';
        }
        return $message;
    }
}

if (!function_exists('style_status')) {
    function style_status($status)
    {
        switch ($status) {
            case 'processing':
                return "<span class='badge badge-warning'>Processing</span>";
                break;
            case 'pending':
                return "<span class='badge badge-dark text-white'>Pending</span>";
                break;
            case 'pickedup':
                return "<span class='badge badge-info'>Picked Up</span>";
                break;
            case 'delivered':
                return "<span class='badge badge-success'>Delivered</span>";
                break;
            default:
                return "<span class='badge badge-dark'>Pending</span>";
                break;
        }
    }
}

if (!function_exists('payment_status')) {
    function payment_status($status)
    {
        switch ($status) {
            case 'pending':
                return "<span class='font-weight-bold text-warning'>Pending</span>";
                break;
            case 'failed':
                return "<span class='font-weight-bold text-danger'>Failed</span>";
                break;
            case 'paid':
                return "<span class='font-weight-bold text-success'>Paid</span>";
                break;
            default:
                return "<span class='font-weight-bold text-dark'>Pending</span>";
                break;
        }
    }
}

if (!function_exists('dispatchOrderStatus')) {
    function dispatchOrderStatus($status, $id)
    {
        $actionButton = '';

        if ($status == 'processing') {
            $actionButton .= "<a href='#' class='btn btn-info processing' data-toggle='modal' data-target='.process-modal-sm' data-id='" . $id . "' data-status='pickedup'>Set to Pick Up</a>";
        }

        if ($status == 'pickedup') {
            $actionButton .= "<a href='#' class='btn btn-info processing' data-toggle='modal' data-target='.process-modal-sm' data-id='" . $id . "' data-status='delivered'>Set to Delivered</a>";
        }

        return $actionButton;
    }
}

if (!function_exists('restaurantDefault')) {
    function restaurantDefault()
    {
        $delivery = ['pickup', 'Courier'];
        $payment = ['card'];

        $status = [
            'Monday'    => 1,
            'Tuesday'   => 1,
            'Wednesday' => 1,
            'Thursday'  => 1,
            'Friday'    => 1,
            'Saturday'  => 1,
            'Sunday'    => 1,
        ];

        $hours = [
            'Monday'    => ['8:00', '21:00'],
            'Tuesday'   => ['8:00', '21:00'],
            'Wednesday' => ['8:00', '21:00'],
            'Thursday'  => ['8:00', '21:00'],
            'Friday'    => ['8:00', '21:00'],
            'Saturday'  => ['8:00', '21:00'],
            'Sunday'    => ['8:00', '21:00'],
            'status'    => $status
        ];

        return [
            'min_order'        => '2000',
            'disposable'       => 'no',
            'delivery_fee'     => '500',
            'delivery_time'    => '60-90',
            'delivery_options' => implode(',', $delivery),
            'payment_types'    => implode(',', $payment),
            'hours'            => json_encode($hours),
            'default_setup'    => 1,
        ];
    }
}

if (!function_exists('restaurantCategoryDefault')) {
    function restaurantCategoryDefault()
    {
        return [
            "African food",
            "American",
            "Brazilian",
            "Breakfast",
            "British",
            "Burgers",
            "Cafe",
            "Cakes",
            "Chinese",
            "Confectioneries",
            "Continental",
            "Crepe",
            "Desserts",
            "European",
            "French",
            "Fruits",
            "Grill & BBQ",
            "Indian",
            "Italian",
            "Japanese",
            "Juices",
            "Lebanese",
            "Mediterranean",
            "Mexican",
            "Nigerian",
            "Pizza",
            "Salads and Fruits",
            "Sandwiches",
            "Seafood",
            "Small Chops/Finger Foods",
            "Thai"
        ];
    }
}

if (!function_exists('restaurantOpen')) {
    function restaurantOpen($hours)
    {
        if (!$hours) {
            return false;
        }

        $hours_array = json_decode($hours, true);
        $currentHour = date('H');
        $currentDay = date('l');
        $today = $hours_array[$currentDay];
        $isopen = (isset($hours_array['status'])) ? $hours_array['status'][$currentDay] : 0;

        $open = explode(':', $today[0]);
        $close = explode(':', $today[1]);

        if ($currentHour < $open[0] || $currentHour >= $close[0]) {
            return false;
        }

        if (!$isopen) {
            return false;
        }

        return true;
    }
}

if (!function_exists('checkMicrosite')) {
    function checkMicrosite($id, $name)
    {
        $microsite = BusinessType::whereId($id)->first();

        if (!$microsite) {
            return false;
        }

        if ($microsite->name == $name) {
            return true;
        }
    }
}

//Facebook Share
if (!function_exists('facebook_share')) {
    function facebook_share($url, $img, $title, $desc)
    {
        $custom_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $url . '&picture=' . $img . '&title=' . $title . '&description=' . $desc;

        return '<a href="' . $custom_url . '" target="_blank" onclick="popitup(this.href)"><i class="fa fa-facebook-square w3-large w3-text-black"></i></a>';
    }
}

//WhatsApp Share
if (!function_exists('whatsapp_share')) {
    function whatsapp_share($url)
    {
        $custom_url = 'https://wa.me/?text=' . urlencode($url) . '&source=' . SITE_URL . '&data=check this out';

        return '<a href="' . $custom_url . '" target="_blank" onclick="popitup(this.href)"><i class="fa fa-whatsapp w3-large w3-text-black"></i></a>';
    }
}

//Twitter Share
if (!function_exists('twitter_share')) {
    function twitter_share($url)
    {
        $custom_url = 'https://twitter.com/intent/tweet?url=' . urlencode($url);

        return '<a href="' . $custom_url . '" class="btn btn-info btn-join btn-lg" target="_blank" onclick="popitup(this.href)"><i class="fa fa-twitter w3-large w3-text-black"></i> Share Link on Twitter</a>';
    }
}

if (!function_exists('calculateMenuPrice')) {
    function calculateMenuPrice($price, $sales_price, $sales_start, $sales_end)
    {
        $today = date('Y-m-d H:i');

        if (now()->between(now()->parse($sales_start), now()->parse($sales_end))) {
            if ($sales_price > 0) {
                return '<strong>' . number_format($sales_price, 2) . "</strong> <del class='text-muted'>" . $price . '</del>';
            }
            return '<strong>' . number_format($price, 2) . '</strong>';
        }
        return '<strong>' . number_format($price, 2) . '</strong>';


        //check sales period
        // $today = Carbon::today();
        // $start_sales = Carbon::parse($sales_start);
        // $end_sales = Carbon::parse($sales_end);

        // //if day within period, show sales price else
        // if ($start_sales->lte($today) && $end_sales->gte($today)) {
        //     return '<strong>'.$sales_price."</strong> <del class='text-muted'>".$price.'</del>';
        // }

        // return '<strong>'.$price.'</strong>';

    }
}

if (!function_exists('getPromoStatus')) {
    function getPromoStatus($start, $end)
    {
        $now = strtotime(now());
        if ($now >= strtotime($start) && $now <= strtotime($end)) {
            return "<span class='font-weight-bold text-success'>ACTIVE</span>";
        } else {
            return "<span class='font-weight-bold text-danger'>INACTIVE</span>";
        }
    }
}

if (!function_exists('getCouponStatus')) {
    function getCouponStatus($start, $end, $used = null)
    {
        $now = strtotime(now());
        if($used == true){
            return "<span class='font-weight-bold text-primary'>USED</span>";
        }
        if ($now >= strtotime($start) && $now <= strtotime($end)) {
            return "<span class='font-weight-bold text-success'>ACTIVE</span>";
        } else {
            return "<span class='font-weight-bold text-danger'>INACTIVE</span>";
        }
    }
}

if (!function_exists('getTimeZoneForOrderLogs')) {
    function getTimeZone($time)
    {
        if($time == null) {
            return '---';
        }
        else{
            $dateTime = new DateTime($time, new DateTimeZone('Africa/Lagos'));
            return Carbon::parse($dateTime)->toDayDateTimeString();
        }
    }
}
