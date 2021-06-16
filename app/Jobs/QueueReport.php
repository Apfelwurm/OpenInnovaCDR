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

                        $report->save();

                        GenerateReport::dispatch($report);


                    }
                }


            }
        }





    }
}
