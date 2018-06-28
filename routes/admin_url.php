<?php
/**
 * Created by PhpStorm.
 * User: morti
 * Date: 2018/6/26
 * Time: 14:55
 */

Route::prefix('admin')->namespace('Admin')->group(function () {
    //  登陆展示页面
    Route::get('login', 'LoginController@index')->name('admin_login');
    //  登录行为
    Route::post('login', 'LoginController@login');
    //  登出行为
    Route::get('logout', 'LoginController@logout');

    Route::middleware(['auth:admin'])->group(function () {
        //  首页
        Route::get('/',function (){
            return view('admin.welcome');
        });
        Route::get('home',function (){
            return view('admin.welcome');
        });

        Route::middleware(['can:system'])->group(function () {
            //  ============ 管理人员模块 ============
            //  管理人员列表
            Route::get('users', 'UserController@index');
            //  创建管理人员页面
            Route::get('users/create', 'UserController@create');
            //  创建管理人员行为
            Route::post('users/store', 'UserController@store');
            //  查询某个用户的角色
            Route::get('users/{user}/role', 'UserController@role');
            //  修改某个用户的角色
            Route::post('users/{user}/role', 'UserController@storeRole');

            //  ============ 角色模块 ============
            //  角色列表
            Route::get('roles', 'RoleController@index');
            //  创建角色页面
            Route::get('roles/create', 'RoleController@create');
            //  创建角色行为
            Route::post('roles/store', 'RoleController@store');
            //  查询某个角色的权限
            Route::get('roles/{role}/permission', 'RoleController@permission');
            //  修改某个角色的权限
            Route::post('roles/{role}/permission', 'RoleController@storePermission');

            //  ============ 权限模块 ============
            //  权限列表
            Route::get('permissions', 'PermissionController@index');
            //  创建权限页面
            Route::get('permissions/create', 'PermissionController@create');
            //  创建权限行为
            Route::post('permissions/store', 'PermissionController@store');


        });

        Route::middleware(['can:posts'])->group(function () {
            //  ============ 审核模块 ============
            //  文章列表
            Route::get('posts', 'PostController@index');
            //  管理人员列表
            Route::post('posts/{post}/status', 'PostController@status');
        });
    });

});