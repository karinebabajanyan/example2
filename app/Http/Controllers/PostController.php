<?php

namespace App\Http\Controllers;

use App\Http\Services\FileService;
use Auth;
use App\Post;
use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Posts\PostStoreRequest;
use App\Http\Requests\Posts\PostUpdateRequest;
use App\Http\Requests\Posts\PostEditRequest;
use App\Http\Requests\Posts\PostShowRequest;
use App\Http\Requests\Posts\PostDestroyRequest;
use App\Http\Requests\Posts\PostDeleteImageRequest;
use App\Http\Requests\Posts\PostSoftDeleteRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Post::all();
        $my=Auth::user()->posts;
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
    public function store(PostStoreRequest $request)
    {
        $images = $request->all()['files']["newfile"];
        $directoryPath=FileService::makeDirectory('posts');
        $id = auth()->id();
        $postModel=new Post;
        $request['user_id']=$id;
        $post=Post::create($request->only($postModel->getFillable()));
        foreach ($images as $key => $image) {
            $category=null;
            if($image->getClientOriginalName()===$request->get('images')) {
                $category='checked';
            }
            FileService::saveFile($image,$post->id,'posts',$directoryPath,$category);
        }
        return redirect('posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,PostShowRequest $request)
    {
        $post=Post::where('id','=' ,$id)->first();
        return view('posts.show',['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, PostEditRequest $request)
    {
        $post=Post::where('id','=' ,$id)->first();
        if($post) {
                return view('posts.edit',['post'=>$post,]);
        } else {
            return redirect('posts')->withErrors(["Post $id is not exists"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {
        Post::where('id',$id)->update([
            'title'=>$request->get('title'),
            'description'=>$request->get('description'),
        ]);

        File::where('fileable_id',$id)->where('fileable_type','posts')->where('category','checked')->update([
            'category'=>NULL,
        ]);

        if(isset($request->all()["files"]["newfile"])) {
            $images = $request->all()['files']["newfile"];
            $directoryPath=FileService::makeDirectory('posts');
            foreach ($images as $key => $image) {
                $category = null;
                if($image->getClientOriginalName() === $request->get('images')) {
                    $category = 'checked';
                }
                FileService::saveFile($image,$id,'posts',$directoryPath,$category);
            }
        }

        if(isset($request->all()["files"]["old_files"])) {
            $img_id=(int)$request->get('images');
            File::where('id',$img_id)->update([
                'category'=>'checked',
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
    public function destroy($id , PostDestroyRequest $request)
    {
            $post = Post::where('id', '=', $id)->first();
            if($post) {
                $images = $post->files;
                if($images) {
                    $post->delete();
                    foreach ($images as $key => $image) {
                        $image->delete();
                    }
                }
                return redirect('posts');
            } else {
                return redirect('posts')->withErrors(["Post $id is not exists"]);;
            }
    }
    /**
     * Remove the specified image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage(PostDeleteImageRequest $request)
    {
        if ($request->ajax()) {

            $id_image = $request->id;
            $file = File::where('id', $id_image)->first();
            $next = File::where('id', '>', $id_image)->where('fileable_type', 'posts')->orderBy('id')->take(1)->first();
            $post_id = $file->where('fileable_type', 'posts')->first()->fileable_id;
            if (!$next) {
                $next = File::where('fileable_id', $post_id)->where('fileable_type', 'posts')->first();
            }
            $image1 = File::where('id', $id_image)->where('category', 'checked')->first();
            if ($file->delete()) {
                if ($image1) {
                    File::where('id', $next->id)->update([
                        'category' => 'checked',
                    ]);
                    return 1;
                } else {
                    return 2;
                }
            } else {
                return 0;
            }
        }
    }

    /**
     * Display the specified Soft Deleted resource.
     *
     * @param  PostSoftDeleteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function softDeletedPosts(PostSoftDeleteRequest $request){
        $onlySoftDeleted = Post::onlyTrashed()->get();
        return view('posts.soft',['onlySoftDeleted'=>$onlySoftDeleted]);
    }
}
