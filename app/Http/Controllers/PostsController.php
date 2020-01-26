<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Auth;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id=Auth::user()->id;
        $posts=Post::where('user_id','=',$id)->get();
//        $users=User::all();
        return view('posts',['posts'=>$posts]);
    }
}
