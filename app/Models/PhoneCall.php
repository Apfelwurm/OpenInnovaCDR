<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCall extends Model
{
    use HasFactory;
    protected $fillable = ['guid','sys', 'pbx', 'node', 'cn', 'e164', 'h323', 'device','dir', 'utc', 'local'];

    public function phoneCallEvents()
    {
        return $this->hasMany('App\Models\PhoneCallEvent');
    }


}
