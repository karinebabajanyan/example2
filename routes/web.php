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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

//Group middleware auth
Route::group(['middleware' => ['auth']], function () {
    //Users resource
    Route::resource('users', 'UserController');
    //Posts resource
    Route::resource('posts', 'PostController');
    //User profile route
    Route::get('/user','UserController@user')->name('users.user');
    //Delete one image route
    Route::post('/delete-image','PostController@deleteImage')->name('posts.delete-image');
    //Show soft deleted posts route
    Route::get('/soft-deleted-posts','PostController@softDeletedPostsShow')->name('posts.soft-deleted-posts');
    //User profile image update route
    Route::post('/users/update','UserController@updateProfileImage')->name('users.update-profile-image');
});

//Social login routes
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

//Email confirmation routes
Route::name('auth.resend_confirmation')->get('/register/confirm/resend', 'Auth\RegisterController@resendConfirmation');
Route::name('auth.confirm')->get('/register/confirm/{confirmation_code}', 'Auth\RegisterController@confirm');

