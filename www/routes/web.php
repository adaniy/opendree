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

/*
--------> Sécurisation des routes
*/

Route::pattern('id', '[0-9]+');

/*
--------> Index
*/

Route::get('/', function() {
	return view('index');
});

Route::get("test", function() {
    return view('test');
});

Route::get("login", function() {
    return view('login');
});
/*
--------> Gestion des actions
*/

// Index
Route::get("action","ActionController@index");

// Getter/Setter
Route::post("action/ajout","ActionController@postAction");
// ------------------------------ \\
Route::get("action/modifier/{id}","ActionController@getEditAction");
Route::post("action/modifier/{id}","ActionController@postEditAction");
// ------------------------------ \\
Route::get("action/supprimer/{id}","ActionController@deleteAction");

/*
--------> Gestion des réunions
*/

// Index
Route::get("reunion","ReunionController@index");
Route::post("reunion","ReunionController@postRecherche");

Route::get("reunion/{id}","ReunionController@access");
Route::get("reunion/print/{id}","ReunionController@printable");

// Getter/Setter
Route::get("reunion/ajout","ReunionController@getReunion");
Route::post("reunion/ajout","ReunionController@postReunion");

Route::get("reunion/modifier/{id}","ReunionController@getEditReunion");
Route::post("reunion/modifier/{id}","ReunionController@postEditReunion");

Route::get("reunion/supprimer/{id}","ReunionController@deleteReunion");
// ------------------------------ \\
Route::get("reunion/ajout/sujet/{id}","ReunionController@getReunionSujet");
Route::post("reunion/ajout/sujet/{id}","ReunionController@postReunionSujet");

Route::get("reunion/modifier/sujet/{id}","ReunionController@getEditReunionSujet");
Route::post("reunion/modifier/sujet/{id}","ReunionController@postEditReunionSujet");
Route::get("reunion/supprimer/sujet/{id}","ReunionController@deleteReunionSujet");
// ------------------------------ \\
Route::get("reunion/participant/supprimer/{id}","ReunionController@deleteReunionParticipant");
Route::post("reunion/{id}","ReunionController@postReunionParticipant");

/*
--------> Gestion des élections
*/

// Index
Route::get("election","ElectionController@index");
Route::get("election/printable","ElectionController@printable");
Route::post("election","ElectionController@insert");

// Données brutes
Route::get("election/brut","ElectionController@indexBrut");
Route::post("election/brut","ElectionController@rechercheBrut");
Route::get("election/brut/supprimer/{id}","ElectionController@supprimer");