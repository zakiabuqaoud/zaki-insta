<x-front-layout>
    <h3>post create</h3>
    <form action="/posts" method="post" enctype="multipart/form-data">
        @csrf
        @include("Posts._form", [
        "post" => new App\Models\Post(["content"=>"content"]) ])
        <button type="submit" class="btn btn-primary">create Post</button>
    </form>
</x-front-layout>