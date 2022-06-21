<?php

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
// Route::post('login','PassportController@login');
// Route::post('register','PassportController@register');
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/v1/register','Api\V1\AuthController@register');
Route::post('/v1/login','Api\V1\AuthController@login');

Route::group(
    [
        'prefix' => 'v1', //For url link
        'namespace' => 'Api\V1', //For Controller  
        'middleware' => 'auth:api'  // config folder => auth => line 44
    ],
    function(){
        Route::get('/profile','AuthController@profile');
        Route::post('/logout','AuthController@logout');
    }
);