<x-front-layout>
    <h3>Notifications</h3>
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
</x-front-layout>