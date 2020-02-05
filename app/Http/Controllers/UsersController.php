<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\SocialIdentity;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $auth = Auth::user();
        $users=User::all();
        return view('users',['users'=>$users,'auth'=>$auth]);
    }

    public function edit(Request $request){
        $user=User::where('id',$request->id)->first();
        return view('edit_user',['user'=>$user]);
    }
    public function delete(Request $request){
        $user=User::where('id',$request->id)->first();
        $social=SocialIdentity::where('user_id',$request->id)->first();
        if ($user->delete()) {
            if($social->delete()) {
                if(file_exists(public_path($user->image))){
                    unlink(public_path($user->image));
                }else{
                    dd('File does not exists.');
                }
                foreach ($user->posts->all() as $key => $post) {
                    $post->delete();
                }
            }
        }
        return redirect('users');
    }
    public function add(){
        return view('add_user');
    }
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'role'=>'required',
        ]);
        User::where('id',$request->get('id'))->update([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'role'=>$request->get('role'),
        ]);
        return redirect('users');
    }
    public function add_store (Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'=>'required',
        ]);
        $user=new User([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'role'=>$request->get('role'),
            'password'=>bcrypt($request->get('password')),
            'confirmed_at'=>date("Y-m-d h:i:s", time()),
        ]);
        $user->save();
        return redirect('users');
    }
}
