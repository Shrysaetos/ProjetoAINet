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

Route::get('/', 'WelcomeController@home');

//Mudar email
Route::get('me/email', 'UserController@showChangeEmailForm')->name('user.showChangeEmail');
Route::post('me/email', 'UserController@changeEmail')->name('user.changeEmail');

//Mudar nome
Route::get('me/name', 'UserController@showChangeNameForm')->name('user.showChangeName');
Route::post('me/name', 'UserController@changeName')->name('user.changeName');

//Mudar numero telefone
Route::get('me/phone', 'UserController@showChangePhoneForm')->name('user.showChangePhone');
Route::post('me/phone', 'UserController@changePhone')->name('user.changePhone');

//Mudar password
Route::get('me/password','UserController@showChangePasswordForm')->name('user.showChangePassword');
Route::post('me/password','UserController@changePassword')->name('user.changePassword');


//Ver próprio perfil
Route::put('me/profile', 'UserController@profile')->name('user.profile');

//Editar foto
Route::post('me/profile', 'UserController@update_photo')->name('user.update.photo');

// Listagem
Route::get('users', 'UserController@index')->name('users.index');

// Formulário para adicionar
Route::get('users/register', 'UserController@create')->name('users.create');
// Acção de adicionar
Route::post('users/register', 'UserController@store')->name('users.store');



//Update user
Route::put('/user', 'UserController@putUpdateUser')->name('update');

//Password Reset Routes...
// Formulário para editar
Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
// Acção de guardar
Route::put('/users/{user}/edit', 'UserController@update')->name('users.update');

Route::delete('/users/{user}', 'UserController@destroy')->name('users.destroy');


//Acount routes
Route::get('accounts/{user}', 'AccountController@index')->name('accounts.index');
Route::get('accounts/{user}/opened', 'AccountController@listOpenAccounts')->name('account.accountsOpened');
Route::get('accounts/{user}/closed', 'AccountController@listClosedAccounts')->name('account.accountsClosed');

Route::delete('accounts/{account}', 'AccountController@delete')->name('account.delete');    			///////////////////////////////////
Route::patch('accounts/{account}/close', 'AccountController@closeAccount')->name('account.close'); 		
Route::patch('accounts/{account}/reopen', 'AccountController@reopenAccount')->name('account.reopen');

Route::get('/account/{user}/create', 'AccountController@create')->name('account.create');
Route::post('/account', 'AccountController@store')->name('account.store');								///////////////////////////////////
Route::get('/account/{account}', 'AccountController@edit')->name('account.edit');
Route::put('/account/{account}', 'AccountController@update')->name('account.update'); 					///////////////////////////////////






//Moviment routes
Route::get('/movements/{account}', 'MovementController@index')->name('movement.index');

Route::get('/movements/{account}/create', 'MovementController@create')->name('movement.create');
Route::post('/movements/{account}', 'MovementController@store')->name('movement.store');

Route::get('/movement/{movement}', 'MovementController@edit')->name('movement.edit');
Route::post('/movement/{movement}', 'MovementController@update')->name('movement.update');

Route::delete('/movement/{movement}', 'MovementController@delete')->name('movement.delete');

Route::delete('/documents/{movement}', 'MovementController@document')->name('movement.document');

Route::delete('/document/{document}', 'MovementController@documentDelete')->name('movement.documentDelete');
Route::get('/document/{document}', 'MovementController@documentDownload')->name('movement.documentDownload');



Route::get('/dashboard/{user}', 'UserController@generalStats')->name('user.stats');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');