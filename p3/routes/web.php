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
Route::get('/', 'PageController@welcome');

/* Protected routes for authenticated users */
Route::group(['middleware' => 'auth'], function () {
    /* List saved inspections */
    Route::get('/inspections', 'InspectionController@index');

    /* Show an individual inspection */
    # Ref: https://stackoverflow.com/a/30414884
    Route::get('/inspections/{id}', 'InspectionController@show')->where('id', '[0-9]+');

    /* Create an inspection */
    Route::get('/inspections/create', 'InspectionController@create');
    Route::post('/inspections', 'InspectionController@store');

    /* Edit an inspection */
    Route::get('inspections/{id}/edit', 'InspectionController@edit');
    Route::put('/inspections/{id}', 'InspectionController@update');

    /* Show the page to confirm deletion of an inspection */
    Route::get('/inspections/{id}/delete', 'InspectionController@delete');

    /* Delete an inspection */
    Route::delete('/inspections/{id}', 'InspectionController@destroy');

    /* Additional protected routes for the Safety Oversight Manager */
    /* Ref: https://medium.com/justlaravel/how-to-use-middleware-for-content-restriction-based-on-user-role-in-laravel-2d0d8f8e94c6 */
    Route::group(['middleware' => 'App\Http\Middleware\checkManager'], function () {
        /* Show available checklists */
        Route::get('/checklists', 'ChecklistController@index');

        /* Show an individual checklist */
        # Ref: https://stackoverflow.com/a/30414884
        Route::get('/checklists/{id}', 'ChecklistController@show')->where('id', '[0-9]+');

        /* Create a checklist */
        Route::get('/checklists/create', 'ChecklistController@create');
        Route::post('/checklists', 'ChecklistController@store');

        /* Edit a checklist */
        Route::get('checklists/{id}/edit', 'ChecklistController@edit');
        Route::put('/checklists/{id}', 'ChecklistController@update');

        /* Show the page to confirm deletion of a checklist */
        Route::get('/checklists/{id}/delete', 'ChecklistController@delete');

        /* Process the deletion of a checklist */
        Route::delete('/checklists/{id}', 'ChecklistController@destroy');

        # The following routes pertain to checklist items, as opposed to checklists

        /* Show available checklist items */
        Route::get('/checklist-items', 'ChecklistItemController@index');

        /* Redirect attempts to get to the non-existent show view for a checklist-item */
        /* Ref: https://laravel.com/docs/7.x/routing */
        Route::redirect('/checklist-items/{id}', '/checklist-items/{id}/edit')->where('id', '[0-9]+');

        /* Create a checklist item */
        Route::get('/checklist-items/create', 'ChecklistItemController@create');
        Route::post('/checklist-items', 'ChecklistItemController@store');

        /* Edit a checklist item */
        Route::get('checklist-items/{id}/edit', 'ChecklistItemController@edit');
        Route::put('/checklist-items/{id}', 'ChecklistItemController@update');

        /* Delete a checklist item */
        Route::delete('/checklist-items/{id}', 'ChecklistItemController@destroy');

        /* Redirect any unknown query or route parameter to home
           Ref: https://laraveldaily.com/routes-file-redirect-everything-else-to-homepage/ */
        Route::any('{query}', function () {
            return redirect('/');
        })->where('query', '.*');
    });
});

Auth::routes();
