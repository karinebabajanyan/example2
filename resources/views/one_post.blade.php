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
                    {{--href="{{route('delete',['id' => $post->id])}}"--}}
                    @can('isAdmin')
                        <a class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Delete</a>
                    @else
                        @can('delete', $post)
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