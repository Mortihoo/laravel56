<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

use Laravel\Scout\Searchable;
use PhpParser\Builder;

class Post extends Model
{
    use Searchable;

    //  定义索引里面的type
    public function searchableAs() {
        return 'post';
    }

    //  定义有哪些字段需要搜索
    public function toSearchableArray() {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

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

    //  属于某个作者的文章
    public function scopeAuthorBy(\Illuminate\Database\Eloquent\Builder $query, $user_id) {
        return $query->where('user_id', $user_id);
    }

    //  associated topics
    public function postTopics() {
        return $this->hasMany(\App\PostTopic::class, 'post_id', 'id');
    }

    //  不属于某个专题的文章
    public function scopeTopicNotBy(\Illuminate\Database\Eloquent\Builder $query, $topic_id) {
        return $query->doesntHave('postTopics', 'and', function ($q) use ($topic_id) {
            $q->where('topic_id', $topic_id);
        });
    }

    protected static function boot() {
        parent::boot();

        static::addGlobalScope("available", function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->whereIn('status', [0, 1]);
        });
    }

}
