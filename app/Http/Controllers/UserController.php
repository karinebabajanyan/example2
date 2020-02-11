<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\SocialIdentity;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        $users=User::all();
        return view('users.index',['users'=>$users,'auth'=>$auth]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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

    /**
     * Update the created resource in storage post method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function update_user(Request $request){
//
//    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::where('id',$id)->first();
        return view('users.edit',['user'=>$user]);
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role'=>'required',
        ]);

        User::where('id',$id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'role'=>$request->role,
        ]);
        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        if ($user || !(Gate::allows('isAdmin'))) {
            $social = SocialIdentity::where('user_id', $id)->first();
            if ($user->delete()) {
                if ($social) {
                    if ($social->delete()) {
                        if (file_exists(public_path($user->image))) {
                            unlink(public_path($user->image));
                        }
                        foreach ($user->posts->all() as $key => $post) {
                            $post->delete();
                        }
                    }
                }
            }
            return redirect('users');
        }else{
            return redirect('users');
        }
    }
}
