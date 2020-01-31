@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($onlySoftDeleted as $key=>$post)
            <div class="well">
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="photos/{{$post->image_upload}}">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{$post->title}}</h4>
                        <p class="desc">{{$post->description}}</p>
                    </div>
                    <div class="text-right">
                        {{$post->users->name}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection