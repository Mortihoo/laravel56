<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $guarded = []; // 不可以注入的字段
    protected $table = 'admin_roles';

    //  当前角色的所有权限
    public function permissions() {
        return $this->belongsToMany(\App\AdminPermission::class, 'admin_permission_role',
            'role_id', 'permission_id')->withPivot(['role_id', 'permission_id']);
    }

    //  给角色赋予权限
    public function grantPermission($permission) {
        $this->permissions()->save($permission);
    }

    //  收回角色的权限
    public function deletePermission($permission) {
        $this->permissions()->detach($permission);
    }

    //  判断角色是否有权限
    public function hasPermission($permission) {
        $this->permissions->contains($permission);
    }

}
