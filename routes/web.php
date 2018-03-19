<?php

Route::get('/', 'PageController@welcome');
Route::get('/about', 'PageController@about');
Route::get('/contact', 'PageController@contact');

Route::get('/books', 'BookController@index');
Route::get('/books/{title}', 'BookController@show');

Route::any('/practice/{n?}', 'PracticeController@index');
