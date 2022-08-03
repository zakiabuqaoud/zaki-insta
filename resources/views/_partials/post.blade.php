@php
$post->increment('views_number');
@endphp
<div class="posty mb-5">
    <div class="post-bar no-margin">
        <div class="post_topbar">
            <div class="usy-dt">
                <img height="30" src="{{ $post->user->profile->avatar_url}}" alt="">
                <div class="usy-name">
                    <h3>{{$post->user->name}}</h3>
                    <span><img src="{{asset('front/images/clock.png')}}" alt="">{{$post->created_at->diffForHumans()}}</span>
                </div>
            </div>
            <div class="ed-opts">
                <a href="#" title="" class="ed-opts-open"><i class="la la-ellipsis-v"></i></a>
                <ul class="ed-options">
                    <li><a href="/posts/{{$post->id}}/edit" title="">Edit Post</a></li>
                    <li>
                        <form action="/posts/{{$post->id}}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-link">delete</button>
                        </form><a href="#" title="">Hide</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="epi-sec">
            <ul class="descp">
                <li><img src="{{asset('front/images/icon8.png')}}" alt=""><span>Epic Coder</span></li>
                <li><img src="{{asset('front/images/icon9.png')}}" alt=""><span>India</span></li>
            </ul>
            <ul class="bk-links">
                <li><a href="#" title=""><i class="la la-bookmark"></i></a></li>
                <li><a href="#" title=""><i class="la la-envelope"></i></a></li>
            </ul>
        </div>
        <div class="job_descp">
            <h3>Senior Wordpress Developer</h3>
            <ul class="job-dt">
                <li><a href="#" title="">Full Time</a></li>
                <li><span>$30 / hr</span></li>
            </ul>
            @if($post->image)
            <div>
                <img src="{{asset('storage/' . $post->image)}}" alt="">
            </div>
            @endif
            <p>{{$post->content}}
                <a href="#" title="">view more({{$post->tags_count}})</a>
            </p>
            <ul class="skill-tags">
                @foreach($post->tags as $tag)
                <li><a href="#" title="">{{$tag->name}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="job-status-bar">
            <ul class="like-com">
                <li>
                    <a href="#"><i class="fas fa-heart"></i> Like</a>
                    <img src="{{asset('front/images/liked-img.png')}}" alt="">
                    <span>{{$post->likes}}</span>
                </li>
                <li><a href="#" class="com"><i class="fas fa-comment-alt"></i> Comment {{$post->comments_number}}</a></li>
            </ul>
            <a href="#"><i class="fas fa-eye"></i>Views {{$post->views_number}}</a>
        </div>
    </div>
    <div class="comment-section">
        <a href="#" class="plus-ic">
            <i class="la la-plus"></i>
        </a>
        <div class="comment-sec">
            <ul>
                @foreach($post->comments()->with('user')->get() as $comment)
                <li>
                    <div class="comment-list">
                        <div class="bg-img">
                            <img src="{{asset('front/images/resources/bg-img3.png')}}" alt="">
                        </div>
                        <div class="comment">
                            <h3>{{$comment->user->name}}</h3>
                            <span><img src="{{asset('front/images/clock.png')}}" alt="">{{$comment->created_at->diffForHumans()}}</span>
                            <p>{{$comment->content}}</p>
                            <a href="#" title=""><i class="fa fa-reply-all"></i>Reply</a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="post-comment">
            <div class="cm_img">
                <img src="{{Auth::user()->profile->avatarUrl}}" alt="">
            </div>
            <div class="comment_box">
                <form method="post" action="{{route('comments.store')}}">
                    @csrf
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <input type="text" name="content" placeholder="Post a comment">
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>