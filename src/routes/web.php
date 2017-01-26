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

Route::get("action", "ActionController@index");
Route::get("action/{id}", "ActionController@getAction");

Route::get("budget", "BudgetController@index");

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

// refonte du frontend
// Ajax - get
Route::get("action/stats", "ActionController@stats");
Route::get("action/get/jour-restant", "ActionController@getJourRestant");
Route::get("action/alerte", "ActionController@getAlert");
Route::get("action/alerte/{id}", "ActionController@actionAlert");
Route::get("action/delete/{id}", "ActionController@delete");

Route::get("budget/add/{id}/{year}", "BudgetController@add");
Route::get("budget/add/year/{year}", "BudgetController@addYear");
Route::get("budget/delete/{id}", "BudgetController@delete");
Route::get("budget/delete/year/{year}", "BudgetController@deleteYear");
Route::get("budget/total/{id}", "BudgetController@getTotal");
Route::get("budget/depense/{id}", "BudgetController@getDepense");
Route::get("budget/ajout/depense/{id}", "BudgetController@addDepense");
Route::get("budget/delete/depense/{id}", "BudgetController@deleteDepense");
Route::get("budget/board", "BudgetController@board");

Route::get("dashboard", "DashboardController@index");
Route::get("dashboard/categories", "DashboardController@indexCategories");
Route::get("dashboard/add/categories", "DashboardController@addCategories");
Route::get("dashboard/services", "DashboardController@indexServices");
Route::get("dashboard/add/service", "DashboardController@addService");
Route::get("dashboard/agents", "DashboardController@indexAgents");
Route::get("dashboard/delete/agent/{id}", "DashboardController@deleteAgent");
Route::get("dashboard/holidays", "DashboardController@indexHolidays");
Route::get("dashboard/delete/service/{id}", "DashboardController@deleteService");
Route::get("dashboard/add/category", "DashboardController@addCategory");
Route::get("dashboard/delete/category/{id}", "DashboardController@deleteCategory");
Route::get("dashboard/{year}/{month}", "DashboardController@access");
Route::get("dashboard/{year}", "DashboardController@accessYear");

Route::get("dashboard/add/{year}", "DashboardController@add");
Route::get("dashboard/add/{year}/month", "DashboardController@addMonth");

// Ajax - post
Route::post("action/edit/nom", "ActionController@editActionTitre");
Route::post("action/edit/description", "ActionController@editActionDescription");
Route::post("action/edit/date-creation", "ActionController@editActionDateCreation");
Route::post("action/edit/date-realisation", "ActionController@editActionDateRealisation");
Route::post("action/edit/date-butoir", "ActionController@editActionDateButoir");
Route::post("action/ajout", "ActionController@ajoutAction");

Route::post("budget/edit", "BudgetController@edit");
Route::post("budget/edit/depense", "BudgetController@editDepense");

Route::post("dashboard/add/agent", "DashboardController@addAgent");
Route::post("dashboard/add/holiday", "DashboardController@addHoliday");
Route::post("dashboard/edit/service", "DashboardController@editService");

Route::post("dashboard/edit/category", "DashboardController@editCategory");
Route::post("dashboard/edit/amount", "DashboardController@editAmount");
Route::post("dashboard/edit/amount/service", "DashboardController@editAmountService");

// rafraichissement csrf
Route::get('refresh-csrf', function(){
    return csrf_token();
});

// désactivation du formatage des nombres
Route::get('unformat/{number}', function($number) {
    $resultat = [
        'number' => number_format($number)
    ];

    return json_encode($resultat);
});