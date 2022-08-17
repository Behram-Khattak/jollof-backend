<?php

/**
 * Audit Controller manages (show, filter) the audit tracking on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AuditController extends Controller
{
    /**
     * Display tabular data of most recent audit tracking on the application.
     */
    public function index()
    {
        $audits = \OwenIt\Auditing\Models\Audit::with('user')
            ->orderBy('created_at', 'desc')->get();

        return view('admin.audit', compact(['audits']));
    }
}
