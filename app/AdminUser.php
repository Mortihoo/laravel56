<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    //use Notifiable;
    protected $guarded = []; // 不可以注入的字段
    protected $rememberTokenName = '';

}
