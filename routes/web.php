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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/chat_page', 'ChatPageController@index')->name('chat_page');

Route::get('/chat_page/load-latest-messages', 'MessagesController@getLoadLatestMessages');

Route::post('/chat_page/send', 'MessagesController@postSendMessage');

Route::get('/chat_page/fetch-old-messages', 'MessagesController@getOldMessages');

Route::get('/users', 'UsersController@index')->name('users');

Route::get('/edit_user/{id}', 'UsersController@edit')->name('edit_user');
Route::get('/delete_user/{id}', 'UsersController@delete')->name('delete_user');
Route::get('/add_user', 'UsersController@add')->name('add_user');
Route::post('/store', 'UsersController@store')->name('store');
Route::post('/add_store', 'UsersController@add_store')->name('add_store');

Route::get('/posts', 'PostsController@index')->name('posts');
Route::get('/{title}/{id}', 'OnePostController@index')->name('one_post');
Route::get('/create_post', 'CreatePostController@index')->name('create_post');
Route::post('/save_post', 'CreatePostController@save')->name('save_post');


Auth::routes();

Route::name('auth.resend_confirmation')->get('/register/confirm/resend', 'Auth\RegisterController@resendConfirmation');
Route::name('auth.confirm')->get('/register/confirm/{confirmation_code}', 'Auth\RegisterController@confirm');