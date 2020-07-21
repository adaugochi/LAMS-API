<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','Auth\ApiAuthController@register')->name('register.api');
    Route::get('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
});

Route::middleware(['cors', 'json.response', 'auth:api'])->group(function () {
    Route::get('/user', 'UserController@index')->middleware('api.admin');
});

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::get('/categories', 'CategoryController@index')->name('categories');
    Route::post('/save-category', 'CategoryController@createCategory')->name('save.category');
    Route::get('/book/{id}', 'BookController@showBook')->name('book');
    Route::get('/books', 'BookController@index')->name('books');
    Route::post('/save-book', 'BookController@createBook')->name('save.book');
    Route::post('/deactivate-book', 'BookController@deactivateBook');
    Route::post('/activate-book', 'BookController@activateBook');
});

