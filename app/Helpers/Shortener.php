<?php

namespace App\Helpers;



class Shortener
{

    protected static string $chars = "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789";

  

    public static function generateRandomString(int $length): string
    {
        
        $sets = explode('|', self::$chars);
        $all = '';
        $randString = '';
        foreach ($sets as $set) {
            $randString .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $randString .= $all[array_rand($all)];
        }
        return str_shuffle($randString);
    }

    public static function fullurl(int $length)
    {
        $short_code=self::generateRandomString($length);
        return "http://127.0.0.1:8000/".$short_code;
    }
    
}
