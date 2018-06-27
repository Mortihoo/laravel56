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
route::get('/', function () {
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

    Route::prefix('user')->group(function () {
        //user information page
        Route::get('me/setting', 'UserController@setting');
        //user modify information action
        Route::post('me/setting', 'UserController@settingStore');
        //  个人中心
        Route::get('{user}', 'UserController@show');
        //  关注某人
        Route::post('{user}/fan', 'UserController@fan');
        //  取消关注某人
        Route::post('{user}/unfan', 'UserController@unfan');
    });

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
        //  search
        Route::get('search', 'PostController@search');
    });

    //  专题模块
    Route::prefix('topic')->group(function () {
        //  专题详情页
        Route::get('{topic}', 'TopicController@show');
        //  专题投稿
        Route::post('{topic}/submit', 'TopicController@submit');

    });

});


include_once('admin_url.php');