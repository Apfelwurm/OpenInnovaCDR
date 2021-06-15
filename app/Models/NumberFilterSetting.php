<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class NumberFilterSetting extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'priority',
        'direction',
        'filter',
        'cost',
        'cost_multiplier',
        'ignore_on_timereport',
        'ignore_on_costreport',
    ];


    /**
     * Get priority for Select
     * @return array
     */
    public static function getNextPriority()
    {
        $priorityemptyArray = [];

        for ($i = 1; $i <= NumberFilterSetting::max('priority'); $i++) {
            if (NumberFilterSetting::where('priority', $i)->count() === 0)
            {
                array_push($priorityemptyArray,$i);
            }
        }

        if (count($priorityemptyArray) > 0)
        {
            return min($priorityemptyArray);
        }

        if (NumberFilterSetting::max('priority') > 0)
        {
            return NumberFilterSetting::max('priority') + 1;
        }
        else
        {
            return 1;
        }
    }

     /**
     * Get priorities for Select
     * @return array
     */
    public static function getNextPriorities()
    {
        $priorityemptyArray = [];

        for ($i = 1; $i <= NumberFilterSetting::max('priority'); $i++) {
            if (NumberFilterSetting::where('priority', $i)->count() === 0)
            {
                array_push($priorityemptyArray,$i);
            }
         }


        if (NumberFilterSetting::max('priority') > 0)
        {
            $priorityArray = [
                NumberFilterSetting::max('priority') + 1,
            ];
            for ($i = 1; $i <= 19; $i++) {
                $id = NumberFilterSetting::max('priority') + 1 + $i;
             array_push($priorityArray,$id);
             }
        }
        else
        {
            $priorityArray = [
                1,
            ];
            for ($i = 1; $i <= 19; $i++) {
                $id = 1 + $i;
             array_push($priorityArray,$id);
             }
        }




        return array_merge($priorityemptyArray,$priorityArray);
    }

    /**
     * Get priorities plus own for Select
     * @return array
     */
    public static function getNextPrioritiesAndOwn(NumberFilterSetting $numberFilterSetting)
    {
            $priorityemptyArray = [];

            for ($i = 1; $i <= NumberFilterSetting::max('priority'); $i++) {
                if (NumberFilterSetting::where('priority', $i)->count() === 0)
                {
                    array_push($priorityemptyArray,$i);
                }
            }

            $priorityArray = [
                $numberFilterSetting->priority,
                NumberFilterSetting::max('priority') + 1,
            ];
            for ($i = 1; $i <= 19; $i++) {
                $id = NumberFilterSetting::max('priority') + 1 + $i;
             array_push($priorityArray,$id);
             }



            return array_merge($priorityemptyArray,$priorityArray);

    }

     /**
     * Get directions for Select
     * @return array
     */
    public static function getAvailableDirections()
    {
        $directionsArray = [
            "receiver",
            "sender",
        ];
        return $directionsArray;
    }



     /**
     * Get cost_multiplier for Select
     * @return array
     */
    public static function getAvailableCostMultipliers()
    {
        $costMultipliersArray = [
            "minute",
            "second",
        ];
        return $costMultipliersArray;
    }



}
