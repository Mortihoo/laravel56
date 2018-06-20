<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    //
    // login page
    public function index() {
        if(\Auth::check())
            return \redirect('/posts');
        return view('login.index');
    }

    // login action
    public function login() {

        //validate
        $this->validate(\request(), [
            'email' => 'required|email',
            'password' => 'required|min:5|max:20',
            'is_remember' => 'integer|',
        ]);

        //work
        $user = \request(['email', 'password']);
        $is_remember = boolval(\request('is_remember'));
        if (Auth::attempt($user,$is_remember)){
            return redirect('/posts');
        }

        //render

        return Redirect::back()->withErrors("邮箱密码不匹配");

    }

    // logout action
    public function logout() {
        Auth::logout();
        return \redirect('/login');
    }
}
