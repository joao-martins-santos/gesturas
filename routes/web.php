<?php

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

require 'auth/user.php';
require 'auth/vet.php';
require 'auth/shop.php';


Route::get('/', function () {
    return view('welcome');
});

/*
Auth::routes();

Route::resource('/admin/pets', 'PetController')->middleware('auth');

// PET SHOPs
Route::get('products','ProductController@index');
Route::post('products','ProductController@store');
Route::get('products/{product}','ProductController@show');
Route::get('products/{product}/edit','ProductController@edit');
Route::patch('products/{product}','ProductController@update');
Route::delete('products/{product}','ProductController@destroy');

Auth::routes();

Route::get('/admin/home', 'HomeController@index')->name('home');

Route::get('/admin/shop/home', 'ProductController@index');

// Datatables
Route::get('my-datatables', 'MyDatatablesController@index');
Route::get('get-data-my-datatables', ['as'=>'get.data','uses'=>'MyDatatablesController@getData']);

Route::resource('my-datatables', 'PermissaoController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/