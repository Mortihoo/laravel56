<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Zan;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // list
    public function index() {
        $posts = Post::orderBy('created_at', "desc")->withCount(["comments", 'zans'])->paginate(5);
        return view('post/index', compact('posts'));
    }

    // detail
    public function show(Post $post) {
        $post->load("comments");

        return view('post/show', compact('post'));

    }

    // create page
    public function create() {
        return view('post/create');
    }

    // store page
    public function store() {
        //validation
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10',
        ]);

        // work
        $user_id = Auth::id();
        $params = array_merge(\request(['title', 'content']), compact('user_id'));
        $flag = Post::create($params);
        //  render
        return redirect('/posts');
    }

    // edit
    public function edit(Post $post) {
        return view('post/edit', compact('post'));

    }

    // update
    public function update(Post $post) {
        //validation
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10',
        ]);

        $this->authorize('update', $post);

        // work
        $post->title = request('title');
        $post->content = request('content');
        $post->save();

        //  render
        return redirect("/posts/$post->id");
    }

    // delete
    public function delete(Post $post) {

        $this->authorize('delete', $post);

        $post->delete();

        return redirect('/posts');

    }

    //  upload
    public function upload() {
        $request = request();
        $data = [
            'errno' => 0,
            'data' => [],
        ];
        foreach ($request->file() as $file) {
            $path = $file->storePublicly(md5(time()));
            array_push($data['data'], asset('storage/' . $path));
        }
        return $data;
    }

    // comment action
    public function comment(Post $post) {
        //  validation
        $this->validate(request(), [
            'content' => 'required|min:5',
        ]);

        //  work
        $comment = new Comment();
        $comment->user_id = \Auth::id();
        $comment->content = request('content');
        $post->comments()->save($comment);

        //render
        return back();
    }

    // 点赞
    public function zan(Post $post) {
        $params = [
            'user_id' => \Auth::id(),
            'post_id' => $post->id,
        ];

        Zan::firstOrCreate($params);
        return back();
    }

    //  取消赞
    public function unzan(Post $post) {
        $post->zan(\Auth::id())->delete();
        return back();
    }

    //  搜索页
    public function search() {
        //validation
        $this->validate(request(), [
            'query' => "required",
        ]);


        //work
        $query = request('query');
        $posts = \App\Post::search($query)->paginate(5);

        //render
        return view('post.search', compact('posts', 'query'));
    }
}
