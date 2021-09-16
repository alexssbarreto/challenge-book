<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->apiResource('/books', BookController::class);

Route::post('login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);
Route::middleware('auth:sanctum')->get('me', [UserController::class, 'me']);

Route::get('weather', [WeatherController::class, 'index']);
