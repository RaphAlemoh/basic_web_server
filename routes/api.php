<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/hello', function (Request $request) {

    $visitor_name = $request->query('visitor_name', 'Alemsbaja');
    $client_ip = $request->ip();

    $ip_info = Http::get("http://ipinfo.io/{$client_ip}?token=" . env('IP_INFO_TOKEN'));
    $ip_info_response = json_decode($ip_info->getBody(), true);
    $city = $ip_info_response['city'] ?? 'Unknown';
    $loc = explode(',', $ip_info_response['loc']);

    $weather_info = Http::get("https://api.openweathermap.org/data/2.5/weather?lat={$loc[0]}&lon={$loc[1]}&appid=".env('WEATHER_API_TOKEN'));
    $weather_info_response = json_decode($weather_info->getBody(), true);
    $temperature = $weather_info_response['main']['temp'] ?? 'N/A';

    return response()->json([
        'client_ip' => $client_ip,
        'location' => $city,
        'greeting' => "Hello, $visitor_name!, the temperature is $temperature degrees Celsius in $city"
    ]);
});
