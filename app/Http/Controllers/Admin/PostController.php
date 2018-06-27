<?php
/**
 * Created by PhpStorm.
 * User: morti
 * Date: 2018/6/26
 * Time: 17:19
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Post;

class PostController extends Controller
{
    //  文章列表
    public function index() {

        $posts = Post::withoutGlobalScope('available')->where('status', 0)->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    //  文章操作
    public function status(Post $post) {

        //  validation
        $this->validate(\request(), [
            'status' => 'required|in:1,-1',
        ]);

        //  work
        $post->status = \request('status');
        $post->save();

        //  render

        return [
            'error' => 0,
            'msg' => '',
        ];
    }
}