<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Services\FileService;
use Auth;
use App\User;
use App\File;
use App\SocialIdentity;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Requests\Users\UserUpdateProfileImageRequest;
use App\Http\Requests\Users\UserCreateRequest;
use App\Http\Requests\Users\UserEditRequest;
use App\Http\Requests\Users\UserDestroyRequest;
use App\Http\Requests\Users\UserShowRequest;


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
    public function create(UserCreateRequest $request)
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $userModel=new User;
        User::create($request->only($userModel->getFillable()));
        return redirect('users');
    }

    /**
     * Display the specified user.
     *
     * @param  UserShowRequest $request
     * @return \Illuminate\Http\Response
     */
    public function user(UserShowRequest $request)
    {
        $user = Auth::user();
         return view('users.show',['user'=>$user]);
    }

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
    public function edit(User $user,UserEditRequest $request)
    {
        return view('users.edit',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
       $user->update([
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
    public function destroy(User $user, UserDestroyRequest $request)
    {
        if ($user->delete()) {
            $social = SocialIdentity::where('user_id', $user->id)->first();
            if ($social) {
                $social->delete();
            }
            $avatar=$user->cover_image;
            if($avatar){
                if (file_exists(public_path($avatar->path))) {
                    unlink(public_path($avatar->path));
                }
                $avatar->delete();
            }
            $posts=$user->posts;
            if($posts){
                foreach ($posts as $key => $post) {
                    $images=$post->files;
                    if($images){
                        foreach ($images as $k => $image) {
                            $image->delete();
                        }
                    }
                    $post->delete();
                }
            }
        }
        return redirect('users');
    }

    /**
     * Update the Profile Image in storage.
     *
     * @param  UserUpdateProfileImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfileImage(UserUpdateProfileImageRequest $request, FileService $fileService)
    {
        $image = $request->file('image');
        $user = auth()->user();
        $imageExists=$user->files()->where('category','cover')->first();
        if($imageExists){
            $imageExists->delete();
            $fileService->saveFile($image,$user,'cover');
        }else {
            $fileService->saveFile($image,$user,'cover');
        }
        return back()->with('success','Image Upload successful');
    }
}
