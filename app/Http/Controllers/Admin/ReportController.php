<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\ReportTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
class ReportController extends Controller
{
    public function index()
    {
         return view('admin.reports.index')
        ->withUser(Auth::user())
        ->withReports(Report::orderBy('created_at')->paginate(20))
        ->withReportTemplates(ReportTemplate::orderBy('created_at')->paginate(20));
    }

    public function show(Report $report)
    {
        return view('admin.reports.show')
        ->withUser(Auth::user())
        ->withReport($report);
    }


}
