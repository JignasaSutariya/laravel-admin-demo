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
})->middleware('verified');

Route::group(['middleware' => ['web']], function ()
{
    Auth::routes(['verify'=>true]);
    Route::post('/userRegistration', 'UserController@userRegistration');
    Route::get('/check-email-exsist', 'UserController@emailExsist');
    Route::get('/check-number-exsist', 'UserController@mobilenumberExsist');
    Route::get('confirm_email', 'UserController@confirmEmail');

    // social login/register routes
    Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
    Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');
    Route::get('login/facebook', 'Auth\LoginController@redirectToFacebook');
    Route::get('login/facebook/callback', 'Auth\LoginController@handleFacebookCallback');

    //utility routes
    Route::get('/setsidecookie', 'HomeController@setsidecookie');
    Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

    //common front pages and CMS pages
    Route::get('/home', 'HomeController@index');


    Route::group(['middleware' => ['auth']], function()
    {
        Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
            Route::get('/dashboard', 'HomeController@adminindex');
            Route::get('/profile', 'ProfileController@adminProfile');
            Route::post('/profile', 'ProfileController@adminProfileUpdate');
            Route::post('/password', 'ProfileController@updateAdminPassword');
            Route::post('/dashboardFilterData', 'HomeController@dashboardFilterData');
            //Users
            Route::get('/users', 'UserController@index');
            Route::get('/ajaxUsers', 'UserController@ajaxUsers');
            Route::post('/users/new', 'UserController@store');
            Route::post('/users/status-change', 'UserController@changeStatus');
            Route::get('/users/view/{id}', 'UserController@view');
            Route::post('/users/update', 'UserController@update');
            Route::get('/users/delete/{id}', 'UserController@destroy');
        });
    });
});
