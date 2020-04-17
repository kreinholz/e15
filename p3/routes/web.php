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

/* Protected routes for the Safety Oversight Manager */
/* Ref: https://medium.com/justlaravel/how-to-use-middleware-for-content-restriction-based-on-user-role-in-laravel-2d0d8f8e94c6 */
Route::group(['middleware' => 'App\Http\Middleware\checkManager'], function () {
    /* Show available checklists */
    Route::get('/checklists', 'ChecklistController@index');

    /* Show an individual checklist */
    Route::get('/checklists/{id?}', 'ChecklistController@show');

    /* Create a checklist */
    Route::get('/checklists/create', 'ChecklistController@create');
    Route::post('/checklists', 'ChecklistController@store');

    /* Edit a checklist */
    Route::get('checklists/{id}/edit', 'ChecklistController@edit');
    Route::put('/checklists/{id}', 'ChecklistController@update');
    
    /* Delete a checklist */
    Route::delete('/checklists/{id}', 'ChecklistController@destroy');
});

/* Protected routes for authenticated users */
Route::group(['middleware' => 'auth'], function () {
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
});
# Lots TO DO here--authentication for User management, and depending on Eloquent capabilities/
# limitations, routes for creating new checklists/adding/deleting/updating checklist items.
Auth::routes();
