<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caller extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'number'];

    public function organisationUnit()
    {
        return $this->belongsTo('App\Models\OrganisationUnit');
    }

    public static function getUnassignedPaginated()
    {
        return self::where('organisation_unit_id', null)->paginate(20);
    }

    public static function getAssignedPaginated(OrganisationUnit $organisationUnit)
    {
        return self::where('organisation_unit_id', $organisationUnit->id)->paginate(20);
    }



}
