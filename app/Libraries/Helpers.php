<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Cache;
use App\Models\Report;

class Helpers
{

    /**
     * Get CSS Version Number for Cache Busting
     * @return integer
     */
    public static function getCssVersion()
    {
        return Cache::get("css_version", function () {
            $int = random_int(1, 999);
            Cache::forever("css_version", $int);
            return $int;
        });
    }

     /**
     * Check if any Report is running
     * @return integer
     */
    public static function isReportRunning()
    {

        if (Report::where('status', 'running')->count() > 0)
        {
            return true;
        }
        return false;
    }





}
