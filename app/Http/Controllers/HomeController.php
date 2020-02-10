<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('home',['user'=>$user]);
    }

    public function fileUpload(Request $request)
    {
        $this->validate($request, ['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);

        $image = $request->file('image');
        $new_name = rand().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $new_name);
        //database
//        if (Auth::check())
//        {
//            /**
//             * Послепроверкиужеможешьполучатьлюбоесвойствомодели
//             * пользователячерезфасад Auth, например id
//             */
//        }
        $user = Auth::user();
        if(file_exists(public_path($user->image))){
            unlink(public_path($user->image));
        }else{
            dd('File does not exists.');
        }
        //            dump($id);}
       $user->update(["image" => '/images/'.$new_name]);
        return back()->with('success','Image Upload successful')->with('path',$new_name);
    }
}
