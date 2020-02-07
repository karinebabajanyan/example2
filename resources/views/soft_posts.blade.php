@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($onlySoftDeleted as $key=>$post)
            <div class="well">
                <div class="media">
                    <div id='myCarousel'  class="carousel slide" data-ride="carousel" style="max-width: 200px;">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">

                            @foreach($post->trashed_images as $k=>$image)
                                @if($k===0)
                                    <div class="item active">
                                        <img src="../../photos/{{$image->image_upload}}" class="media-object" style="width:100%;">
                                        {{--<img class="media-object" src="photos/{{$image->image_upload}}">--}}
                                    </div>
                                @else
                                    <div class="item">
                                        <img src="../../photos/{{$image->image_upload}}" class="media-object" style="width:100%;">
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    {{--<a class="pull-left" href="#">--}}
                        {{--<img class="media-object" src="photos/{{$post->image_upload}}">--}}
                    {{--</a>--}}
                    <div class="media-body">
                        <h4 class="media-heading">{{$post->title}}</h4>
                        <p class="desc">{{$post->description}}</p>
                    </div>
                    @if(($post->users))
                    <div class="text-right">
                        {{$post->users->name}}
                    </div>
                        @else
                        <div class="text-right">
                           Deleted User
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection