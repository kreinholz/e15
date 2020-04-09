<?php

/**
 * Practice
 */
Route::any('/practice/{n?}', 'PracticeController@index');


/**
 * Miscellaneous mostly-static pages
 */
Route::get('/', 'PageController@welcome');
Route::get('/support', 'PageController@support');


/**
 * Books
 */
# Create a book
Route::get('/books/create', 'BookController@create');
Route::post('/books', 'BookController@store');

# Update a book
Route::get('/books/{slug}/edit', 'BookController@edit');
Route::put('/books/{slug}', 'BookController@update');

# Delete a book
Route::delete('/books/{slug}', 'BookController@destroy');

# Show all books
Route::get('/books', 'BookController@index');

# Show a book
Route::get('/books/{slug?}', 'BookController@show');

# Misc
Route::get('/search', 'BookController@search');
Route::get('/list', 'BookController@list');

# This was an example route to show multiple parameters;
# Not a feature we're actually building, so I'm commenting out
# Route::get('/filter/{category}/{subcategory?}', 'BookController@filter');
