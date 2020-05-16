<?php

Route::prefix('user')->name('user.')->namespace('User')->group(function () {
    Auth::routes();
    Route::middleware('auth:user')->group(function () {
        Route::get('home', 'HomeController@index')->name('home');
        Route::get('another', 'AnotherController@index')->name('another');

        //Transport
        Route::get('transport', 'TransportController@index')->name('transport.index');
        Route::post('transport/save', 'TransportController@save')->name('transport.save');
        Route::get('transport/edit/{id}', 'TransportController@edit')->name('transport.edit');
        Route::get('transport/showfile', 'TransportController@showfile')->name('transport.showfile');
        Route::delete('transport/delete/{id}', 'TransportController@delete')->name('transport.delete');

        // Ramal
        Route::get('ramal', 'RamalController@index')->name('ramal.index');
        Route::post('ramal/save', 'RamalController@save')->name('ramal.save');
        Route::get('ramal/edit/{id}', 'RamalController@edit')->name('ramal.edit');
        Route::get('ramal/print/{id}', 'RamalController@print')->name('ramal.print');

        // Tronco
        Route::get('tronco', 'TroncoController@index')->name('tronco.index');
        Route::post('tronco/save', 'TroncoController@save')->name('tronco.save');
        Route::get('tronco/edit/{id}', 'TroncoController@edit')->name('tronco.edit');
        Route::get('tronco/show/{id}', 'TroncoController@show')->name('tronco.show');
        Route::get('tronco/validator/{id}', 'TroncoController@validator')->name('tronco.validator');
        Route::delete('tronco/delete/{id}', 'TroncoController@delete')->name('tronco.delete');



        //Aors
        Route::get('aor', 'AorController@index')->name('aor.index');
        Route::post('aor/save', 'AorController@save')->name('aor.save');
        Route::get('aor/edit/{id}', 'AorController@edit')->name('aor.edit');
        Route::get('aor/showfile', 'AorController@showfile')->name('aor.showfile');
        Route::delete('aor/delete/{id}', 'AorController@delete')->name('aor.delete');

        // Endpoints
        Route::get('endpoint', 'EndpointController@index')->name('endpoint.index');
        Route::post('endpoint/save', 'EndpointController@save')->name('endpoint.save');
        Route::get('endpoint/edit/{id}', 'EndpointController@edit')->name('endpoint.edit');
        Route::get('endpoint/showfile', 'EndpointController@showfile')->name('endpoint.showfile');
        Route::delete('endpoint/delete/{id}', 'EndpointController@delete')->name('endpoint.delete');
        
        // Registrations
        Route::get('registration', 'RegistrationController@index')->name('registration.index');
        Route::post('registration/save', 'RegistrationController@save')->name('registration.save');
        Route::get('registration/edit/{id}', 'RegistrationController@edit')->name('registration.edit');
        Route::get('registration/showfile', 'RegistrationController@showfile')->name('registration.showfile');
        Route::delete('registration/delete/{id}', 'RegistrationController@delete')->name('registration.delete');

        //Serviços
        Route::get('service/contact', 'ServiceController@contact')->name('service.contact');
        Route::get('service/monitor', 'ServiceController@monitor')->name('service.monitor');

        // Ramal
        Route::get('ramal', 'RamalController@index')->name('ramal.index');
        Route::post('ramal/save', 'RamalController@save')->name('ramal.save');
        Route::get('ramal/edit/{id}', 'RamalController@edit')->name('ramal.edit');
        Route::get('ramal/print/{id}', 'RamalController@print')->name('ramal.print');

        // Trunk
        Route::get('trunk', 'TrunkController@index')->name('trunk.index');
        Route::post('trunk/save', 'TrunkController@save')->name('trunk.save');
        Route::get('trunk/edit/{id}', 'TrunkController@edit')->name('trunk.edit');
        Route::get('trunk/showfile', 'TrunkController@showfile')->name('trunk.showfile');
        Route::delete('trunk/delete/{id}', 'TrunkController@delete')->name('trunk.delete');

        // Route 
        Route::get('route', 'RouteController@index')->name('route.index');
        Route::get('route/new', 'RouteController@new')->name('route.new');
        Route::post('route/store', 'RouteController@store')->name('route.store');
        Route::get('route/print/{id}', 'RouteController@print')->name('route.print');

    });
});