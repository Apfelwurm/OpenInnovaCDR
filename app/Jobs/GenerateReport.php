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
use App\Models\ReportCaller;
use App\Models\ReportNumberFilterSetting;
use App\Models\ReportOrganisationUnit;
use App\Models\ReportPhoneCall;
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

        $callers = Caller::whereNotNull("organisation_unit_id")->get();
        $reportNumberFilterSettings =  collect();
        $reportPhoneCalls =  collect();
        $reportOrganisationUnits =  collect();
        $reportData = collect();
        foreach (NumberFilterSetting::all() as $numberFilterSetting)
        {
            $reportNumberFilterSetting = new ReportNumberFilterSetting();
            $reportNumberFilterSetting->priority = $numberFilterSetting->priority;
            $reportNumberFilterSetting->direction = $numberFilterSetting->direction;
            $reportNumberFilterSetting->filter = $numberFilterSetting->filter;
            $reportNumberFilterSetting->cost = $numberFilterSetting->cost;
            $reportNumberFilterSetting->cost_multiplier = $numberFilterSetting->cost_multiplier;
            $reportNumberFilterSetting->ignore_on_timereport = $numberFilterSetting->ignore_on_timereport;
            $reportNumberFilterSetting->ignore_on_costreport = $numberFilterSetting->ignore_on_costreport;
            $reportNumberFilterSetting->save();
            $reportNumberFilterSettings->add($reportNumberFilterSetting);

        }


        foreach (OrganisationUnit::all() as $organisationUnit)
        {
            $reportOrganisationUnit = new ReportOrganisationUnit();
            $reportOrganisationUnit->name = $organisationUnit->name;
            $reportOrganisationUnit->save();
            $reportOrganisationUnits->add($reportOrganisationUnit);

        }




        foreach ($callers as $caller)
        {
            //nottested
            $calls = PhoneCall::where([
                ['e164', '=', $caller->number],
                ['dir',  '=', 'from'],
                ['local', '>', Carbon::create($this->report->startdate)->timestamp],
                ['local', '<', Carbon::create($this->report->enddate)->timestamp],
            ]);

            foreach (App\Models\CallerPrefix::getPrefixedNumber($caller->number) as $prefixedNumber )
            {
                $tempcalls = PhoneCall::where([
                    ['e164', '=', $prefixedNumber],
                    ['dir',  '=', 'from'],
                    ['local', '>', Carbon::create($this->report->startdate)->timestamp],
                    ['local', '<', Carbon::create($this->report->enddate)->timestamp],
                ]);
                $calls = $calls->merge($tempcalls);
            }




            Storage::disk('local')->append('innovaphonerequestlog.txt', "calls:");
            Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($calls));

            if ($calls->count() > 0)
            {
                $reportCaller= new ReportCaller();
                $reportCaller->name = $caller->name;
                $reportCaller->number = $caller->number;
                $reportCaller->report_organisation_unit_id = (($reportOrganisationUnits)->where('name', '=', $caller->organisationUnit->name))->id;
                $reportCaller->save();



                foreach ($calls as $call)
                {
                    $firstcallevent = ($call->phoneCallEvents)->whereIn('msg',['transfer-to', 'cf-to', 'conn-to'])->first();
                    $lastcallevent = ($call->phoneCallEvents)->whereIn('msg',['disc-to', 'disc-from', 'rel-to', 'rel-from'])->first();
                    $filterout = false;
                    Storage::disk('local')->append('innovaphonerequestlog.txt', "firstcallevent:");
                    Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($firstcallevent));
                    Storage::disk('local')->append('innovaphonerequestlog.txt', "lastcallevent:");
                    Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($lastcallevent));

                    if ($firstcallevent->type == 'ext')
                    {


                        if ($reportNumberFilterSettings->count() > 0)
                        {


                            foreach($reportNumberFilterSettings->sortBy('priority') as $reportNumberFilterSetting)
                            {

                                if ($reportNumberFilterSetting->matchesFilter($caller->number, $firstcallevent->e164))
                                {
                                    if ($reportNumberFilterSetting->ignoreOnReport($this->report->reportTemplate->type))
                                        $filterout = true;
                                    break;
                                }


                            }


                        }


                        if (!$filterout)
                        {
                            $reportPhoneCall = new ReportPhoneCall();
                            $reportPhoneCall->time = ($lastcallevent->time) - ($firstcallevent->time);
                            $reportPhoneCall->receiver = $firstcallevent->e164;
                            $reportPhoneCall->report_number_filter_setting_id = null; //implement cost filterchecks at first
                            $reportPhoneCall->report_caller_id = $reportCaller->id;
                            $reportPhoneCall->report_id = $this->report->id;
                            $reportPhoneCall->save();
                            Storage::disk('local')->append('innovaphonerequestlog.txt', "calculated time:");
                            Storage::disk('local')->append('innovaphonerequestlog.txt', "$reportPhoneCall->time");

                            $reportPhoneCalls->add($reportPhoneCall);


                        }





                    }



                }

            }

            foreach ($reportOrganisationUnits as $reportOrganisationUnit)
            {
                $amount = 0;
                $reportOrganisationUnitCalls = $reportPhoneCalls->reportPhoneCalls();

                switch ($this->report->reportTemplate->type)
                {
                    case 'cost':
                        foreach($reportOrganisationUnitCalls as $reportOrganisationUnitCall)
                        {



                            if ($reportNumberFilterSettings->count() > 0)
                            {

                                $match= false;
                                foreach($reportNumberFilterSettings->sortBy('priority') as $reportNumberFilterSetting)
                                {

                                    if ($reportNumberFilterSetting->matchesFilter($reportOrganisationUnitCall->reportCaller->number, $reportOrganisationUnitCall->receiver))
                                    {
                                        switch($reportNumberFilterSetting->cost_multiplier)
                                        {
                                            case 'minute':
                                                if (($reportOrganisationUnitCall->time % 60) != 0)
                                                {
                                                    $temporarytime=($reportOrganisationUnitCall->time / 60 );
                                                    $temporarytime=(int)$temporarytime;
                                                    $amount = $amount + (($temporarytime + 1) * $reportNumberFilterSetting->cost)
                                                }
                                                else
                                                {
                                                    $amount = $amount + (($reportOrganisationUnitCall->time / 60 ) * $reportNumberFilterSetting->cost)
                                                }
                                                break;
                                            case 'second':
                                                $amount = $amount + ($reportOrganisationUnitCall->time * $reportNumberFilterSetting->cost);
                                                break;
                                        }
                                        $match=true;
                                        break;
                                    }


                                }


                                if(!$match)
                                {
                                    $this->report->status = "error";
                                    $this->report->save();
                                    $this->fail("no filters for at least one call found in cost report");
                                }


                            }


                        }
                        break;
                    case 'time':
                        foreach($reportOrganisationUnitCalls as $reportOrganisationUnitCall)
                        {
                            $amount = $amount + $reportOrganisationUnitCall->time;
                        }
                        break;
                }

                Storage::disk('local')->append('innovaphonerequestlog.txt', "calculated time/cost for ou:");
                Storage::disk('local')->append('innovaphonerequestlog.txt', "$amount");
                $reportData->put(['name' => $reportOrganisationUnit->name, 'amount' => $amount]);
            }


        Storage::disk('local')->append('innovaphonerequestlog.txt', "reportdata:");
        Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($reportData));



        $this->report->status = "finished";
        $this->report->save();
    }





}
}

