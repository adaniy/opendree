<?php
Route::get('/', function() {
    return view('main');
});

/**
 * Routes
 * 
 * Module Reunion
 */
Route::get('axios/reunion/get/{page}', 'ReunionController@get');