@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="well">
            <div class="media">
                <div id='myCarousel'  class="carousel slide" data-ride="carousel" style="max-width: 200px;">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">

                        @foreach($images as $k=>$image)
                            @if($image->is_check===1)
                                <div class="item active">
                                    <img src="../../photos/{{$image->image_upload}}" class="media-object" style="width:100%;height: 100%">
                                    {{--<img class="media-object" src="photos/{{$image->image_upload}}">--}}
                                </div>
                            @else
                                <div class="item">
                                    <img src="../../photos/{{$image->image_upload}}" class="media-object" style="width:100%;height: 100%">
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
                    {{--<img class="media-object" src="/photos/{{$post->image_upload}}">--}}
                {{--</a>--}}
                <div class="media-body">
                    <h4 class="media-heading">{{$post->title}}</h4>
                    <p>{{$post->description}}</p>
                </div>
                <p>
                    <a href="{{route('posts')}}" class="btn btn-info">Back</a>
                    {{--href="{{route('delete',['id' => $post->id])}}"--}}
                    @can('isAdmin')
                        <a href="{{route('edit',['id' => $post->id])}}" class="btn btn-default">Edit</a>
                        <a class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Delete</a>
                    @else
                        @can('delete', $post)
                            <a href="{{route('edit',['id' => $post->id])}}" class="btn btn-default">Edit</a>
                            <a class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Delete</a>
                        @endcan
                    @endcan
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Are You Sure?</h5>
                                </div>
                                <div class="modal-body modal-footer">
                                    <a href="{{route('delete',['id' => $post->id])}}" class="btn btn-primary">Yes</a>
                                    <a type="button" class="btn btn-secondary" data-dismiss="modal">No</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </p>
            </div>
        </div>
    </div>
@endsection