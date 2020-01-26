@extends('layouts.app')

@section('content')
    <div class="container">
        <p>
            <a href="{{route('create_post')}}" class="btn btn-default">Add New Post</a>
        </p>
        @foreach($posts as $key=>$post)
            <div class="well">
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="photos/{{$post->image_upload}}">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{$post->title}}</h4>
                        <p class="desc">{{$post->description}}</p>
                    </div>
                    <p>
                        <a href="{{route('one_post',['id' => $post->id,'title'=>$post->title])}}">See More</a>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@endsection