<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'output_format', 'schedule', 'startdate', 'timespan'];

    public function reports()
    {
        return $this->hasMany('App\Models\Report');

    }


    /**
     * Get types for Select
     * @return array
     */
    public static function getAvailableTypes()
    {
        $typesArray = [
            "time",
            "cost",
        ];
        return $typesArray;
    }

    /**
     * Get output_formats for Select
     * @return array
     */
    public static function getAvailableOutputFormats()
    {
        $outputFormatsArray = [
            "PDF",
        ];
        return $outputFormatsArray;
    }

    /**
     * Get schedules for Select
     * @return array
     */
    public static function getAvailableSchedules()
    {
        $schedulesArray = [
            "disabled",
            "monthly",
            "weekly",
            "daily",
            "once",
        ];
        return $schedulesArray;
    }

    /**
     * Get timespans for Select
     * @return array
     */
    public static function getAvailableTimespans()
    {
        $timespansArray = [
            "last month",
            "one month back from now",
            "current month",
            "one week back from now",
            "last week",
            "current week",
            "one day back from now",
            "yesterday",
            "today",
        ];
        return $timespansArray;
    }





}
