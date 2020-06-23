<?php



Route::get('/', 'HomeController@welcome')->name('welcome');

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
Route::get('/remitance/remove_duplicate/{remitance}', 'RemitanceController@remove_duplicate')->name('remitance.remove.duplicate');
Route::post('/remitance/remove-duplicate-incentive', 'RemitanceController@remove_duplicate_incentive')->name('remitance.duplicate.incentives');

// Record Print Count
Route::post('/print/count', 'RemitanceController@print_count')->name('print.count');

// Customer Route
Route::resource('customer', 'CustomerController');
Route::resource('remitance', 'RemitanceController');

Route::get('/check', 'CustomerController@check')->name('check');
Route::post('/check', 'CustomerController@check')->name('check-customer');

Route::get('/markasread', 'MarkAsReadController@read')->name('markAsRead');
Route::get('/notifications', 'MarkAsReadController@index')->name('notifications');
Route::delete('/notifications', 'MarkAsReadController@delete')->name('deleteNotification');

Route::get('/settings', 'SettingsController@index')->name('settings');
Route::post('/settings/cache', 'SettingsController@cache')->name('settings.cache');
Route::post('/settings/cache-clear', 'SettingsController@cache_clear')->name('settings.cache.clear');
Route::post('/settings', 'SettingsController@store')->name('settings.store');
Route::put('/settings/{settings}', 'SettingsController@update')->name('settings.update');


// Report Priniting
Route::get('/report/index', 'ReportController@index')->name('report.index');
Route::get('/report/remitance/{remitance}', 'ReportController@remitance')->name('report.remitance');
Route::get('/report/remitance/{remitance}/sms', 'ReportController@remitance_sms')->name('report.remitance-sms');
Route::get('/report/customer/{customer}', 'ReportController@customer')->name('report.customer');
Route::get('/report/incentive/{customer}', 'ReportController@incentive')->name('report.incentive');
Route::get('/report/daily', 'ReportController@daily')->name('report.daily');
Route::get('/report/monthly', 'ReportController@monthly')->name('report.monthly');
Route::post('/report/datewise-remitance', 'ReportController@datewise_remitance')->name('report.date.remitance');
Route::post('/report/datewise-incentive', 'ReportController@datewise_incentive')->name('report.date.incentive');
Route::post('/report/check-ref', 'ReportController@check_ref')->name('report.check.ref');

Route::get('/user', 'UserController@index')->name('user.index');
Route::get('/user/{user}', 'UserController@edit')->name('user.edit');
Route::put('/user/{user}', 'UserController@update')->name('user.update');
Route::delete('/user/{user}', 'UserController@destroy')->name('user.destroy');
Route::post('/user/make-admin', 'UserController@admin')->name('user.admin');

// Offus
Route::get('/offus', 'SettingsController@offus')->name('offus');
Route::post('/offus', 'SettingsController@offus_upload')->name('offus.upload');
Route::post('/offus/create', 'SettingsController@create_remitance_offus')->name('offus.create');

