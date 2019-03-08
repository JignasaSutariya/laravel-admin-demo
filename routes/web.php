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

    Route::post('/getCountry', 'CountryController@getCountry');
    Route::post('/getState', 'CountryController@getState');
    Route::post('/getCity', 'CountryController@getCities');

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

            //Country/State/city
            Route::resource('/countries', 'CountryController');
            Route::get('/ajaxCountry', 'CountryController@ajaxCountry');
            Route::get('/country/delete/{id}', 'CountryController@destroy');

            Route::get('/ajaxState/{id}', 'CountryController@ajaxState');
            Route::post('/state/new', 'CountryController@storeState');
            Route::get('/state/{id}/edit', 'CountryController@editState');
            Route::post('/state/update', 'CountryController@updateState');
            Route::get('/state/view/{id}', 'CountryController@getCity');
            Route::get('/state/delete/{id}', 'CountryController@deleteState');

            Route::get('/ajaxCity/{id}', 'CountryController@ajaxCity');
            Route::get('/city/delete/{id}', 'CountryController@deleteCity');
            Route::post('/city/new', 'CountryController@storeCity');

            //Category
            Route::resource('/categories', 'CategoryController');
            Route::get('/categories/delete/{id}', 'CategoryController@destroy');

            //Sub Category
            Route::resource('/sub-categories', 'SubCategoryController');
            Route::get('/sub-categories/delete/{id}', 'SubCategoryController@destroy');

            //Product
            Route::resource('/products', 'ProductController');
            Route::get('/products/delete/{id}', 'ProductController@destroy');
            Route::get('/product', 'ProductController@productList');
            Route::post('/product-ajax-data', 'ProductController@productAjaxData');
        });
    });
});
