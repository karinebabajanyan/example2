<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class OnePostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $id=(int)$request->id;
        $post=Post::where('id','=' ,$id)->first();
        return view('one_post',['post'=>$post]);
    }
}
