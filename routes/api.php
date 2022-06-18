<?php

use App\Models\User;
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

// Route::middleware( 'auth:sanctum' )->get( '/user', function () {
//     return User::all();
// } );

Route::group( array( 'middleware' => 'auth:sanctum' ), function () {
    Route::get( 'user', function () {
        return User::all();
    } );
} );

Route::post( 'register', 'AuthController@register' );
Route::post( 'login', 'AuthController@login' );

Route::group( array( 'prefix' => 'category', 'namespace' => 'API', 'middleware' => 'auth:sanctum' ), function () {
    Route::get( 'list', 'ApiController@categoryList' );
    Route::post( 'create', 'ApiController@categoryCreate' );
    Route::post( 'detail', 'ApiController@categoryDetails' );
    Route::get( 'delete/{id}', 'ApiController@categoryDelete' );
    Route::post( 'update', 'ApiController@categoryUpdate' );
} );

Route::group( array( 'middleware' => 'auth:sanctum' ), function () {
    Route::get( 'logout', 'AuthController@logout' );
} );
