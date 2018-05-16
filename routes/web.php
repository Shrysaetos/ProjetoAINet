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



//Acount routes
Route::get('accounts/{user}', 'AccountController@index')->name('account.userAccounts');
Route::get('accounts/{user}/opened', 'AccountController@listOpenAccounts')->name('account.accountsOpened');
Route::get('accounts/{user}/closed', 'AccountController@listClosedAccounts')->name('account.accountsClosed');

Route::delete('accounts/{account}', 'AccountController@delete')->name('account.delete');
Route::patch('accounts/{account}/close', 'AccountController@close')->name('account.close');
Route::patch('accounts/{account}/reopen', 'AccountController@reopen')->name('account.reopen');

Route::post('/account', 'AccountController@store')->name('account.create');
Route::put('/account/{account}', 'AccountController@update')->name('account.update');




//Moviment routes
Route::get('/movements/{account}', 'MovimentController@index')->name('moviment.index');

Route::get('/movements/{account}', 'MovimentController@create')->name('moviment.create');
Route::post('/movements/{account}', 'MovimentController@store')->name('moviment.store');

Route::get('/movements/{account}', 'MovimentController@create')->name('moviment.create');
Route::post('/movements/{account}', 'MovimentController@store')->name('moviment.store');

Route::get('/movement/{movement}', 'MovimentController@edit')->name('moviment.edit');
Route::post('/movement/{movement}', 'MovimentController@update')->name('moviment.update');

Route::delete('/movement/{movement}', 'MovimentController@delete')->name('moviment.delete');

Route::delete('/documents/{movement}', 'MovimentController@document')->name('moviment.document');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
