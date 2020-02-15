@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="form-group">
                <div class="col-sm-6 col-md-8">
                    <div class="avatar-wrapper">
                        @if($user->cover_image == null )
                            <img class="profile-pic" src="{{ asset('/files/users/user-avatar.png') }}" />
                        @else
                            <img class="profile-pic" src="{{$user->cover_image->path}}" />
                        @endif

                        <div class="upload-button">
                            <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                        </div>
                        <form method="post" action="{{route('users.update-profile-image')}}"  id="FrmImgUpload" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input class="file-upload" type="file" onchange="this.form.submit()" name="image" accept="image/*">
                        </form>
                    </div>
                    <h3>
                        {{ $user->name }}
                    </h3>
                    <h4>
                        <i class="glyphicon glyphicon-envelope"></i>{{ $user->email }}
                    </h4>
                </div>
            </div>
        </div>
    </div>
@endsection