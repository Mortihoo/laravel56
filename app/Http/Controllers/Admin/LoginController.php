<?php
/**
 * Created by PhpStorm.
 * User: morti
 * Date: 2018/6/26
 * Time: 17:19
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    //  登录页面
    public function index() {
        return view('admin.login.index');
    }

    //  登录行为
    public function login() {
        //validate
        $this->validate(\request(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        //work
        $user = \request(['name', 'password']);
        if (Auth::guard('admin')->attempt($user)) {
            return redirect('/admin/home');
        }

        //render

        return Redirect::back()->withErrors("用户名密码不匹配");

    }

    //  登出行为
    public function logout() {
        Auth::guard('admin')->logout();
        return \redirect('/admin/login');
    }
}