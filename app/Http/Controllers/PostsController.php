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
        $my=$user->posts;
        return view('posts',['all_posts'=>$all,'my_posts'=>$my]);
    }

    public function create()
    {
        return view('create_post');
    }

    public  function save(Request $request){

        $this->validate($request,[
            'title' => 'required',
            'files' => 'required',
            'description'=>'required',
        ]);
            $images = $request->all()['files']["newfile"];
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
        return view('soft_posts',['onlySoftDeleted'=>$onlySoftDeleted]);
    }

    public function edit(Request $request){
        $id=(int)$request->id;
        $post=Post::where('id','=' ,$id)->first();
        return view('edit_post',['post'=>$post,]);
    }

    public function delete_image(Request $request){
        if($request->ajax()){
            $id_image=$request->id;
            $next_id=Image::where('id','>', $id_image)->orderBy('id')->take(1)->first();
            $post_id=Image::where('id', $id_image)->first()->post_id;
            $n_id=Image::where('post_id', $post_id)->first()->id;
            $image1=Image::where('id', $id_image)->where('is_check',1)->first();
            $image=Image::where('id', $id_image)->first();
            if($image1){
                if (Image::where('id', $id_image)->forcedelete()) {
//                    return $next_id;
                    if($next_id){
                        Image::where('id', $next_id->id)->update([
                            'is_check' => 1,
                        ]);
                    }else{
                        Image::where('id', $n_id)->update([
                            'is_check' => 1,
                        ]);
                    }
                    if(file_exists(public_path('photos/'.$image->image_upload))){
                        unlink(public_path('photos/'.$image->image_upload));
                        return 1;
                    }else{
                        return 0;
                    }
                }else{
                    return 0;
                }
            }else{
                if ($image->forcedelete()) {
                    if(file_exists(public_path('photos/'.$image->image_upload))){
                        unlink(public_path('photos/'.$image->image_upload));
                        return 2;
                    }else{
                        return 0;
                    }
                }else{
                    return 0;
                }
            }

        }
    }

    public function update(Request $request){
        $this->validate($request,[
            'title' => 'required',
            'files' => 'required',
            'description'=>'required',
        ]);
        $id=$request->get('id');
//        dd();
        Post::where('id',$id)->update([
            'title'=>$request->get('title'),
            'description'=>$request->get('description'),
        ]);
        Image::where('post_id',$id)->where('is_check',1)->update([
            'is_check'=>0,
        ]);
        if(isset($request->all()["files"]["newfile"])){
            $images = $request->all()['files']["newfile"];
            foreach ($images as $key=>$image){
                $input['imagename']=preg_replace('/[^\p{L}\p{N}\s]/u', '', bcrypt(time())).'.'.$image->getClientOriginalExtension();
//                dump($input['imagename']);
                $destinationPath=public_path('/photos');
                $image->move($destinationPath,$input['imagename']);
                if($image->getClientOriginalName()===$request->get('images')){
                    $image=new Image([
                        'image_upload'=>$input['imagename'],
                        'is_check'=>1,
                        'post_id'=>$id,
                    ]);
                    $image->save();

                }else{
                    $image=new Image([
                        'image_upload'=>$input['imagename'],
                        'is_check'=>0,
                        'post_id'=>$id,
                    ]);
                    $image->save();
                }
            }
        }
        if(isset($request->all()["files"]["old_files"])){
            $img_id=(int)$request->get('images');
            Image::where('id',$img_id)->update([
                'is_check'=>1,
            ]);
        }
        return redirect('posts');
    }
}
