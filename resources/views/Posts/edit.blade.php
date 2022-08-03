<x-front-layout>
    <h3>post edit</h3>
    <form action="/posts/{{$post->id}}" method="post">
        @csrf
        @method("put")
        @include("Posts._form")
        <button type="submit" class="btn btn-primary">update Post</button>
    </form>
</x-front-layout>