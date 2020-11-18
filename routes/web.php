<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

// Guest access
Route::get('/', 'GuestController@index')->name('index');
Route::get('/search', 'GuestController@search')->name('search');
Route::get('/show/{id}', 'GuestController@show')->name('show');
Route::post('/storeMessagesGuest/{id}', 'GuestController@storeMessagesGuest')->name('storeMessagesGuest');
Route::get('/api/search', 'GuestController@searchsort');

// User access
Route::get('/become-host', 'UserController@becomeHost')->name('becomeHost');
Route::post('/become-host/{id}', 'UserController@storehost')->name('storeHost');
Route::get('/profile', 'UserController@showProfile')->name('profile');
Route::post('/storeMessagesUser/{id}', 'UserController@storeMessagesUser')->name('storeMessagesUser');


// Host access only
Route::get('/sponsor-form/{id}', 'UserController@sponsorForm')->name('sponsorForm');
Route::get('/sponsor-form-update/{id}', 'UserController@sponsorFormUpdate')->name('sponsorFormUpdate');
Route::post('/payment/{id}', 'UserController@sponsorPayment')->name('sponsorPayment');
Route::post('/payment-update/{id}', 'UserController@sponsorPaymentUpdate')->name('sponsorPaymentUpdate');
Route::get('/disable/{id}', 'UserController@disable')->name('disable');
Route::get('/enable/{id}', 'UserController@enable')->name('enable');
Route::get('/delete/{id}', 'UserController@delete')->name('delete');
Route::get('/showMessage/{id}', 'UserController@showMessage')->name('message');
Route::get('/update/{id}', 'UserController@update')->name('update');
Route::post('/editFlat/{id}', 'UserController@editFlat')->name('editFlat');
Route::get('/stats/{id}', 'UserController@showStats')->name('showStats');
Route::get('/storePhoto/{id}', 'UserController@photo')->name('photo');
Route::post('/storePhoto/{id}', 'UserController@storePhoto')->name('storePhoto');