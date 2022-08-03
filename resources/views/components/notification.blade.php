<a href="#" title="" class="not-box-open">
    <span><img src="{{asset('front/images/icon7.png')}}" alt=""></span>
    Notification
</a>
<div class="notification-box noti" id="notification">
    <div class="nt-title">
        <h4>Setting</h4>
        <a href="#" title="">Clear all</a>
    </div>
    @foreach($notifications as $notifacation)
    <div class="nott-list {{$notifacation->unread()? 'bg-info':'bg-white'}}">
        <div class="notfication-details">
            <div class="noty-user-img">
                <img src="{{$notifacation->data['image']}}" alt="">
            </div>
            <div class="notification-info">
                <h3><a href="{{route('notifications.show',$notifacation->id)}}" title="">{{$notifacation->data["body"]}}</a> {{$notifacation->data["title"]}}</h3>
                <span>{{$notifacation->created_at->diffForHumans()}}</span>
            </div>
        </div>
        @endforeach
        <div class="view-all-nots">
            <a href="{{route('notifications')}}" title="">View All Notification</a>
        </div>
    </div>
</div>