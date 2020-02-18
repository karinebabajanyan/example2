@extends('layouts.app')
​
@section('content')
    <div class="newPost">
        <h3>Edit Post</h3>
        <form method="post" action="{{ route('posts.update',['id'=>$post->id]) }}" enctype="multipart/form-data" id="form">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            {{--<input type="hidden" name="id" value="{{$post->id}}">--}}
            <label for="photo-upload" class="photo-upload-label">Upload</label>
            <input type="file" id="photo-upload" class="photo-input link-check" name="photo[]"   accept="image/*" multiple>
            @if ($errors->has('files'))
                <span class="help-block posts-help">
                    <strong>{{ $errors->first('files') }}</strong>
                </span>
            @endif
            <div class="img-upload-preview">
                @foreach($post->files as $k=>$image)
                    <div class="cc-selector-2 previewImage">
                        @if($image->category==='checked')
                            <input type="radio" name="check[id]" value="{{$image->id}}" id="img{{$image->id}}" checked>
                            {{--<input type="hidden" name="check[idOld][]" value="{{$image->id}}">--}}
                        @else
                            <input type="radio" name="check[id]" value="{{$image->id}}" id="img{{$image->id}}">
                            {{--<input type="hidden" name="check[idOld][]" value="{{$image->id}}">--}}
                        @endif
                        <label class="drinkcard-cc" for="img{{$image->id}}" style="background-image: url('{{$image->path}}')"></label>
                        {{--<img src="../photos/{{$image->image_upload}}" class="drinkcard-cc">--}}
                        <i class="deleteItem">x</i>
                        <input type="hidden" name="files[old_files][]" value="{{$image->id}}">
                    </div>
                @endforeach
            </div>
            @if ($errors->has('title'))
                <span class="help-block posts-help">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
            <input type="text" class="title" name="title" placeholder="Enter title here" value="{{$post->title}}">
            @if ($errors->has('description'))
                <span class="help-block posts-help">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
            <textarea class="description" name="description" rows="5" placeholder="Enter description">{{$post->description}}</textarea>
            <button type="submit" class="btn btn-success" id="save">Save</button>
            <a href="{{route('posts.index')}}" class="btn btn-danger cancel">Cancel</a>
        </form>
        ​
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/imageUpload.js') }}"></script>
@endsection