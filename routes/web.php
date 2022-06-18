<?php

use App\Http\Middleware\AdminCheckMiddleware;
use App\Http\Middleware\UserCheckMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get( '/', function () {
    return view( 'welcome' );
} );

Route::middleware( array( 'auth:sanctum', 'verified' ) )->get( '/dashboard', function () {

    if ( Auth::check() ) {

        if ( Auth::user()->role == 'admin' ) {
            return redirect()->route( 'admin#profile' );
        } elseif ( Auth::user()->role == 'user' ) {
            return redirect()->route( 'user#index' );
        }

    }

} )->name( 'dashboard' );

Route::group( array( 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => array( AdminCheckMiddleware::class ) ), function () {
    Route::get( 'profile', 'AdminController@profile' )->name( 'admin#profile' );
    Route::post( 'updateAdminProfile/{id}', 'AdminController@updateAdminProfile' )->name( 'admin#updateProfile' );
    Route::get( 'changePasswordPage', 'AdminController@changePasswordPage' )->name( 'admin#changePasswordPage' );
    Route::post( 'changePassword/{id}', 'AdminController@changePassword' )->name( 'admin#changePassword' );

    Route::get( 'category', 'CategoryController@category' )->name( 'admin#category' );
    Route::get( 'addCategory', 'CategoryController@addCategory' )->name( 'admin#addCategory' );
    Route::post( 'createCategory', 'CategoryController@createCategory' )->name( 'admin#createCategory' );
    Route::get( 'deleteCategory/{id}', 'CategoryController@deleteCategory' )->name( 'admin#deleteCategory' );
    Route::get( 'editCategory/{id}', 'CategoryController@editCategory' )->name( 'admin#editCategory' );
    Route::post( 'updateCategory', 'CategoryController@updateCategory' )->name( 'admin#updateCategory' );
    Route::get( 'categorySearch', 'CategoryController@searchData' )->name( 'admin#searchData' );
    Route::get( 'categoryItem/{id}', 'CategoryController@categroyItem' )->name( 'admin#categoryItem' );
    Route::get( 'categoryDownload', 'CategoryController@downloadCategory' )->name( 'admin#downloadCategory' );

    Route::get( 'pizzaList', 'PizzaController@pizzaList' )->name( 'admin#pizzaList' );
    Route::get( 'createPizza', 'PizzaController@createPizza' )->name( 'admin#createPizza' );
    Route::post( 'insertPizza', 'PizzaController@insertPizza' )->name( 'admin#insertPizza' );
    Route::get( 'deletePizza/{id}', 'PizzaController@deletePizza' )->name( 'admin#deletePizza' );
    Route::get( 'infoPizza/{id}', 'PizzaController@infoPizza' )->name( 'admin#infoPizza' );
    Route::get( 'editPizza/{id}', 'PizzaController@editPizza' )->name( 'admin#editPizza' );
    Route::post( 'updatePizza/{id}', 'PizzaController@updatePizza' )->name( 'admin#updatePizza' );
    Route::get( 'searchPizza', 'PizzaController@searchData' )->name( 'admin#searchPizza' );
    Route::get( 'PizzaDownload', 'PizzaController@downloadPizzaList' )->name( 'admin#downloadPizza' );

    Route::get( 'userList', 'UsersController@userList' )->name( 'admin#userList' );
    Route::get( 'userList/search', 'UsersController@userSearch' )->name( 'admin#userListSearch' );
    Route::get( 'deleteUser/{id}', 'UsersController@deleteUserAndAdmin' )->name( 'admin#deleteUserAndAdmin' );
    Route::get( 'adminList', 'UsersController@adminList' )->name( 'admin#adminList' );
    Route::get( 'adminList/search', 'UsersController@adminSearch' )->name( 'admin#adminListSearch' );

    Route::get( 'orderList', 'OrderController@orderList' )->name( 'admin#orderList' );
    Route::get( 'searchOrder', 'OrderController@orderSearch' )->name( 'admin#searchOrder' );

    Route::get( 'userContact', 'ContactController@contactList' )->name( 'admin#contactList' );
    Route::get( 'contactSearch', 'ContactController@contactSearch' )->name( 'admin#contactSearch' );
} );

Route::group( array( 'prefix' => 'user', 'middleware' => array( UserCheckMiddleware::class ) ), function () {
    Route::get( '/', 'UserController@index' )->name( 'user#index' );

    Route::get( 'pizza/details/{id}', 'UserController@pizzaDetails' )->name( 'user#pizzaDetails' );
    Route::get( 'pizza/category/{id}', 'UserController@pizzaCategory' )->name( 'user#pizzaCategory' );
    Route::get( 'pizza/serach', 'UserController@pizzaSearh' )->name( 'user#pizzaSearch' );

    Route::get( 'pizza/item/search', 'UserController@pizzaItemSearch' )->name( 'user#pizzaItemSearch' );

    Route::get( 'pizza/order', 'UserController@order' )->name( 'user#order' );
    Route::post( 'pizza/order', 'UserController@placeOrder' )->name( 'user#placeOrder' );

    Route::post( 'contact', 'Admin\ContactController@createContact' )->name( 'user#createContact' );
} );
