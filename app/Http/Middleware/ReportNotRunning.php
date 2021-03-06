<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Libraries\Helpers;
class ReportNotRunning
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Helpers::isReportRunning())
        {
            Session::flash('alert-danger', 'Currently a Report is running, be patient!');
            return Redirect::back();
        }
        return $next($request);
    }
}
