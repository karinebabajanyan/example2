@extends('layouts.app')

@section('content')
    <div class="container">
        <p>
            <a href="{{route('posts.create')}}" class="btn btn-default">Add New Post</a>
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
                                <div id='myCarousel{{$key+1}}'  class="carousel slide" data-ride="carousel" style="max-width: 200px;">
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">

                                            @foreach($post->images as $k=>$image)
                                                @if($image->is_check===1)
                                                <div class="item active">
                                                    <img src="photos/{{$image->image_upload}}" class="media-object" style="width:100%;height: 100%">
                                                    {{--<img class="media-object" src="photos/{{$image->image_upload}}">--}}
                                                </div>
                                                @else
                                                <div class="item">
                                                    <img src="photos/{{$image->image_upload}}" class="media-object" style="width:100%;height: 100%">
                                                </div>
                                                @endif
                                            @endforeach
                                    </div>

                                    <!-- Left and right controls -->
                                    <a class="left carousel-control" href="#myCarousel{{$key+1}}" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel{{$key+1}}" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                            <div class="media-body">
                                <h4 class="media-heading">{{$post->title}}</h4>
                                <p class="desc">{{$post->description}}</p>
                                <p>
                                    <a href="{{route('posts.show',['id' => $post->id])}}">See More</a>
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
                            <div id="myCarousel2" class="carousel slide" data-ride="carousel" style="max-width: 200px;">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">

                                    @foreach($post->images as $key=>$image)
                                        @if($image->is_check===1)
                                            <div class="item active">
                                                <img src="photos/{{$image->image_upload}}" class="media-object" style="width:100%;height: 100%">
                                                {{--<img class="media-object" src="photos/{{$image->image_upload}}">--}}
                                            </div>
                                        @else
                                            <div class="item">
                                                <img src="photos/{{$image->image_upload}}" class="media-object" style="width:100%;height: 100%">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <!-- Left and right controls -->
                                <a class="left carousel-control" href="#myCarousel2" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel2" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{$post->title}}</h4>
                                <p class="desc">{{$post->description}}</p>
                                <p>
                                    <a href="{{route('posts.show',['id' => $post->id,'title'=>$post->title])}}">See More</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                @endforeach
            </div>
        </div>
    </div>
@endsection