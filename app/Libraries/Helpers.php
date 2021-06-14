<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Cache;


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

}
