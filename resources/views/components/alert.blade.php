@if(session()->has("flashMessage"))
<div class="alert alert-{{$type}}">
    {{session()->get("flashMessage")}}
</div>
@endif

{{--<div :neme="$type">{{$slot}}</div>--}}