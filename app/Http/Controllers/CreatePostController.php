<?php

namespace App\Http\Controllers;

use App\Post;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CreatePostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function index()
    {
        return view('create_post');
    }
}
