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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['cors', 'json.response']], function () {

    // public routes
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login');
    Route::post('/register', 'Auth\ApiAuthController@register')->name('register');

    //auth route
    Route::middleware('auth:api')->group(function () {
        // our routes to be protected will go in here
        Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout');

        // user access control -- Admin route
        Route::middleware('api.admin')->group(function () {
            // Clients route
            Route::get('/client', 'HrmClientController@index')->name('client.index');
            Route::post('/client/create', 'HrmClientController@store')->name('client.store');
            Route::get('/client/show/{id}', 'HrmClientController@show')->name('client.show');
            Route::post('/client/update/{id}', 'HrmClientController@update')->name('client.update');
            Route::delete('/client/delete/{id}', 'HrmClientController@destroy')->name('client.delete');

            //project route
            Route::get('/project/client', 'ProjectContactController@project_client')->name('project.client');
            Route::post('/project/create', 'ProjectContactController@store')->name('project.store');
              Route::get('/project/show/{id}', 'ProjectContactController@show')->name('project.show');
              Route::post('/project/update/{id}', 'ProjectContactController@update')->name('project.update');
            Route::delete('/project/delete/{id}', 'ProjectContactController@destroy')->name('project.delete');

            //Project Permission
            Route::get('/project-permission/kam', 'ProjectPermissionController@get_kam')->name('project.permission.kam');
            Route::post('/project-permission', 'ProjectPermissionController@index')->name('project.permission.index');
            Route::post('/project-permission/create', 'ProjectPermissionController@store')->name('project.permission.create');
            Route::post('/project-permission/update', 'ProjectPermissionController@update')->name('project.permission.update');

        });

        // user access control -- Admin and KAM route
        Route::middleware('api.admin.kam')->group(function () {

            //project route
            Route::get('/project', 'ProjectContactController@index')->name('project.index');
            Route::get('/project/show/{id}', 'ProjectContactController@show')->name('project.show');
            Route::post('/project/update/{id}', 'ProjectContactController@update')->name('project.update');

        });

    });
});
