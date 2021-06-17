<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportNumberFilterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'priority',
        'direction',
        'filter',
        'cost',
        'cost_multiplier',
        'ignore_on_timereport',
        'ignore_on_costreport',
    ];

    public function reportPhoneCalls()
    {
        return $this->hasMany('App\Models\ReportPhoneCall');
    }
    public function report()
    {
        return $this->hasOneThrough('App\Models\Report','App\Models\ReportPhoneCall');
    }

    public function matchesFilter(int $senderNumber, int $receiverNumber)
    {
        switch($this->direction)
        {
            case 'sender':
                if (preg_match($this->filter, $senderNumber))
                {
                    return true;
                }
                break;
            case 'receiver':
                if (preg_match($this->filter, $receiverNumber))
                {
                    return true;
                }
                break;
        }
        return false;
    }

    public function ignoreOnReport(string $type)
    {
        switch($type)
        {
            case 'cost':
                if ($this->ignore_on_costreport)
                {
                    return true;
                }
                break;
            case 'time':
                if ($this->ignore_on_timereport)
                {
                    return true;
                }
                break;
        }
        return false;
    }


}
