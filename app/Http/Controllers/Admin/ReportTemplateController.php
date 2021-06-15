<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Report;
use App\Models\ReportTemplate;

class ReportTemplateController extends Controller
{
    public function index()
    {
         return Redirect::to('/admin/reports/');
    }

    public function show(ReportTemplate $reportTemplate)
    {
        return view('admin.reports.showtemplate')
        ->withUser(Auth::user())
        ->withReportTemplate($reportTemplate);
    }

    public function add(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $rules = [

            'type'          	=> 'required|in:time,cost',
            'output_format'     => 'required|in:PDF',
            'schedule'     	=> 'required|in:monthly,weekly,daily',
            'timespan'     	=> 'required|in:one month back from now,last month,current month,one week back from now,last week,current week,one day back from now,yesterday,today',
            'start_date'    => 'required|date_format:m/d/Y',
            'start_time'    => 'required|date_format:H:i',
        ];
        $messages = [
            'type.required'     				=> 'type is required',
            'type.in'     				=> 'direction must be time or cost',
            'output_format.required'     				=> 'output_format is required',
            'output_format.in'     				=> 'output_format must be PDF',
            'schedule.required'     				=> 'schedule is required',
            'schedule.in'     				=> 'schedule must be monthly/weekly/daily',
            'timespan.required'     				=> 'output_format is required',
            'timespan.in'     				=> 'output_format must be one month back from now/last month/current month/one week back from now/last week/current week/one day back from now/yesterday/today',
            'start_date.required'     				=> 'startdate is required',
            'start_date.date_format'     				=> 'startdate must be in m/d/Y format',
            'start_time.required'     				=> 'starttime is required',
            'start_time.date_format'     				=> 'starttime must be in H:i format',

        ];
        $this->validate($request, $rules, $messages);

        // Create Template
        $reportTemplate 						= New ReportTemplate;
        $reportTemplate->type         	= $request->type;
        $reportTemplate->output_format         	= $request->output_format;
        $reportTemplate->schedule         	= $request->schedule;
        $reportTemplate->timespan         	= $request->timespan;
        $reportTemplate->startdate         	= date("Y-m-d H:i:s", strtotime($request->start_date . $request->start_time));


        if (!$reportTemplate->save()) {
            Session::flash('alert-danger', 'Cannot create report template!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'number report template created!');
        return Redirect::to('/admin/reports/templates/'.$reportTemplate->id);
    }

    public function update(Request $request, ReportTemplate $reportTemplate)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }

        $rules = [
            'type'          	=> 'required|in:time,cost',
            'output_format'     => 'required|in:PDF',
            'schedule'     	=> 'required|in:monthly,weekly,daily',
            'timespan'     	=> 'required|in:one month back from now,last month,current month,one week back from now,last week,current week,one day back from now,yesterday,today',
            'start_date'    => 'required|date_format:m/d/Y',
            'start_time'    => 'required|date_format:H:i',
        ];
        $messages = [
            'type.required'     				=> 'type is required',
            'type.in'     				=> 'direction must be time or cost',
            'output_format.required'     				=> 'output_format is required',
            'output_format.in'     				=> 'output_format must be PDF',
            'schedule.required'     				=> 'schedule is required',
            'schedule.in'     				=> 'schedule must be monthly/weekly/daily',
            'timespan.required'     				=> 'output_format is required',
            'timespan.in'     				=> 'output_format must be one month back from now/last month/current month/one week back from now/last week/current week/one day back from now/yesterday/today',
            'start_date.required'     				=> 'startdate is required',
            'start_date.date_format'     				=> 'startdate must be in m/d/Y format',
            'start_time.required'     				=> 'starttime is required',
            'start_time.date_format'     				=> 'starttime must be in H:i format',

        ];
        $this->validate($request, $rules, $messages);

        $reportTemplate->type         	= $request->type;
        $reportTemplate->output_format         	= $request->output_format;
        $reportTemplate->schedule         	= $request->schedule;
        $reportTemplate->timespan         	= $request->timespan;
        $reportTemplate->startdate         	= date("Y-m-d H:i:s", strtotime($request->start_date . $request->start_time));

        if (!$reportTemplate->save()) {
            Session::flash('alert-danger', 'Cannot update report template!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'report template updated!');
        return Redirect::to('/admin/reports/templates/'.$reportTemplate->id);

    }

    public function remove(ReportTemplate $reportTemplate)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }

        if (!$reportTemplate->delete()) {
            Session::flash('alert-danger', 'Cannot delete report template!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'report template deleted!');
        return Redirect::to('/admin/reports/');

    }
}
