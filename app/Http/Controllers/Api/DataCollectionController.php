<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

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

            if (!Storage::disk('local')->exists('innovaphonerequestlog.txt')) {

                Storage::disk('local')->put('innovaphonerequestlog.txt', "hallo");

            }
            else
            {
                Storage::disk('local')->append('innovaphonerequestlog.txt', serialize($currentdata));


            }
            error_log( print_r($currentdata["@attributes"], TRUE) );
        }




    }
}
