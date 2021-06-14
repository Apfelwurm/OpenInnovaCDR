<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'setting',
        'value',
        'default',
    ];


    /**
     * Is App Installed
     * @return Boolean
     */
    public static function isInstalled()
    {
        return self::where('setting', 'installed')->first()->value;
    }

    /**
     * Set App as Installed
     * @return Boolean
     */
    public static function setInstalled()
    {
        if (!$setting = self::where('setting', 'installed')->first()) {
            return false;
        }
        $setting->value = true;
        if (!$setting->save()) {
            return false;
        }
        return true;
    }


}
