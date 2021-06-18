<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallerPrefix extends Model
{
    use HasFactory;
    protected $fillable = ['prefix'];

    public static function matchesAnyPrefix(string $number)
    {
        $prefixes = self::all();
        foreach ($prefixes as $prefix)
        {
            if (str_starts_with($number, $prefix->prefix))
            {
                return true;
            }
        }
        return false;


    }

    public static function firstMatchedPrefix(string $number)
    {
        $prefixes = self::orderByDesc("prefix");
        $matchedprefixes = collect();
        foreach ($prefixes as $prefix)
        {
            if (str_starts_with($number, $prefix->prefix))
            {
                return $prefix->prefix;
            }
        }

        return false;

    }

    public static function getPrefixedNumber(string $number)
    {
        $prefixes = self::all();
        $prefixedNumbers = collect();
        foreach ($prefixes as $prefix)
        {
                $prefixedNumbers->add("$prefix->prefix" . $number);
        }
        return $prefixedNumbers;

    }
}
