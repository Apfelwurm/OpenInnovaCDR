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
}
