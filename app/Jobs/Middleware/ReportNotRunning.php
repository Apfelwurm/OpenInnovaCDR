<?php

namespace App\Jobs\Middleware;

use Closure;
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
    public function handle($job, $next)
    {
        if (Helpers::isReportRunning())
        {
            $job->release();
        }
        return $next($job);
    }
}
