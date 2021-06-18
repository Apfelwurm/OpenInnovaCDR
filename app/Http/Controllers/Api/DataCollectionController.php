<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PhoneCall;
use App\Models\PhoneCallEvent;
use App\Models\Caller;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;
use App\Models\CallerPrefix;
class DataCollectionController extends Controller
{
    public function innovaphone(Request $request)
    {


        $data = implode("", $request->all());

        if (!str_starts_with($data, "<") )
        {
            Storage::disk('local')->append('innovaphonerequestlog.txt', "request no xml?:");
            Storage::disk('local')->append('innovaphonerequestlog.txt', $data);
            return false;
        }

        $xml = simplexml_load_string($data);

        if ( $xml != false)
        {
            $json = json_encode($xml);
            $currentdata = json_decode($json, true);

            if(env('APP_DEBUG') == true)
            {
                Storage::disk('local')->append('innovaphonerequestlog.txt', "debugserialize:");
                Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($currentdata));
                Storage::disk('local')->append('innovaphonerequestlog.txt', "debugprintr:");
                Storage::disk('local')->append('innovaphonerequestlog.txt', print_r($currentdata));

            }


            if(array_key_exists("@attributes", $currentdata))
            {

                $phonecall = new PhoneCall();

                if (array_key_exists("guid", $currentdata["@attributes"]))
                    $phonecall->guid = $currentdata["@attributes"]["guid"];

                if (array_key_exists("sys", $currentdata["@attributes"]))
                    $phonecall->sys = $currentdata["@attributes"]["sys"];

                if (array_key_exists("pbx", $currentdata["@attributes"]))
                    $phonecall->pbx = $currentdata["@attributes"]["pbx"];

                if (array_key_exists("node", $currentdata["@attributes"]))
                    $phonecall->node = $currentdata["@attributes"]["node"];

                if (array_key_exists("cn", $currentdata["@attributes"]))
                    $phonecall->cn = $currentdata["@attributes"]["cn"];

                if (array_key_exists("e164", $currentdata["@attributes"]))
                    $phonecall->e164 = $currentdata["@attributes"]["e164"];

                if (array_key_exists("h323", $currentdata["@attributes"]))
                    $phonecall->h323 = $currentdata["@attributes"]["h323"];

                if (array_key_exists("device", $currentdata["@attributes"]))
                    $phonecall->device = $currentdata["@attributes"]["device"];

                if (array_key_exists("dir", $currentdata["@attributes"]))
                    $phonecall->dir = $currentdata["@attributes"]["dir"];

                if (array_key_exists("utc", $currentdata["@attributes"]))
                    $phonecall->utc = $currentdata["@attributes"]["utc"];

                if (array_key_exists("local", $currentdata["@attributes"]))
                    $phonecall->local = $currentdata["@attributes"]["local"];



                if (!$phonecall->save()) {
                    Storage::disk('local')->append('innovaphonerequestlog.txt', "phonecall could not be saved! object:");
                    Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($phonecall));
                    Storage::disk('local')->append('innovaphonerequestlog.txt', "phonecall could not be saved! raw:");
                    Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($currentdata));
                    error_log("phonecall could not be saved! object:", TRUE);
                    error_log( print_r($phonecall), TRUE);
                    error_log("phonecall could not be saved! raw:", TRUE);
                    error_log( print_r($currentdata), TRUE);
                }



            }
            else
            {
                if (!Storage::disk('local')->exists('innovaphonerequestlog.txt')) {

                    Storage::disk('local')->put('innovaphonerequestlog.txt', serialize($currentdata));
                }
                else
                {
                    Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($currentdata));
                }
            }

            if(array_key_exists("event", $currentdata))
            {
                $phoneCallEvents = collect();
                foreach($currentdata["event"] as $item) {

                    if(env('APP_DEBUG') == true)
                    {
                        Storage::disk('local')->append('innovaphonerequestlog.txt', "eventdebugserialize:");
                        Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($item));
                        Storage::disk('local')->append('innovaphonerequestlog.txt', "eventdebugprintr:");
                        Storage::disk('local')->append('innovaphonerequestlog.txt', print_r($item));
                        Storage::disk('local')->append('innovaphonerequestlog.txt', "eventtestwrite:");
                        Storage::disk('local')->append('innovaphonerequestlog.txt', $item["@attributes"]["msg"]);

                    }

                    if(array_key_exists("@attributes", $item))
                    {


                        $phonecallevent = new PhoneCallEvent();


                        if (array_key_exists("msg", $item["@attributes"]))
                            $phonecallevent->msg = $item["@attributes"]["msg"];

                        if (array_key_exists("time", $item["@attributes"]))
                            $phonecallevent->time = $item["@attributes"]["time"];

                        if (array_key_exists("type", $item["@attributes"]))
                            $phonecallevent->type = $item["@attributes"]["type"];

                        if (array_key_exists("e164", $item["@attributes"]))
                            $phonecallevent->e164 = $item["@attributes"]["e164"];

                        if (array_key_exists("root", $item["@attributes"]))
                            $phonecallevent->root = $item["@attributes"]["root"];

                        if (array_key_exists("h323", $item["@attributes"]))
                            $phonecallevent->h323 = $item["@attributes"]["h323"];

                        if (array_key_exists("conf", $item["@attributes"]))
                            $phonecallevent->conf = $item["@attributes"]["conf"];

                        if (array_key_exists("cause", $item["@attributes"]))
                            $phonecallevent->cause = $item["@attributes"]["cause"];

                        if (array_key_exists("more", $item["@attributes"]))
                            $phonecallevent->msg = $item["@attributes"]["more"];

                        $phonecallevent->phone_call_id = $phonecall->id;


                        if (!$phonecallevent->save()) {
                            Storage::disk('local')->append('innovaphonerequestlog.txt', "phonecallevent could not be saved! object:");
                            Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($phonecallevent));
                            Storage::disk('local')->append('innovaphonerequestlog.txt', "phonecallevent could not be saved! raw:");
                            Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($currentdata));
                            error_log("phonecallevent could not be saved! object:", TRUE);
                            error_log( print_r($phonecallevent), TRUE);
                            error_log("phonecallevent could not be saved! raw:", TRUE);
                            error_log( print_r($currentdata), TRUE);
                        }
                        else
                        {
                            $phoneCallEvents->add($phonecallevent);
                        }
                    }



                }

            }


            $firstcallevent = ($phoneCallEvents)->whereIn('msg',['setup-from'])->first();
            Storage::disk('local')->append('innovaphonerequestlog.txt', "firstcallevent collect:");
            Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($firstcallevent));

            Storage::disk('local')->append('innovaphonerequestlog.txt', "phonecall decition");
            Storage::disk('local')->append('innovaphonerequestlog.txt', "pcall:");
            Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($phonecall));


            if (($phonecall->dir == "from" && (str_starts_with($phonecall->e164, "00" == false))) && $phonecall->e164 != null && $phonecall->e164 != "" && (($firstcallevent->type != "ext" && (str_starts_with($firstcallevent->e164, "00") == false) ) || ($firstcallevent->type == "ext" && (str_starts_with($firstcallevent->e164, "00") ==true ) ) ))
                    {
                        Storage::disk('local')->append('innovaphonerequestlog.txt', "phonecall selected");
                        Storage::disk('local')->append('innovaphonerequestlog.txt', "number:");
                        Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($phonecall->e164));

                        $savecaller = false;
                        if (Caller::where(['number' => $phonecall->e164])->first() !=  null)
                        {
                            Storage::disk('local')->append('innovaphonerequestlog.txt', "caller found");
                            Storage::disk('local')->append('innovaphonerequestlog.txt', "number:");
                            Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($phonecall->e164));

                            $caller = Caller::where(['number' => $phonecall->e164])->first();
                            if ($phonecall->h323 != null && $phonecall->h323 != "" && $phonecall->h323 != $caller->name && Setting::isAutomaticCallerUpdateEnabled() )
                            {
                                Storage::disk('local')->append('innovaphonerequestlog.txt', "update caller");
                                Storage::disk('local')->append('innovaphonerequestlog.txt', "name:");
                                Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($phonecall->h323));
                                $caller->name = $phonecall->h323;
                                $savecaller = true;
                            }
                        }
                        else
                        {
                            if (Setting::isAutomaticCallerCreationEnabled())
                            {
                                Storage::disk('local')->append('innovaphonerequestlog.txt', "started automatic caller creation");
                                Storage::disk('local')->append('innovaphonerequestlog.txt', "number:");
                                Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($phonecall->e164));
                                Storage::disk('local')->append('innovaphonerequestlog.txt', "prefix check:");
                                Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode(CallerPrefix::matchesAnyPrefix($phonecall->e164)));



                                $caller = new Caller();
                                $caller->name =  $phonecall->h323;

                                if (!CallerPrefix::matchesAnyPrefix($phonecall->e164))
                                {
                                Storage::disk('local')->append('innovaphonerequestlog.txt', "number not matches any profix");

                                    $caller->number =  $phonecall->e164;
                                    $savecaller = true;
                                }
                                else
                                {
                                    Storage::disk('local')->append('innovaphonerequestlog.txt', "prefixed caller check");
                                    Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($phonecall->e164));
                                    Storage::disk('local')->append('innovaphonerequestlog.txt', "prefixed caller check");
                                    Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode((string)CallerPrefix::firstMatchedPrefix($phonecall->e164)));
                                    Storage::disk('local')->append('innovaphonerequestlog.txt', "prefixed caller check");
                                    Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode(ltrim($phonecall->e164 , (string)CallerPrefix::firstMatchedPrefix($phonecall->e164))));


                                    $tempnumber = ltrim($phonecall->e164 , (string)CallerPrefix::firstMatchedPrefix($phonecall->e164));
                                    if (Caller::where(['number' => $tempnumber])->first() ==  null)
                                    {
                                        Storage::disk('local')->append('innovaphonerequestlog.txt', "prefixed caller not found, create:");
                                        Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($tempnumber));
                                        $caller->number =  $tempnumber;
                                        $savecaller = true;
                                    }


                                }

                            }
                        }

                        if ($savecaller)
                        {
                            if (!$caller->save()) {
                                Storage::disk('local')->append('innovaphonerequestlog.txt', "caller could not be saved! object:");
                                Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($caller));
                                Storage::disk('local')->append('innovaphonerequestlog.txt', "caller could not be saved! raw:");
                                Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($currentdata));
                                error_log("caller could not be saved! object:", TRUE);
                                error_log( print_r($caller), TRUE);
                                error_log("caller could not be saved! raw:", TRUE);
                                error_log( print_r($currentdata), TRUE);
                            }
                        }

                    }





        }




    }
}
