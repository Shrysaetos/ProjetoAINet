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

Route::get('/', function () {
    return view('welcome');
});

// Listagem
Route::get('users', 'UserController@index')->name('users.index');

// Formulário para adicionar
Route::get('users/create', 'UserController@create')->name('users.create');
// Acção de adicionar
Route::post('users/create', 'UserController@store')->name('users.store');

// Formulário para editar
Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
// Acção de guardar
Route::put('/users/{user}/edit', 'UserController@update')->name('users.update');

Route::delete('/users/{user}', 'UserController@destroy')->name('users.destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
