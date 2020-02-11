@extends('layouts.app')

@section('content')
<div class="newPost">
    <h3>Add New Post</h3>
    <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data" id="form">
        {{ csrf_field() }}
        <label for="photo-upload" class="photo-upload-label">Upload</label>
        <input type="file" id="photo-upload" class="photo-input link-check" name="photo[]"   accept="image/*" multiple>
        @if ($errors->has('files'))
            <span class="help-block posts-help">
                <strong>{{ $errors->first('files') }}</strong>
            </span>
        @endif
        <div class="img-upload-preview"></div>
        @if ($errors->has('title'))
            <span class="help-block posts-help">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
        <input type="text" class="title" name="title" placeholder="Enter title here">
        @if ($errors->has('description'))
            <span class="help-block posts-help">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
        <textarea class="description" name="description" rows="5" placeholder="Enter description"></textarea>
        <button type="submit" class="btn btn-success" id="save">Save</button>
        <a href="{{route('posts.index')}}" class="btn btn-danger cancel">Cancel</a>
    </form>

</div>
@endsection
@section('script')
    <script src="{{ asset('js/imageUpload.js') }}"></script>
@endsection