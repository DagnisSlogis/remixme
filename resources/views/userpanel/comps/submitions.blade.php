@extends('layout.main')
@section('content')
@include('userpanel.comps.layout.submenu')
<article>
   <div id="full">
    <div class="admin">
    <h3>{{$header}}</h3>
    @if (Session::has('flash_message'))
        <div class="alert alert-success">{{Session::get('flash_message')}}</div>
        @endif
    <table>
      <tr class="titlerow">
        <td>#</td>
        <td>Nosaukums</td>
        <td>Remiks</td>
        <td>Dzēst</td>
      </tr>
   @foreach($submitions as $index => $submition)
        <tr class="userline">
        <td>{{$index+1}}</td>
        <td>{{$submition->title}}</td>
        <td><iframe width="100%" height="60" scrolling="no" frameborder="no"src="http://w.soundcloud.com/player/?url={{$submition->link}}&auto_play=false&color=e45f56&theme_color=00FF00"></iframe></td>
        <td>
            {!! Form::open (['method' => 'PATCH' ,'url' => 'comp/song/delete/'.$submition->id])!!}
                {!! Form::submit('Dzēst', ['class' => 'delete']) !!}
            {!! Form::close() !!}
        </td>
        </tr>
    @endforeach
    </table>
    </div>
  {!! $submitions->appends(Request::except('page'))->render() !!}
    </div>
</article>
@stop