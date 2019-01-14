<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['namespace' => 'ApiAuth'] , function() {

    Route::post('/signup' , 'ApiAuthController@sign_up');
    Route::post('/login' , 'AccessTokenController@issueToken');
    Route::post('/logout' , 'ApiAuthController@logout');
    Route::get('/user-details' , 'ApiAuthController@user_details');
});

Route::post('/search-hotels' , 'HotelServicesController@search_hotels');
Route::post('/password/email' , 'Auth\ForgotPasswordController@sendResetLinkEmail');