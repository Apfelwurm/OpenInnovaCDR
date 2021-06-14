<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCallEvent extends Model
{
    use HasFactory;

    protected $fillable = ['msg', 'time', 'type', 'e164', 'root', 'h323', 'conf', 'cause', 'more',];


    public function phoneCall()
    {
        return $this->belongsTo('App\Models\PhoneCall');
    }



}
