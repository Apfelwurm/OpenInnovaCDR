<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use App\Models\Caller;
use App\Models\Report;
use App\Models\ReportTemplate;
use App\Jobs\Middleware\ReportNotRunning;
use App\Models\NumberFilterSetting;
use App\Models\OrganisationUnit;
use Carbon\Carbon;

class GenerateReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    /**
     * The Report instance.
     *
     * @var \App\Models\Report
     */
    protected $report;

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [new ReportNotRunning];
    }
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->report->status  != "queued")
        {
            $this->report->status = "error";
            $this->report->save();

            $this->fail("report status has to be queued at start!");
        }

        $this->report->status = "running";

        if(!$this->report->save())
        {
            $this->fail("failed to save report");
        }

        $callers = Caller::all();
        $organisationUnits = OrganisationUnit::all();
        $numberFilterSettings = NumberFilterSetting::all();

        $currentdate = Carbon::create($this->report->reportTemplate->startdate);

        switch ($this->report->reportTemplate->timespan)
        {
            case 'one month back from now':
                $this->report->startdate = (new Carbon($currentdate))->subMonth();
                $this->report->enddate =  $currentdate;
                break;
            case 'last month':
                $this->report->startdate = (new Carbon('first day of last month'))->startOfMonth();
                $this->report->enddate =   (new Carbon('last day of last month'))->endOfMonth();
                break;
            case 'current month':
                $this->report->startdate = (new Carbon('first day of this month'))->startOfMonth();
                $this->report->enddate =   (new Carbon('last day of this month'))->endOfMonth();
                break;
            case 'one week back from now':
                $this->report->startdate = (new Carbon($currentdate))->subWeek();
                $this->report->enddate =  $currentdate;
                break;
            case 'last week':
                $this->report->startdate = Carbon::now()->subWeek()->startOfWeek();
                $this->report->enddate =   Carbon::now()->subWeek()->endOfWeek();
                break;
            case 'current week':
                $this->report->startdate = Carbon::now()->startOfWeek();
                $this->report->enddate =   Carbon::now()->endOfWeek();
                break;
            case 'one day back from now':
                $this->report->startdate = (new Carbon($currentdate))->subDay();
                $this->report->enddate =  $currentdate;
                break;
            case 'yesterday':
                $this->report->startdate = Carbon::now()->subDay()->startOfDay();
                $this->report->enddate =   Carbon::now()->subDay()->endOfDay();
                break;
            case 'today':
                $this->report->startdate = Carbon::now()->startOfDay();
                $this->report->enddate =   Carbon::now()->endOfDay();
                break;
            default:
                $this->report->status = "error";
                $this->report->save();
                return;
        }
        $this->report->status = "finished";
        $this->report->save();






    }
}
