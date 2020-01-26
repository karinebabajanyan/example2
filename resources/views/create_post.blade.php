@extends('layouts.app')

@section('content')
<div class="newPost">
    <h3>Add New Post</h3>
    <form method="post" action="{{ url('save_post') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="avatar-upload">
            <div class="avatar-edit">
                <input type='file' id="imageUpload" name="upload" accept=".png, .jpg, .jpeg" />
                <label for="imageUpload"></label>
            </div>
            <div class="avatar-preview">
                <div id="imagePreview">
                </div>
            </div>
        </div>
    <input type="text" class="title" name="title" placeholder="Enter title here">
    <textarea class="description" name="description" rows="5" placeholder="Enter description"></textarea>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{route('posts')}}" class="btn btn-danger cancel">Cancel</a>
        </form>

</div>
@endsection