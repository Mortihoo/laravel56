<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $guarded = []; // 不可以注入的字段



    //  属于这个专题的所有文章
    public function posts(){
        return $this->belongsToMany(\App\Post::class,'post_topic','topic_id','post_id');
    }

    //  专题的文章数
    public function postTopics(){

        return $this->hasMany(\App\PostTopic::class,'topic_id','id');
    }

}
