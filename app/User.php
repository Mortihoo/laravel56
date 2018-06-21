<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //  用户的文章列表
    public function posts() {
        return $this->hasMany(\App\Post::class, 'user_id', 'id');
    }

    //  关注我的Fan模型
    public function fans() {
        return $this->hasMany(\App\Fan::class, 'star_id', 'id');
    }

    //  我关注的Fan模型
    public function stars() {
        return $this->hasMany(\App\Fan::class, 'fan_id', 'id');
    }

    //  我要关注某人
    public function doFan() {
        return $this->hasMany(\App\Fan::class, 'fan_id', 'id');
    }
}
