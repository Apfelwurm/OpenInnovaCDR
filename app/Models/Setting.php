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
        'type',
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



    /**
     * Is automatic_caller_creation Enabled
     * @return Boolean
     */
    public static function isAutomaticCallerCreationEnabled()
    {
        return self::where('setting', 'automatic_caller_creation')->first()->value;
    }

    /**
     * Enable automatic_caller_creation
     * @return Boolean
     */
    public static function enableAutomaticCallerCreation()
    {
        if (!$AutomaticCallerCreationEnabled = self::where('setting', 'automatic_caller_creation')->first()) {
            return false;
        }
        $AutomaticCallerCreationEnabled->value = true;
        if (!$AutomaticCallerCreationEnabled->save()) {
            return false;
        }
        return true;
    }

    /**
     * Disable automatic_caller_creation
     * @return Boolean
     */
    public static function disableAutomaticCallerCreation()
    {
        if (!$AutomaticCallerCreationEnabled = self::where('setting', 'automatic_caller_creation')->first()) {
            return false;
        }
        $AutomaticCallerCreationEnabled->value = false;
        if (!$AutomaticCallerCreationEnabled->save()) {
            return false;
        }
        return true;
    }


    /**
     * Is automatic_caller_update Enabled
     * @return Boolean
     */
    public static function isAutomaticCallerUpdateEnabled()
    {
        return self::where('setting', 'automatic_caller_update')->first()->value;
    }

    /**
     * Enable automatic_caller_update
     * @return Boolean
     */
    public static function enableAutomaticCallerUpdate()
    {
        if (!$AutomaticCallerUpdateEnabled = self::where('setting', 'automatic_caller_update')->first()) {
            return false;
        }
        $AutomaticCallerUpdateEnabled->value = true;
        if (!$AutomaticCallerUpdateEnabled->save()) {
            return false;
        }
        return true;
    }

    /**
     * Disable automatic_caller_update
     * @return Boolean
     */
    public static function disableAutomaticCallerUpdate()
    {
        if (!$AutomaticCallerUpdateEnabled = self::where('setting', 'automatic_caller_update')->first()) {
            return false;
        }
        $AutomaticCallerUpdateEnabled->value = false;
        if (!$AutomaticCallerUpdateEnabled->save()) {
            return false;
        }
        return true;
    }


}
