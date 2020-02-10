@extends('layouts.app')
​
@section('content')
    <div class="newPost">
        <h3>Add New Post</h3>
        <form method="post" action="{{ url('update_post') }}" enctype="multipart/form-data" id="form">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{$post->id}}">
            <label for="photo-upload" class="photo-upload-label">Upload</label>
            <input type="file" id="photo-upload" class="photo-input link-check" name="photo[]"   accept="image/*" multiple>
            <div class="img-upload-preview">
                @foreach($post->images as $k=>$image)
                    <div class="cc-selector-2 previewImage">
                        @if($image->is_check===1)
                            <input type="radio" name="images" value="{{$image->id}}" id="img{{$image->id}}" checked>
                        @else
                            <input type="radio" name="images" value="{{$image->id}}" id="img{{$image->id}}">
                        @endif
                        <label class="drinkcard-cc" for="img{{$image->id}}" style="background-image: url('../photos/{{$image->image_upload}}')"></label>
                        {{--<img src="../photos/{{$image->image_upload}}" class="drinkcard-cc">--}}
                        <i class="deleteItem">x</i>
                        <input type="hidden" name="files[old_files][]" value="{{$image->id}}">
                    </div>
                @endforeach
            </div>
            <input type="text" class="title" name="title" placeholder="Enter title here" value="{{$post->title}}">
            <textarea class="description" name="description" rows="5" placeholder="Enter description">{{$post->description}}</textarea>
            <button type="submit" class="btn btn-success" id="save">Save</button>
            <a href="{{route('posts')}}" class="btn btn-danger cancel">Cancel</a>
        </form>
        ​
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/imageUpload.js') }}"></script>
@endsection