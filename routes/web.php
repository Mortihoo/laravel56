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
//
//Route::get('/', function () {
//    return view('welcome');
//});

// index
route::get('/', function (){
    return redirect('/login');
});

//========================================
// user
//register page
Route::get('/register', 'RegisterController@index');
//register action
Route::post('/register', 'RegisterController@register');
//login page
Route::get('/login', 'LoginController@index')->name('login');
//login action
Route::post('/login', 'LoginController@login');


//  need user login
Route::middleware(['auth:web'])->group(function () {
    //logout page
    Route::get('/logout', 'LoginController@logout');
    //user information page
    Route::get('/user/me/setting', 'UserController@setting');
    //user modify information action
    Route::post('/user/me/setting', 'UserController@settingStore');

    //========================================
    //article
    Route::prefix('posts')->group(function () {

        //  list
        Route::get('/', 'PostController@index');
        //  detail
        Route::get('{post}', 'PostController@show');
        //  create
        Route::get('create', 'PostController@create');
        Route::post('/', 'PostController@store');
        //  edit
        Route::get('{post}/edit', 'PostController@edit');
        Route::put('{post}', 'PostController@update');
        //  delete
        Route::get('{post}/delete', 'PostController@delete');
        //  upload
        Route::post('upload', 'PostController@upload');
        //  comment
        Route::post('{post}/comment', 'PostController@comment');
        //  zan
        Route::get('{post}/zan', 'PostController@zan');
        //  unzan
        Route::get('{post}/unzan', 'PostController@unzan');
    });


});
