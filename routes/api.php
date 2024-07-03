<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/hello', function (Request $request) {

    $visitor_name = $request->query('visitor_name', 'Alemsbaja');
    $client_ip = $request->ip();

    $ip_info = Http::get("http://ipinfo.io/102.91.92.231?token=" . env('IP_INFO_TOKEN'));
    $location = $ip_info->json()['city'];
    $temperature = 11;
    return response()->json([
        'client_ip' => $client_ip,
        'location' => $location,
        'greeting' => "Hello, $visitor_name!, the temperature is $temperature degrees Celsius in $location"
    ]);
});
