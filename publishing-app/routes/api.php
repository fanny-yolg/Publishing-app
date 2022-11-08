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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', 'LoginController@authenticate');
Route::post('/logout', 'LoginController@logout');
Route::post('/user', 'UsersController@store');

Route::group(['middleware' => ['auth']], function () use ($router) {
    $router->group(['prefix'=>'post'], function () use ($router) {
        Route::get('/', 'PostsController@index');
        Route::get('/{with_comments?}', 'PostsController@GetPostList');
        Route::get('/{id}', 'PostsController@show');
        Route::post('/', 'PostsController@store');
        Route::put('/{id}', 'PostsController@update');
        Route::delete('/{id}', 'PostsController@destroy');
    });

    $router->group(['prefix'=>'comment'], function () use ($router) {
        Route::get('/', 'CommentsController@index');
        Route::get('/{id}', 'CommentsController@show');
        Route::post('/', 'CommentsController@store');
        Route::put('/{id}', 'CommentsController@update');
        Route::delete('/{id}', 'CommentsController@destroy');
    });

    $router->group(['prefix'=>'user'], function () use ($router) {
        Route::get('/', 'UsersController@index');
        Route::get('/{id}', 'UsersController@show');
        Route::put('/{id}', 'UsersController@update');
        Route::delete('/{id}', 'UsersController@destroy');
    });
});

