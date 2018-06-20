<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Post extends Model
{
    protected $guarded = []; // 不可以注入的字段
    //protected  $fillable ; // 可以注入的字段

    // associated user
    public function user() {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    //  associated comment
    public function comments() {
        return $this->hasMany('\App\Comment')->orderBy('created_at', 'desc');
    }

    //  associated zan --> get sb zan
    public function zan($user_id) {
        return $this->hasOne(\App\Zan::class)->where('user_id', $user_id);
    }

    //  associated zan --> get all zan
    public function zans() {
        return $this->hasMany(\App\Zan::class);
    }

}
