<?php

namespace App\Http\Controllers;

use App\Post;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
            $user = Auth::user();
            $all = Post::all();


            // load post
            $my=$user->posts;
//            $posts = Post::all();
//            foreach ($posts as $key=>$post){
//                if ($user->can('view', $post)) {
//                    $all[]=$post;
//                }
//            }

        return view('posts',['all_posts'=>$all,'my_posts'=>$my]);
    }

    public function create()
    {
        return view('create_post');
    }

    public  function save(Request $request){
        $this->validate($request,[
            'title' => 'required',
            'upload' => 'required',
            'description'=>'required',
        ]);
        $image= Input::file('upload');
        $input['imagename']=time().'.'.$image->getClientOriginalExtension();
        $destinationPath=public_path('/photos');
        $image->move($destinationPath,$input['imagename']);
        $id = Auth::user()->id;
        $post=new Post([
            'title'=>$request->get('title'),
            'description'=>$request->get('description'),
            'image_upload'=>$input['imagename'],
            'user_id'=>$id,
        ]);
        $post->save();
        return redirect('posts');
    }

    public function one_post(Request $request)
    {
        $id=(int)$request->id;
        $post=Post::where('id','=' ,$id)->first();
        return view('one_post',['post'=>$post]);
    }

    public function delete(Request $request){
        $id=(int)$request->id;
        $post=Post::where('id','=' ,$id)->first();
        if($post!=null){
            $post->delete();
        }
        return redirect('posts');
    }

    public function show_hidden_posts(){
        $onlySoftDeleted = Post::onlyTrashed()->get();
//        foreach ($onlySoftDeleted as $key=>$post){
//            dd($post->users);
//        }
//        dump($onlySoftDeleted);
        return view('soft_posts',['onlySoftDeleted'=>$onlySoftDeleted]);
    }
}
