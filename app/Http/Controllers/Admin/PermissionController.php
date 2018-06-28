<?php

namespace App\Http\Controllers\Admin;

use App\AdminPermission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    //  权限列表
    public function index() {
        $permissions = AdminPermission::paginate(10);

        return view('admin.permission.index', compact('permissions'));

    }

    //  创建权限页面
    public function create() {

        return view('admin.permission.create');
    }

    //  创建权限行为
    public function store() {
        //validation
        $this->validate(\request(), [
            'name' => 'required|min:3',
            'description' => 'required',
        ]);

        //work
        AdminPermission::create(\request(['name', 'description']));

        //render
        return redirect('/admin/permissions');
    }
}
