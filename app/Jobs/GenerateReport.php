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
use App\Models\PhoneCall;
use App\Models\PhoneCallEvent;
use App\Models\Report;
use App\Models\ReportTemplate;
use App\Jobs\Middleware\ReportNotRunning;
use App\Models\NumberFilterSetting;
use App\Models\OrganisationUnit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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

        $gatheredcalls = [];

        foreach ($callers as $caller)
        {
            $calls = PhoneCall::where([
                ['e164', '=', $caller->number],
                ['dir',  '=', 'from'],
                ['local', '>', Carbon::create($this->report->startdate)->timestamp],
                ['local', '<', Carbon::create($this->report->enddate)->timestamp],
            ]);



            Storage::disk('local')->append('innovaphonerequestlog.txt', "calls:");
            Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($calls));

        }


        $this->report->status = "finished";
        $this->report->save();






    }
}
