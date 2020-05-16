<?php
Route::prefix('shop')->name('shop.')->namespace('Shop')->group(function () {
    Auth::routes();
    Route::middleware('auth:shop')->group(function () {
        Route::get('home', 'HomeController@index')->name('home');

        Route::get('product', 'ProductController@index')->name('product.index');
        Route::get('product/all', 'ProductController@all')->name('product.all');
        Route::get('product/show/{id}', 'ProductController@show')->name('product.show');
        Route::delete('product/{id}', 'ProductController@destroy')->name('product.destroy');
        Route::get('product/create', 'ProductController@create')->name('product.create');
        Route::post('product', 'ProductController@store')->name('product.store');
        Route::put('product/{id}', 'ProductController@update')->name('product.update');

        Route::get('another', 'AnotherController@index')->name('another');

        Route::get('ration', 'ProductController@allRation')->name('ration.index');
        Route::get('medicine', 'ProductController@allMedicine')->name('medicine.index');
    });
});
