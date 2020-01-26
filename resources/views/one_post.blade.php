@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="well">
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="/photos/{{$post->image_upload}}">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{$post->title}}</h4>
                    <p>{{$post->description}}</p>
                </div>
                <p>
                    <a href="{{route('posts')}}" class="btn btn-info">Back</a>
                </p>
            </div>
        </div>
    </div>
@endsection