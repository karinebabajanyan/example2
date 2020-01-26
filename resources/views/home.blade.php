@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-8">
                <h3>
                    {{$user->name}}
                </h3>
                <h4>
                    <i class="glyphicon glyphicon-envelope"></i>{{$user->email}}
                </h4>
            </div>
        </div>
    </div>
@endsection