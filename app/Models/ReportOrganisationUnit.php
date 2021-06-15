<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportOrganisationUnit extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function reportCallers()
    {
        return $this->hasMany('App\Models\ReportCaller');
    }

}
