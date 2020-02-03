@extends('layouts.app')

@section('content')
    <div class="container">
        <p>
            <a href="{{route('create_post')}}" class="btn btn-default">Add New Post</a>
        </p>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#all">All Posts</a></li>
            <li><a data-toggle="tab" href="#my">My Posts</a></li>
        </ul>
        <div class="tab-content">
            <div id="all" class="tab-pane fade in active">
                @foreach($all_posts as $key=>$post)
                    <div class="well">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="photos/{{$post->image_upload}}">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">{{$post->title}}</h4>
                                <p class="desc">{{$post->description}}</p>
                                <p>
                                    <a href="{{route('one_post',['id' => $post->id,'title'=>$post->title])}}">See More</a>
                                </p>
                                <p>
                                    @can('isAdmin')
                                        <a href="{{route('delete',['id' => $post->id])}}" class="btn btn-danger">Delete</a>
                                    @else
                                        @can('delete', $post)
                                            <a href="{{route('delete',['id' => $post->id])}}" class="btn btn-danger">Delete</a>
                                        @endcan
                                    @endcan

                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="my" class="tab-pane fade">
                @foreach($my_posts as $key=>$post)
                    <div class="well">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="photos/{{$post->image_upload}}">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">{{$post->title}}</h4>
                                <p class="desc">{{$post->description}}</p>
                                <p>
                                    <a href="{{route('one_post',['id' => $post->id,'title'=>$post->title])}}">See More</a>
                                </p>
                                <p>
                                    @can('isAdmin')
                                        <a href="{{route('delete',['id' => $post->id])}}" class="btn btn-danger">Delete</a>
                                    @else
                                        @can('delete', $post)
                                            <a href="{{route('delete',['id' => $post->id])}}" class="btn btn-danger">Delete</a>
                                        @endcan
                                    @endcan

                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection