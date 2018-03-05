<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books', function () {
    return 'Here are all the books in the library';
});

Route::get('/books/{title}', function ($title) {
    return 'You are viewing the book ' . $title;
});
