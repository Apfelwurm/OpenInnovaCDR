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
        return $this->belongsTo('App\OrganisationUnit');
    }

}
