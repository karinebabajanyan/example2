@extends('layouts.app')

@section('content')
<hr>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box no-header clearfix">
                <div class="main-box-body clearfix">
                    <div class="table-responsive">
                        @can('isAdmin')
                            <a href="{{route('add_user')}}" class="btn btn-light">Add</a>
                        @endcan
                        <table class="table user-list">
                            <thead>
                            <tr>
                                <th><span>User</span></th>
                                <th><span>Email</span></th>
                                <th><span>Role</span></th>
                                @can('isAdmin')
                                    <th><span>Edit</span></th>
                                    <th><span>Delete</span></th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $k=>$v)
                                @if($v->id!=$auth->id)
                                    <tr>
                                        <td>
                                            <span class="user-subhead">{{$v->name}}</span>
                                        </td>
                                        <td>
                                            <span>{{$v->email}}</span>
                                        </td>
                                        <td>
                                            <span>{{$v->role}}</span>
                                        </td>
                                        @can('isAdmin')
                                            <td>
                                                <a href="{{route('edit_user' , ['id' => $v->id])}}" class="btn btn-secondary">Edit</a>
                                            </td>
                                            <td>
                                                <a href="{{route('delete_user',['id' => $v->id])}}" class="btn btn-dark">Delete</a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection