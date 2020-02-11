<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\Image;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $all = Post::all();
        $my=$user->posts;
        return view('posts.index',['all_posts'=>$all,'my_posts'=>$my]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::where('id','=' ,$id)->first();
        $images=$post->images;
        return view('posts.show',['post'=>$post,'images'=>$images]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Post::where('id','=' ,$id)->where('user_id',Auth::user()->id)->first() || Gate::allows('isAdmin')){
            $post=Post::where('id','=' ,$id)->first();
            return view('posts.edit',['post'=>$post,]);
        }else{
            return redirect('posts');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required',
            'files' => 'required',
            'description'=>'required',
        ]);
//        $id=$request->get('id');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Post::where('id','=' ,$id)->where('user_id',Auth::user()->id)->first() || Gate::allows('isAdmin')) {
            $post = Post::where('id', '=', $id)->first();
            $images = $post->images;
            if ($post != null && $images != null) {
                $post->delete();
                foreach ($images as $key => $image) {
                    $image->delete();
                }
            }
            return redirect('posts');
        }else{
            return redirect('posts');
        }
    }
    /**
     * Remove the specified image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    public function soft_deleted_posts(){
        $onlySoftDeleted = Post::onlyTrashed()->get();
        return view('posts.soft',['onlySoftDeleted'=>$onlySoftDeleted]);
    }
}
