<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;

use App\AdminUser;

class UserController extends Controller
{
    //  管理员列表页面
    public function index() {

        $users = AdminUser::paginate(10);

        return view('admin.user.index',compact('users'));
    }

    //  管理员创建页面
    public function create() {
        return view('admin.user.create');

    }

    //  管理员保存页面
    public function store() {

        //validation
        $this->validate(\request(), [
            'name' => 'required|min:3|unique:admin_users,name',
            'password' => 'required|min:5|max:20'
        ]);

        //work
        $name = \request('name');
        $password = bcrypt(\request('password'));
        $user = AdminUser::create(compact('name', 'password'));

        //render
        return redirect('/admin/users');

    }
}
