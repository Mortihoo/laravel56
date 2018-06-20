<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = []; // 不可以注入的字段

    //  associated post
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    //  associated user
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
