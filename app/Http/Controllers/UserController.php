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
        $this->validate(\request(),[
            'name'=>'required|min:3',
        ]);

        //work
        $name = \request('name');
        $user = \Auth::user();
        if($name != $user->name){
            if(User::where('name',$name)->count() > 0){
                return back()->withErrors("用户昵称已经被注册");
            }
            $user->name = $name;
        }

        if($request->file('avatar')){
            $path = $request->file('avatar')->storePublicly($user->id);
            $user->avatar = "/storage/".$path;
        }

        $user->save();

        //render

        return back();


    }

}
