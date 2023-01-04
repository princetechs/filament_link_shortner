<?php

namespace App\Helpers;
use App\Models\Region;
use App\Models\UserAgent;
use Illuminate\Support\Facades\Http;

class Genanalytics
{
public static function create( $url,$request )
{
//   collect the request data and regions 
    $ip = $request->ip();
    $userAgent = $request->ip();
    $url_id=$url->id;

// geting region details using geoplugin api 
    $response = Http::get("http://www.geoplugin.net/php.gp?ip=117.217.49.179");
    $response->throw(); // Throws an HttpException if the request was not successful
    $responseBody = unserialize($response->body()); 

    // Returns the response body as a string
    $country=$responseBody["geoplugin_countryName"];
    $state=$responseBody["geoplugin_region"];
    $city=$responseBody["geoplugin_city"];
    // dd($request->userAgent());
    $userAgent=$request->userAgent();
    $check=self::checkifregionexist($country,$state,$city,$url_id);
    if($check->exists())
    {
        if (preg_match('/Firefox\/([0-9.]+)/', $userAgent, $matches)) {
            $browserName = 'Firefox';
        } elseif (preg_match('/Chrome\/([0-9.]+)/', $userAgent, $matches)) {
            $browserName = 'Chrome';
        } elseif (preg_match('/Safari\/([0-9.]+)/', $userAgent, $matches)) {
            $browserName = 'Safari';
        } else {
            $browserName = 'Other';
        }
        // Extract the operating system name from the user agent string
        if (preg_match('/Windows NT 6.1/', $userAgent)) {
            $osName = 'Windows 7';
        } elseif (preg_match('/Windows NT 10.0/', $userAgent)) {
            $osName = 'Windows 10';
        } elseif (preg_match('/Macintosh/', $userAgent)) {
            $osName = 'Mac';
        } elseif (preg_match('/Linux/', $userAgent)) {
            $osName = 'Linux';
        } else {
            $osName = 'Other';
        }
        $userAgentcheck=UserAgent::where([
            ['browser', $browserName],
            ['device', $osName],
            ['region_id',$check->first()->id]
        ]);
        if ($userAgentcheck->exists())
        {
            $userAgentcheck->get()->first()->increment("counts");
            $userAgentcheck->get()->first()->save();
        } else {
                UserAgent::create(["browser"=>$browserName,"device"=>$osName,"region_id"=>$check->first()->id,"counts"=>"1"]);
               }
    }

    else
    {
         Region::create(["country"=>$country,"state"=>$state,"city"=>$city,"url_id"=>$url_id]) ;   
    }
    
}
public static function checkifregionexist($country,$state,$city,$url_id)
{
    $chechk=Region::where([
        ['country', $country],
        ['state', $state],
        ['city',$city],
        ['url_id',$url_id]
    ]);

        return $chechk;
}
      

}
