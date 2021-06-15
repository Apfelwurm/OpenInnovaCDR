<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPhoneCall extends Model
{
    use HasFactory;
    protected $fillable = ['time', 'receiver'];

    public function reportNumberFilterSetting()
    {
        return $this->belongsTo('App\Models\ReportNumberFilterSetting');
    }
    public function reportCaller()
    {
        return $this->belongsTo('App\Models\ReportCaller');
    }
    public function report()
    {
        return $this->belongsTo('App\Models\Report');

    }

}
