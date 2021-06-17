<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ReportTemplate;
use App\Models\Report;
use App\Jobs\GenerateReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class QueueReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Storage::disk('local')->append('innovaphonerequestlog.txt', "queuereport running");

        $reportTemplates = ReportTemplate::where('schedule', 'once')->get();

        Storage::disk('local')->append('innovaphonerequestlog.txt', "queuereport tpls");
        Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($reportTemplates));

        if ($reportTemplates->count() > 0)
        {
            Storage::disk('local')->append('innovaphonerequestlog.txt', "queuereport reporttpls found");
            foreach($reportTemplates as $reportTemplate)
            {
                Storage::disk('local')->append('innovaphonerequestlog.txt', "queuereport single");
                Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($reportTemplate));


                Storage::disk('local')->append('innovaphonerequestlog.txt', Carbon::now());
                Storage::disk('local')->append('innovaphonerequestlog.txt', Carbon::create($reportTemplate->startdate));

                if (Carbon::now()->greaterThan(Carbon::create($reportTemplate->startdate)))
                {
                    Storage::disk('local')->append('innovaphonerequestlog.txt', "queuereport greater, run!");

                    if (Report::where([['report_template_id', '=', $reportTemplate->id],['created_at','>', $reportTemplate->startdate]])->count() == 0)
                    {
                        Storage::disk('local')->append('innovaphonerequestlog.txt', "queuereport no report found, create!");


                        $report = new Report();
                        $report->cause = 'scheduled';
                        $report->status = 'queued';
                        $report->report_template_id = $reportTemplate->id;


                        $currentdate = Carbon::create($reportTemplate->startdate);

                        switch ($reportTemplate->timespan)
                        {
                            case 'one month back from now':
                                 $report->startdate = (new Carbon($currentdate))->subMonth();
                                 $report->enddate =  $currentdate;
                                break;
                            case 'last month':
                                 $report->startdate = (new Carbon('first day of last month'))->startOfMonth();
                                 $report->enddate =   (new Carbon('last day of last month'))->endOfMonth();
                                break;
                            case 'current month':
                                 $report->startdate = (new Carbon('first day of this month'))->startOfMonth();
                                 $report->enddate =   (new Carbon('last day of this month'))->endOfMonth();
                                break;
                            case 'one week back from now':
                                 $report->startdate = (new Carbon($currentdate))->subWeek();
                                 $report->enddate =  $currentdate;
                                break;
                            case 'last week':
                                 $report->startdate = Carbon::now()->subWeek()->startOfWeek();
                                 $report->enddate =   Carbon::now()->subWeek()->endOfWeek();
                                break;
                            case 'current week':
                                 $report->startdate = Carbon::now()->startOfWeek();
                                 $report->enddate =   Carbon::now()->endOfWeek();
                                break;
                            case 'one day back from now':
                                 $report->startdate = (new Carbon($currentdate))->subDay();
                                 $report->enddate =  $currentdate;
                                break;
                            case 'yesterday':
                                 $report->startdate = Carbon::now()->subDay()->startOfDay();
                                 $report->enddate =   Carbon::now()->subDay()->endOfDay();
                                break;
                            case 'today':
                                 $report->startdate = Carbon::now()->startOfDay();
                                 $report->enddate =   Carbon::now()->endOfDay();
                                break;
                            default:
                                 $report->status = "error";
                                 $report->save();
                                return;
                        }

                        $report->save();

                        GenerateReport::dispatch($report);


                    }
                }


            }
        }





    }
}
