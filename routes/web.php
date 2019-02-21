<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('employee/tasks/add', 'EmployeeController@add');
Route::get('employee/tasks/edit/{id}', 'EmployeeController@edit');
Route::get('employee/tasks', 'EmployeeController@show');
Route::get('employee', 'EmployeeController@index')->name('employee');
Route::get('employee/tasks/store', function(){ abort('404'); });
Route::post('employee/tasks/store', 'EmployeeController@store');


Route::get('employee/tasks/destroy', function(){ abort('404'); });
Route::post('employee/tasks/destroy', 'EmployeeController@destroy');
Route::get('employee/tasks/update/{id}', function(){ abort('404'); });
Route::post('employee/tasks/update/{id}', 'EmployeeController@update');

Route::get('employee/account', 'EmployeeAccountController@index');
Route::get('employee/account/show', function(){ abort('404'); });
Route::post('employee/account/show', 'EmployeeAccountController@show');
Route::get('employee/account/update', function(){ abort('404'); });
Route::post('employee/account/update', 'EmployeeAccountController@update');

Route::prefix('admin')->group(function(){
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');    
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/users', 'AdminController@users')->name('admin.users');
    
    Route::get('/schedule', 'AdminScheduleController@show')->name('admin.schedule');
    Route::get('/schedule/getus', function(){ abort('404'); });
    Route::post('/schedule/getus', 'AdminScheduleController@get_users');
    Route::get('/schedule/getsch', function(){ abort('404'); });
    Route::post('/schedule/getsch', 'AdminScheduleController@get_schedule');

    Route::post('/getus', 'AdminController@get_users');
  //  Route::get('/stor', 'AdminController@stor')->name('admin.stor');
  //  Route::get('/cache', 'AdminController@cache')->name('admin.cache');
    
    Route::delete('/destroy', 'AdminController@destroy')->name('admin/destroy');
    
    
    Route::get('/users/update', function(){ abort('404'); });
    Route::post('/users/update', 'AdminController@update')->name('admin/update');
    Route::get('/users/store', function(){ abort('404'); });
    Route::post('users/store', 'AdminController@store')->name('admin/store');
});

Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::get('/websites', 'WebsitesController@index')->name('websites');

Route::get('/compare', 'CheckController@compare')->middleware('cors');

Route::get('/check', 'CheckController@check')->middleware('cors');

//Route::post('/storage', 'CheckController@store');


Route::get('/storage', 'CheckController@store')->middleware('cors');


//Route::post('store', 'WebsitesController@store');






//Route::match(['get', 'post'], '/destroy', 'WebsitesController@destroy');
