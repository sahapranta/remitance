<?php



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Customer Route
Route::resource('customer', 'CustomerController');
Route::resource('remitance', 'RemitanceController');

Route::get('/check', 'CustomerController@check')->name('check');
Route::post('/check', 'CustomerController@check')->name('check-customer');

Route::get('/markasread', 'MarkAsReadController@read')->name('markAsRead');
Route::get('/notifications', 'MarkAsReadController@index')->name('notifications');
Route::delete('/notifications', 'MarkAsReadController@delete')->name('deleteNotification');

Route::get('/settings', 'SettingsController@index')->name('settings');
Route::post('/settings', 'SettingsController@store')->name('settings.store');
Route::put('/settings/{settings}', 'SettingsController@update')->name('settings.update');