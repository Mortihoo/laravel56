<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    //
    // register page
    public function index() {
        return view('register.index');
    }

    // register action
    public function register() {
        //validation
        $this->validate(\request(), [
            'name' => 'required|min:3|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|max:20|confirmed'
        ]);

        //work
        $name = \request('name');
        $email = \request('email');
        $password = bcrypt(\request('password'));
        $user = User::create(compact('name', 'email', 'password'));

        //render
        return redirect('/login');
    }
}
