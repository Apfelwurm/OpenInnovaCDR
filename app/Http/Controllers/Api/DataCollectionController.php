<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataCollectionController extends Controller
{
    public function innovaphone(Request $request)
    {


        if (!Storage::disk('local')->exists('innovaphonerequestlog.txt')) {

            Storage::disk('local')->put('innovaphonerequestlog.txt', json_encode($request->all()));

        }
        else
        {
            Storage::disk('local')->append('innovaphonerequestlog.txt', json_encode($request->all()));

        }

    }
}
