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

use \Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function () {
    $data = \App\Category::with('authors')->find(13);
    return response()->json(['data' => $data]);
});

Route::prefix('auth/')->namespace('API')->group(function () {
    Route::post('register', 'UserApiAuthController@register');
    Route::post('login', 'UserApiAuthController@login');
    Route::post('forget-password', 'UserApiAuthController@requestPasswordReset');
    Route::post('reset-password', 'UserApiAuthController@resetPassword');
});

Route::prefix('auth/')->namespace('API')->middleware('auth:user_api')->group(function () {
    Route::put('update', 'UserApiAuthController@update');

    Route::get('logout', 'AuthBaseController@logout');
});

Route::prefix('/')->namespace('API')->middleware('auth:user_api')->group(function () {
    Route::apiResource('categories','CategoryController');
    Route::get('categories/{id}/articles','CategoryController@showCategoryArticles');
});
