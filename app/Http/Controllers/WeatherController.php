<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $wheatherKey = env('WEATHER_KEY');

        return Http::get("https://api.hgbrasil.com/weather?key={$wheatherKey}&user_ip=remote");
    }
}
