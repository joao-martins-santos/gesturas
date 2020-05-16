<?php
Route::prefix('vet')->name('vet.')->namespace('Vet')->group(function () {
    Auth::routes();
    Route::middleware('auth:vet')->group(function () {
        Route::get('home', 'HomeController@index')->name('home');

        Route::get('service/consult/users', 'ServiceController@userIndex');
        Route::get('service/consult/users-list', 'ServiceController@usersList');
        
        Route::get('service/consult/pet-user-cod/{codigo}', 'ServiceController@petUserCod'); 
        Route::get('service/monitoring/chats-temp/{id}/{dt_ini}/{dt_fim}', 'MonitoringController@graficoTemperatura');


        ///////////////////////////////////// Services

        // Consult
        Route::get('service/consult', 'ConsultController@index')->name('consult.index');
        Route::get('service/consult/new', 'ConsultController@new')->name('consult.new');
        Route::post('service/consult/store', 'ConsultController@store')->name('consult.store');
        Route::get('service/consult/print/{id}', 'ConsultController@print')->name('consult.print');

        // Monitoring
        Route::get('service/monitoring', 'MonitoringController@index')->name('monitoring.index');
        Route::get('service/monitoring/details/{id}/{dt_ini?}/{dt_fim?}', 'MonitoringController@details')->name('monitoring.details');
        Route::get('service/monitoring/card/{id}/{dt_ini?}/{dt_fim?}', 'MonitoringController@card')->name('monitoring.card');
        Route::get('service/monitoring/history/{id}/{dt_ini?}/{dt_fim?}', 'MonitoringController@history')->name('monitoring.history');

        // Exams
        Route::get('service/exams', 'ExamsController@index')->name('exams.index');
        Route::get('service/exams/new', 'ExamsController@new')->name('exams.new');
        Route::post('service/exams/store', 'ExamsController@store')->name('exams.store');
        Route::get('service/exams/print/{id}', 'ExamsController@print')->name('exams.print');

        // Shower
        Route::get('service/shower', 'ShowerController@index')->name('shower.index');
        Route::get('service/shower/new', 'ShowerController@new')->name('shower.new');
        Route::post('service/shower/store', 'ShowerController@store')->name('shower.store');
        Route::get('service/shower/print/{id}', 'ShowerController@print')->name('shower.print');

        Route::get('another', 'AnotherController@index')->name('another');
    });
});