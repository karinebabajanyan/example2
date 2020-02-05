@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="form-group">
                <div class="col-sm-6 col-md-8">
{{--{{$provider}}--}}
                            <div class="avatar-wrapper">
                                <img class="profile-pic" src="{{$user->image}}" />
                                <div class="upload-button">
                                    <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                </div>
                                <form method="post" action="{{url('/profile')}}"  id="FrmImgUpload" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input class="file-upload" type="file" onchange="this.form.submit()" name="image" accept="image/*">
                                </form>
                            </div>
                    <h3>
                        {{$user->name}}
                    </h3>
                    <h4>
                        <i class="glyphicon glyphicon-envelope"></i>{{$user->email}}
                    </h4>
                </div>
            </div>
        </div>
    </div>
@endsection