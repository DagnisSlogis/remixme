@extends('layout.main')
@section('content')
@include('userpanel.comps.layout.submenu')
<article>
   <div id="full">
        <div class="admin">
            <h3>Konkursa "{{$comp->title}}" vērtēšana</h3>
            @if (Session::has('flash_message'))
                <div class="alert">{{Session::get('flash_message')}}</div>
            @endif
            {!! Form::open (['method' => 'PATCH' ,'url' => 'comp/judge/update/'.$comp->id])!!}
            <table>
                <tr class="titlerow">
                    <td>#</td>
                    <td>Nosaukums</td>
                    <td>Autors</td>
                    <td>Remiks</td>
                    <td>Vieta</td>
                </tr>
                @foreach($submitions as $index => $submition)
                    <tr class="userline">
                        {!! Form::hidden('id'.$index , $submition->id) !!}
                        <td>{{$index+1}}</td>
                        <td><h4>{{$submition->title}}</h4></td>
                        <td><h4>{{$submition->user->username}}</h4></td>
                        <td><iframe width="100%" height="60" scrolling="no" frameborder="no"src="http://w.soundcloud.com/player/?url={{$submition->link}}&auto_play=false&color=e45f56&theme_color=00FF00"></iframe></td>
                        <td>
                            @if(count($submitions) >= 3)
                                {!! Form::selectRange('place'.$index , 0, 3 ) !!}
                            @else
                                {!! Form::selectRange('place'.$index , 0, count($submitions) ) !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
            {!! Form::submit('Saglabāt', ['class' => 'submitbtn']) !!}
            {!! Form::close() !!}
            <div class="clear"></div>
        </div>
    </div>
</article>
@stop