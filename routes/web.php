<?php



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Multiple Remitance
Route::get('/remitance/{customer}/all', 'RemitanceController@pay_all_incentive')->name('remitance.all');
Route::post('/remitance/{customer}/payall', 'RemitanceController@pay_multiple_incentive')->name('remitance.payall');

// Data Entry
Route::post('/remitance/entry', 'RemitanceController@data_entry')->name('remitance.entry');
Route::post('/remitance/prefilled_remitance', 'RemitanceController@prefilled_remitance')->name('remitance.prefilled-remitance');


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


// Report Priniting
Route::get('/report/index', 'ReportController@index')->name('report.index');
Route::get('/report/remitance/{remitance}', 'ReportController@remitance')->name('report.remitance');
Route::get('/report/remitance/{remitance}/sms', 'ReportController@remitance_sms')->name('report.remitance-sms');
Route::get('/report/customer/{customer}', 'ReportController@customer')->name('report.customer');
Route::get('/report/incentive/{customer}', 'ReportController@incentive')->name('report.incentive');

