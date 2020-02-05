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
                                        @if($v->role!=="Admin")
                                            <td>
                                                <a  class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">Delete</a>
                                            </td>
{{--//href="{{route('delete_user',['id' => $v->id])}}"--}}
                                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">Are You Sure?</h5>
                                                            </div>
                                                            <div class="modal-body modal-footer">
                                                                <a href="{{route('delete_user',['id' => $v->id])}}" class="btn btn-primary">Yes</a>
                                                                <a type="button" class="btn btn-secondary" data-dismiss="modal">No</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endif
                                        @endcan
                                    </tr>
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