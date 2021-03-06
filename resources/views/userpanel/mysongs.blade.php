@extends('layout.main')
@section('content')
@include('userpanel.layout.UpSubmenu')
<article>
    <div id="full">
        <div class="admin">
            <h3>Manas dziesmas</h3>
            @if (Session::has('flash_message'))
                <div class="alert alert-success">{{Session::get('flash_message')}}</div>
            @endif
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
                            @if($songs->currentPage() == 1)
                                <td>{{$index+1}}</td>
                            @else
                                <td>{{($songs->currentPage()-1)*10 + $index+1}}</td>
                            @endif
                            <td><h4>{{$song->title}}</h4></td>
                            <td>{{$song->votes}}</td>
                            <td><iframe width="100%" height="60" scrolling="no" frameborder="no"src="http://w.soundcloud.com/player/?url={{$song->link}}&auto_play=false&color=e45f56&theme_color=00FF00"></iframe></td>
                            <td><a href="/show/{{$song->comp->id}}" >{{$song->comp->title}}</a></td>
                            <td>{{$song->comp->comp_end_date->format('d.m.Y.')}}</td>
                            <td>
                                @if($song->comp->subm_end_date < \Carbon\Carbon::now())
                                    ---
                                @else
                                {!! Form::open (['method' => 'PATCH' ,'url' => 'comp/song/delete/'.$song->id])!!}
                                    {!! Form::submit('Dzēst', ['class' => 'delete']) !!}
                                {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="noentry">Nav neviena favorīt konkursa</p>
            @endif
        </div>
          {!! $songs->appends(Request::except('page'))->render() !!}
        </div>
</article>
@stop