<?php

namespace App\Http\Controllers\Merchant;

use App\Exports\AdminBillingExport;
use App\Exports\AdminOrderExport;
use App\Exports\AdminUsersExport;
use App\Exports\DispatchExport;
use App\Exports\OrderExport;
use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function AllOrder($format)
    {
        if($format == 'excel'){
            return Excel::download(new OrderExport, 'orders.xlsx');
        }elseif($format == 'csv'){
            return Excel::download(new OrderExport, 'orders.csv');
        } else {
            return redirect()->back()->with([
                'message'    => 'Menu updated successfully!',
                'alert-type' => 'success',
            ]);
        }
    }

    public function report($format,$start,$end,$business,$payment)
    {
        if($format == 'excel'){
            return Excel::download(new ReportExport($start,$end,$business,$payment), 'report.xlsx');
        } elseif ($format == 'csv') {
            return Excel::download(new ReportExport($start,$end,$business,$payment), 'report.csv');
        } else{
            return redirect()->back()->with([
                'message'    => 'Menu updated successfully!',
                'alert-type' => 'success',
            ]);
        }
    }

    public function adminOrderExport($format)
    {
        if ($format == 'excel') {
            return Excel::download(new AdminOrderExport, 'orders.xlsx');
        } elseif ($format == 'csv') {
            return Excel::download(new AdminOrderExport, 'orders.csv');
        } else {
            return redirect()->back()->with([
                'message'    => 'Menu updated successfully!',
                'alert-type' => 'success',
            ]);
        }
    }

    public function billingExportCsv($business,$start,$end)
    {
        return Excel::download(new AdminBillingExport($business,$start,$end), 'billing.csv');
    }
    public function billingExportExcel($business,$start, $end)
    {
        return Excel::download(new AdminBillingExport($business,$start,$end), 'billing.xlsx');
    }

    public function DispatchExport($format)
    {
        if ($format == 'excel') {
            return Excel::download(new DispatchExport, 'Dispatch.xlsx');
        } elseif ($format == 'csv') {
            return Excel::download(new DispatchExport, 'Dispatch.csv');
        } else {
            return redirect()->back()->with([
                'message'    => 'Menu updated successfully!',
                'alert-type' => 'success',
            ]);
        }
    }

    public function adminUsersExport($format)
    {
        $url = url()->previous();
        // get query string
        $query = parse_url($url, PHP_URL_QUERY);
        // get query string as array
        if($query == null){
            $role = '';
        }else{
        $role = explode('=', $query)[1];
        }


        if ($format == 'excel') {
            return Excel::download(new AdminUsersExport($role), 'users.xlsx');
        } elseif ($format == 'csv') {
            return Excel::download(new AdminUsersExport($role), 'users.csv');
        } else {
            return redirect()->back()->with([
                'message'    => 'Menu updated successfully!',
                'alert-type' => 'success',
            ]);
        }
    }
}
