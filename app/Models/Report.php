<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['cause','startdate', 'enddate', 'status'];

    public function reportPhoneCalls()
    {
        return $this->hasMany('App\Models\ReportPhoneCall');
    }

    public function reportTemplate()
    {
        return $this->belongsTo('App\Models\ReportTemplate');
    }

    public function reportNumberFilterSettings()
    {
        return $this->HasManyThrough('App\Models\ReportNumberFilterSetting' ,'App\Models\ReportPhoneCall');
    }

}
