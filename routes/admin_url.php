<?php
/**
 * Created by PhpStorm.
 * User: morti
 * Date: 2018/6/26
 * Time: 14:55
 */

Route::prefix('admin')->namespace('Admin')->group(function () {
    //  登陆展示页面
    Route::get('login', 'LoginController@index');
    //  登录行为
    Route::post('login', 'LoginController@login');
    //  登出行为
    Route::get('logout', 'LoginController@logout');

    Route::middleware(['auth:admin'])->group(function () {
        //  首页
        Route::get('home', 'PostController@index');

        //  ============ 管理人员模块 ============
        //  管理人员列表
        Route::get('users', 'UserController@index');
        //  创建管理人员页面
        Route::get('users/create', 'UserController@create');
        //  创建管理人员行为
        Route::post('users/store', 'UserController@store');

        //  ============ 审核模块 ============
        //  文章列表
        Route::get('posts', 'PostController@index');
        //  管理人员列表
        Route::post('posts/{post}/status', 'PostController@status');
        //  管理人员列表
        Route::get('users', 'UserController@index');
    });

});