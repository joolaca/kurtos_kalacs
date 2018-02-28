<?php

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

Route::get('', 'PageController@homeView');

Route::get('/', 'IndexController@renderPage');
Route::get('/admin', function(){
    return redirect('login');
});
Route::get('/home', function(){
    return redirect('admin');
});
Route::get('login', 'UserController@loginView')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/change_lang', 'SystemController@changeLang');
Route::get('/{slug}', 'PageController@renderPage');
