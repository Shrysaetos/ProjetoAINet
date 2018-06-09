<?php

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
// Ignores notices and reports all other kinds... and warnings
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}



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

Route::get('/', 'WelcomeController@home')->name('user.home');

//Mudar password
Route::get('me/password','UserController@showChangePasswordForm')->name('user.showChangePassword');
Route::patch('me/password','UserController@changePassword')->name('user.changePassword');

//Ver próprio perfil
Route::get('me', 'UserController@profile')->name('user.profile');

//Editar perfil
Route::get('me/profile', 'UserController@edit')->name('user.edit');
Route::put('me/profile', 'UserController@update')->name('user.update');

//Ver lista membros associados
Route::get('me/associates', 'UserController@showAssociates')->name('user.associates');

//Ver lista membros a que estou associado
Route::get('me/associate-of', 'UserController@showAssociatesOf')->name('user.associatesOf');

// Listagem
Route::get('profiles', 'UserController@index')->name('users.index');

//Listagem se for admin
Route::get('users', 'UserController@index')->name('users.index.admin');

//Bloquear/Desbloquear user
Route::patch('/users/{user}/block', 'UserController@blockUser')->name('user.block');
Route::patch('/users/{user}/unblock', 'UserController@unblockUser')->name('user.unblock');

//Promover/Demover userusers
Route::patch('/users/{user}/promote', 'UserController@promoteUser')->name('user.promote');
Route::patch('/users/{user}/demote', 'UserController@demoteUser')->name('user.demote');

// Formulário para adicionar
Route::get('users/register', 'UserController@create')->name('users.create');
// Acção de adicionar
Route::post('users/register', 'UserController@store')->name('users.store');

//Update user
Route::put('/user', 'UserController@putUpdateUser')->name('update');

//Bloquear utilizador
Route::patch('/user/{user}/block', 'UserController@blockUser')->name('users.block');

//Desbloquear utilizador
Route::patch('/user/{user}/unblock', 'UserController@unblockUser')->name('users.unblock');

//Promover utilizador
Route::patch('/user/{user}/promote', 'UserController@promoteUser')->name('users.promote');

//Demover utilizador
Route::patch('/user/{user}/demote', 'UserController@demoteUser')->name('users.demote');

//Password Reset Routes...
Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.token');
Route::post('password/reset', 'ResetPasswordController@reset') -> name('user.passwordReset');

// Formulário para editar
Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
// Acção de guardar
Route::put('/users/{user}/edit', 'UserController@update')->name('users.update');

Route::delete('/users/{user}', 'UserController@destroy')->name('users.destroy');


//Acount routes
Route::get('accounts/{user}', 'AccountController@index')->name('accounts.index');
Route::get('accounts/{user}/opened', 'AccountController@listOpenAccounts')->name('account.accountsOpened');
Route::get('accounts/{user}/closed', 'AccountController@listClosedAccounts')->name('account.accountsClosed');

Route::delete('account/{accountId}', 'AccountController@delete')->name('account.delete');    			///////////////////////////////////
Route::patch('account/{account}/close', 'AccountController@closeAccount')->name('account.close'); 		
Route::patch('account/{accountId}/reopen', 'AccountController@reOpenAccount')->name('account.reopen');

Route::get('/account/create', 'AccountController@create')->name('account.create');
Route::post('/account', 'AccountController@store')->name('account.store');
Route::get('/account/{account}/edit', 'AccountController@edit')->name('account.edit');								
Route::put('/account/{account}', 'AccountController@update')->name('account.update'); 					



//Moviment routes
Route::get('/movements/{account}', 'MovementController@index')->name('movement.index');

Route::get('/movements/{account}/create', 'MovementController@create')->name('movement.create');
Route::post('/movements/{account}/create', 'MovementController@store')->name('movement.store');

Route::get('/movement/{movement}', 'MovementController@edit')->name('movement.edit');
Route::put('/movement/{movement}', 'MovementController@update')->name('movement.update');

Route::delete('/movement/{movement}', 'MovementController@delete')->name('movement.delete');

Route::delete('/documents/{movement}', 'MovementController@document')->name('movement.document');

//Route::delete('/document/{document}', 'MovementController@documentDelete')->name('movement.documentDelete');
//Route::get('/document/{document}', 'MovementController@documentDownload')->name('movement.documentDownload');



Route::get('/dashboard/{user}', 'UserController@generalStats')->name('user.stats');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');