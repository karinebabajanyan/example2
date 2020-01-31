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
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
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
Route::get('/show_hidden_posts','PostsController@show_hidden_posts')->name('show_hidden_posts');
Route::get('/{title}/{id}', 'PostsController@one_post')->name('one_post');
Route::get('/create_post', 'PostsController@create')->name('create_post');
Route::post('/save_post', 'PostsController@save')->name('save_post');
Route::get('/{id}','PostsController@delete')->name('delete');


Auth::routes();

Route::name('auth.resend_confirmation')->get('/register/confirm/resend', 'Auth\RegisterController@resendConfirmation');
Route::name('auth.confirm')->get('/register/confirm/{confirmation_code}', 'Auth\RegisterController@confirm');