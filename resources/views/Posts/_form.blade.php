@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error )
    <p> {{$error}}</p>
    @endforeach
</div>

@endif

<div class="form-group">
    <label for="">Post</label>
    <textarea name="content" rows="10" class="form-control">{{old('content',$post->content)}}</textarea>
    {{--need old and withInput but validate use withInput defoalt --}}
    <input type="file" value="{{$post->image}}" name="image" class="form-control">
</div>