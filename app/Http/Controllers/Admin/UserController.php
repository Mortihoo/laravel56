<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;

use App\AdminUser;
use App\AdminRole;

class UserController extends Controller
{
    //  管理员列表页面
    public function index() {

        $users = AdminUser::paginate(10);

        return view('admin.user.index', compact('users'));
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

    //  用户角色页面
    public function role(AdminUser $user) {
        $roles = AdminRole::all();
        $myRoles = $user->roles;

        return view('admin.user.role', compact('roles', 'myRoles', 'user'));
    }

    //  修改某个用户的角色
    public function storeRole(AdminUser $user) {

        //validation
        $this->validate(\request(), [
            'roles' => 'required|array',
        ]);

        //work
        $roles = AdminRole::findMany(\request('roles'));
        $myRoles = $user->roles;

        //  要增加的
        $addRoles = $roles->diff($myRoles);
        foreach ($addRoles as $addRole) {
            $user->assignRole($addRole);
        }
        //  要删除的
        $deleteRoles = $myRoles->diff($roles);
        foreach ($deleteRoles as $deleteRole) {
            $user->assignRole($deleteRole);
        }
        //render
        return redirect('/admin/users');
    }

}
