<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\AdminUser;
use App\AdminRole;
use App\AdminPermission;

class RoleController extends Controller
{

    //  角色列表
    public function index() {
        $roles = AdminRole::paginate(10);

        return view('admin.role.index', compact('roles'));
    }

    //  创建角色页面
    public function create() {

        return view('admin.role.create');
    }

    //  创建角色行为
    public function store() {
        //validation
        $this->validate(\request(), [
            'name' => 'required|min:3',
            'description' => 'required',
        ]);

        //work
        AdminRole::create(\request(['name', 'description']));

        //render
        return redirect('admin/roles');
    }

    //  查询某个角色的权限
    public function permission(AdminRole $role) {

        //获取所有的权限
        $permissions = AdminPermission::all();
        //获取当前角色权限
        $myPermissions = $role->permissions;

        return view('admin.role.permission', compact('permissions', 'myPermissions', 'role'));

    }

    //  修改某个角色的权限
    public function storePermission(AdminRole $role) {
        //validation
        $this->validate(\request(), [
            'permissions' => 'required|array',
        ]);

        //work
        $permissions = AdminPermission::findMany(\request('permissions'));
        $myPermissions = $role->permissions;

        //  要增加的
        $addPermissions = $permissions->diff($myPermissions);
        foreach ($addPermissions as $addPermission) {
            $role->grantPermission($addPermission);
        }
        //  要删除的
        $deletePermissions = $myPermissions->diff($permissions);
        foreach ($deletePermissions as $deletePermission) {
            $role->deletePermission($deletePermission);
        }
        //render
        return redirect('admin/roles');
    }


}
