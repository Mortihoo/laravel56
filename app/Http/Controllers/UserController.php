<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //
    //  user information page
    public function setting() {
        $user = \Auth::user();
        return view("user.setting", compact('user'));
    }

    //  user modify information action
    public function settingStore(Request $request) {
        //validation
        $this->validate(\request(), [
            'name' => 'required|min:3',
        ]);

        //work
        $name = \request('name');
        $user = \Auth::user();
        if ($name != $user->name) {
            if (User::where('name', $name)->count() > 0) {
                return back()->withErrors("用户昵称已经被注册");
            }
            $user->name = $name;
        }

        if ($request->file('avatar')) {
            $path = $request->file('avatar')->storePublicly($user->id);
            $user->avatar = "/storage/" . $path;
        }

        $user->save();

        //render

        return back();


    }

    //  个人中心
    public function show(User $user) {
        //  except user info, we have to fetch the num of ['stars', 'fans', 'posts']
        $user = User::withCount(['stars', 'fans', 'posts'])->find($user->id);

        //  这个人的文章列表

        //  这个人的关注用户,包含

        //

        return view('user.show');
    }

    //  关注
    public function fan(User $user) {

    }

    //  取消关注
    public function unfan(User $user) {

    }

}
