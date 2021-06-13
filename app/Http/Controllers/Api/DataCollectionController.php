<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PhoneCall;
use App\Models\PhoneCallEvent;
use Throwable;
use Illuminate\Support\Facades\Log;

class DataCollectionController extends Controller
{
    public function innovaphone(Request $request)
    {

        $data = implode("", $request->all());

        $xml = simplexml_load_string($data);

        if ( $xml != false)
        {
            $json = json_encode($xml);
            $currentdata = json_decode($json, true);

            // error_log( print("beeee"), TRUE);
            // error_log( "beeee", TRUE);

            // error_log( print_r($currentdata["@attributes"]));
            Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($currentdata["@attributes"]));
            Storage::disk('local')->append('innovaphonerequestlog.txt', $currentdata["@attributes"]["guid"]);

            // error_log( print_r($currentdata["@attributes"]["guid"]), TRUE);
            // error_log( print_r($currentdata["@attributes"]["sys"]), TRUE);
            // error_log( print_r($currentdata["@attributes"]["pbx"]), TRUE);
            // error_log( print_r($currentdata["@attributes"]["node"]), TRUE);
            // error_log( print_r($currentdata["@attributes"]["cn"]), TRUE);
            // error_log( print_r($currentdata["@attributes"]["e164"]), TRUE);
            // error_log( print_r($currentdata["@attributes"]["h323"]), TRUE);
            // error_log( print_r($currentdata["@attributes"]["device"]), TRUE);
            // error_log( print_r($currentdata["@attributes"]["dir"]), TRUE);
            // error_log( print_r($currentdata["@attributes"]["utc"]), TRUE);
            // error_log( print_r($currentdata["@attributes"]["local"]), TRUE);

            // $phonecall = new PhoneCall();
            // $phonecall->guid = $currentdata["@attributes"]["guid"];
            // $phonecall->sys = $currentdata["@attributes"]["sys"];
            // $phonecall->pbx = $currentdata["@attributes"]["pbx"];
            // $phonecall->node = $currentdata["@attributes"]["node"];
            // $phonecall->cn = $currentdata["@attributes"]["cn"];
            // $phonecall->e164 = $currentdata["@attributes"]["e164"];
            // $phonecall->h323 = $currentdata["@attributes"]["h323"];
            // $phonecall->device = $currentdata["@attributes"]["device"];
            // $phonecall->dir = $currentdata["@attributes"]["dir"];
            // $phonecall->utc = $currentdata["@attributes"]["utc"];
            // $phonecall->local = $currentdata["@attributes"]["local"];

            // if (!$phonecall->save()) {
            //     error_log("phonecall could not be saved! object:", TRUE);
            //     error_log( print_r($phonecall), TRUE);
            //     error_log("phonecall could not be saved! raw:", TRUE);
            //     error_log( print_r($currentdata), TRUE);
            // }

            // if (!Storage::disk('local')->exists('innovaphonerequestlog.txt')) {

            //     Storage::disk('local')->put('innovaphonerequestlog.txt', "hallo");

            // }
            // else
            // {
            //     Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($currentdata));


            // }
        }




    }
}
