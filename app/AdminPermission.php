<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    protected $guarded = []; // 不可以注入的字段
    protected $table = 'admin_permissions';

    //  权限属于那些角色
    public function roles() {
        return $this->belongsToMany(\App\AdminRole::class, 'admin_permission_role', 'permission_id',
            'role_id')->withPivot(['role_id', 'permission_id']);
    }
}
