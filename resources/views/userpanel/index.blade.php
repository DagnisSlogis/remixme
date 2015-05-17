@extends('layout.main')
@section('content')
@include('userpanel.layout.UpSubmenu')
<article>
   <div id="full">
    <div class="userinfo">
    <div>
    <img src="{{ asset('/img/check.png') }}">
    <h4>Veiksmīgi izveidoti </h4>
    <span>{{$CompCount}}</span>
    <h4> konkursi</h4>
    </div>
    <div>
    <img src="{{ asset('/img/smile.png') }}">
    <h4>Priecīgi </h4>
    <span>{{$WinnerCount}}</span>
    <h4>uzvarētāji</h4></div>
    <div>
    <img src="{{ asset('/img/comments.png') }}">
    <h4>Interesanti </h4>
    <span>{{$YourComment}}</span>
        <h4>komentāri</h4></div>
    <div>
    <img src="{{ asset('/img/song.png') }}">
    <h4>Lieliski </h4>
    <span>{{$YourSubmitions}}</span>
    <h4>remiksi</h4>
    </div>
    </div>
    <div class="half">
    <div class="commentBox">
    <h3>Jaunākie komentāri</h3>
    @if(!$CompComments)
        <p class="nothingYet">Neviens nav pievienojis komentāru!</p>
    @else
    @foreach($CompComments as $comment)
        <div class="commentPrew">
            <img src="{{ asset($comment->user->profile_img)}}">
            <div class="metaData">
            <h4>{{$comment->user->username}} @ <a href="/show/{{$comment->comp->id}}">{{$comment->comp->title}}</a></h4>
            <span>{{$comment->created_at->diffForHumans()}}</span>
            </div>
            <p>{{$comment->text}}</p>
        </div>

        @endforeach
        @endif
    </div>
    </div>
    <div class="half">
    <div class="commentBox">
    <h3>Jaunākās iesūtītās dziesmas</h3>
    @if(!$CompEntrys)
        <p class="nothingYet">Neviens nav pievienojis dziesmu!</p>
    @else
        @foreach($CompEntrys as $subm)
        <div class="commentPrew">
                    <img src="{{ asset($subm->user->profile_img)}}">
                    <div class="metaData">
                    <h4>{{$subm->user->username}} @ <a href="/show/{{$subm->comp->id}}">{{$subm->comp->title}}</a></h4>
                    <span>{{$subm->created_at->diffForHumans()}}</span>
                    </div>
                    <p><iframe width="100%" height="60" scrolling="no" frameborder="no"src="http://w.soundcloud.com/player/?url={{$subm->link}}&auto_play=false&color=e45f56&theme_color=00FF00"></iframe></p>

                </div>
        @endforeach
    @endif
    </div>
    </div>
    </div>
</article>
@stop