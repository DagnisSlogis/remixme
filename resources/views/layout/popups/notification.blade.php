<div id="login-box" class="login-popup">
	<a href="#" class="close">x</a>
	<h2>Jaunumi</h2>
	<div class="notificationbox">
    @foreach($notifications as $notification)

        <a href="/show/{{$notification->comp_id}}"> <ul class="notificationLine">
        <li class="subject"  data-id="{{$notification->id}}">{{$notification->subject}}</li>
        <li>{{$notification->title}}</li>
        </ul></a>

    @endforeach
	</div>
	<button class="morenotifications"><a href="/userpanel/notification"><img src="{{ asset('/img/morenotif.png') }}">Visi jaunumi</a></button>
</div>
