@extends('layouts.app')

@section('content')
<hr>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box no-header clearfix">
                <div class="main-box-body clearfix">
                    <div class="table-responsive">
                        @if($errors->any())
                            <h4 style="color: #761c19">{{$errors->first()}}</h4>
                        @endif
                        @can('create',$auth)
                            <a href="{{route('users.create')}}" class="btn btn-light">Add</a>
                        @endcan
                        <table class="table user-list">
                            <thead>
                            <tr>
                                <th><span>User</span></th>
                                <th><span>Email</span></th>
                                <th><span>Role</span></th>
                                @can('update',$auth)
                                    <th><span>Edit</span></th>
                                @endcan
                                @can('delete',$auth)
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
                                        @can('update',$auth)
                                            <td>
                                                <a href="{{route('users.edit' , ['id' => $v->id])}}" class="btn btn-secondary">Edit</a>
                                            </td>
                                        @endcan
                                        @if($v->id!==$auth->id)
                                            @can('delete',$auth)
                                            <td>
                                                <a  class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter{{$v->id}}">Delete</a>
                                            </td>
                                            @endcan
                                                <div class="modal fade" id="exampleModalCenter{{$v->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <form action="{{ route('users.destroy',['id' => $v->id]) }}"  method="POST">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <div class="modal-body">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Are You Sure?</h5>
                                                                </div>
                                                                <div class="modal-body modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Yes</button>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                        @else
                                                <td></td>
                                        @endif
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