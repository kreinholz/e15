<?php

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

/* Default route */
Route::get('/', function () {
    return view('welcome');
});

/* Show the checklist */
Route::get('/checklist', 'ChecklistController@index');

/* List saved inspections */
Route::get('/inspections', 'InspectionController@index');

/* Show an individual inspection */
Route::get('/inspections/{id?}', 'InspectionController@show');

/* Create an inspection */
Route::get('/inspections/create', 'InspectionController@create');
Route::post('/inspections', 'InspectionController@store');

/* Edit an inspection */
Route::get('inspections/{id}/edit', 'InspectionController@edit');
Route::put('/inspections/{id}', 'InspectionController@update');

/* Delete an inspection */
Route::delete('/inspections/{id}', 'InspectionController@destroy');

# Lots TO DO here--authentication for User management, and depending on Eloquent capabilities/
# limitations, routes for creating new checklists/adding/deleting/updating checklist items.
Auth::routes();
