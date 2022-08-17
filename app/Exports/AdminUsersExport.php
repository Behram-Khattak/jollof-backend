<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AdminUsersExport implements fromView
{
    /**
    * @return View
    */
    protected $role;
    function __construct($role)
    {
        $this->role = $role;
    }
    public function view(): View
    {
        if($this->role == null){
            $users = User::with('roles')->latest()->get();
        }else{
        $users = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('name', $this->role);
        })->latest()->get();
        }
        return view('exports.users', compact('users'));
    }
}
