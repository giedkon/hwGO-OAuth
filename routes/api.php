<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\srcdsController;
use App\Http\Controllers\srcdsModelController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);


Route::group(['prefix' => 'server', 'middleware' => 'auth:api'], function() {

    //Route::get('/index', [srcdsModelController::class, 'index']);
    Route::get('/indexUser', [srcdsModelController::class, 'userServers']);
    Route::get('/getServer/{id}', [srcdsModelController::class, 'server']);
    Route::post('/create', [srcdsModelController::class, 'create']);
    Route::post('/update', [srcdsModelController::class, 'update']);
    Route::delete('/destroy/{id}', [srcdsModelController::class, 'destroy']);

    Route::post('/ping', [srcdsController::class, 'pingServer']);
    Route::post('/check', [srcdsController::class, 'checkAvailability']);
});
