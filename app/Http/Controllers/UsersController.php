<?php

namespace App\Http\Controllers;

use App\User;
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
        User::where('id',$request->id)->delete();
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
            'name' => 'required',
            'email' => 'required',
            'role'=>'required',
            'password'=>'required',
        ]);

        $user=new User([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'role'=>$request->get('role'),
            'password'=>bcrypt($request->get('password')),
        ]);
        $user->save();
        return redirect('users');
    }
}
