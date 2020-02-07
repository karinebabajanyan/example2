<?php

namespace App\Http\Controllers;

use App\Post;
use App\Image;
use Auth;
use GuzzleHttp\Psr7\Response;
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
            'newfile' => 'required',
            'description'=>'required',
        ]);
            $images = $request->all()["newfile"];
            $id = Auth::user()->id;
            $post=new Post([
                'title'=>$request->get('title'),
                'description'=>$request->get('description'),
                'user_id'=>$id,
            ]);
            $post->save();
            foreach ($images as $key=>$image){
                $input['imagename']=preg_replace('/[^\p{L}\p{N}\s]/u', '', bcrypt(time())).'.'.$image->getClientOriginalExtension();
//                dump($input['imagename']);
                $destinationPath=public_path('/photos');
                $image->move($destinationPath,$input['imagename']);
                if($image->getClientOriginalName()===$request->get('images')){
                    $image=new Image([
                        'image_upload'=>$input['imagename'],
                        'is_check'=>1,
                        'post_id'=>$post->id,
                    ]);
                    $image->save();

                }else{
                   $image=new Image([
                        'image_upload'=>$input['imagename'],
                        'is_check'=>0,
                        'post_id'=>$post->id,
                    ]);
                    $image->save();
                }
            }
        return redirect('posts');
    }

    public function one_post(Request $request)
    {
        $id=(int)$request->id;
        $post=Post::where('id','=' ,$id)->first();
        $images=$post->images;
//        dd($images);
        return view('one_post',['post'=>$post,'images'=>$images]);
    }

    public function delete(Request $request){
        $id=(int)$request->id;
        $post=Post::where('id','=' ,$id)->first();
        $images=$post->images;
//        dd($images);
        if($post!=null && $images!=null){
            $post->delete();
            foreach ($images as $key=>$image){
                $image->delete();
            }
        }
        return redirect('posts');
    }

    public function show_hidden_posts(){
        $onlySoftDeleted = Post::onlyTrashed()->get();
//        foreach ($onlySoftDeleted as $key=>$post){
//            $images[]= $post->trashed_images;
//        }
//        dd($images);
//        foreach ($images as )
//        dump($onlySoftDeleted);
        return view('soft_posts',['onlySoftDeleted'=>$onlySoftDeleted]);
    }
}
