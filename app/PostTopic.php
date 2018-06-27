<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTopic extends Model
{
    protected $guarded = []; // 不可以注入的字段

    protected $table = 'post_topic';

}
