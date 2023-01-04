<?php

namespace App\Helpers;

use App\Models\Url;
use App\Helpers\Genanalytics;
class Redirecter
{
public static function get( $short,$request )
{
    $url = Url::where('gen_code','LIKE',$short)->firstOrFail();
    $ip = $request->ip();
    $userAgent = $request->ip();
    Genanalytics::create($url,$request);
    if ($url->status == 1)
        return $url->org_url;
    else 
        return "/deactivate";
    
    
}
}
