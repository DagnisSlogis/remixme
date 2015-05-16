@extends('layout.main')
@section('content')
@include('userpanel.layout.UpSubmenu')
<article>
<div id="full">
    <div class="admin">
    <h3>Manas dziesmas</h3>
    @if(count($songs) > 0 )
        <table>
          <tr class="titlerow">
            <td>#</td>
            <td>Nosaukums</td>
            <td>Balsis</td>
            <td>Dziesma</td>
            <td>Konkurss</td>
            <td>Beidzās</td>
            <td>Dzēst</td>
          </tr>
       @foreach($songs as $index => $song)
           <tr class="userline">
            <td>{{$index+1}}</td>
            <td>{{$song->title}}</td>
            <td>{{$song->votes}}</td>
            <td><iframe width="100%" height="60" scrolling="no" frameborder="no"src="http://w.soundcloud.com/player/?url={{$song->link}}&auto_play=false&color=e45f56&theme_color=00FF00"></iframe></td>
            <td><a href="/show/{{$song->comp->id}}" >{{$song->comp->title}}</a></td>
            <td>{{$song->comp->comp_end_date->format('d.m.Y.')}}</td>
                    <td>
                        {!! Form::open (['method' => 'PATCH' ,'url' => 'comp/song/delete/'.$song->id])!!}
                            {!! Form::submit('Dzēst', ['class' => 'delete']) !!}
                        {!! Form::close() !!}
                    </td>
           </tr>
        @endforeach
        </table>
    @else
        <p>Nav neviena favorīt konkursa</p>
    @endif
    </div>
      {!! $songs->appends(Request::except('page'))->render() !!}
    </div>
</article>
@stop