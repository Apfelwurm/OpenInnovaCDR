<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCaller extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'number'];

    public function reportOrganisationUnit()
    {
        return $this->belongsTo('App\Models\ReportOrganisationUnit');
    }

    public function reportPhoneCall()
    {
        return $this->hasOne('App\Models\ReportPhoneCall');
    }
}
