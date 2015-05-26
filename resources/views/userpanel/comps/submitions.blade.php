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
        <td>Autors</td>
        <td>Autora e-pasts</td>
        <td>Remiks</td>
        <td>Dzēst</td>
      </tr>
   @foreach($submitions as $index => $submition)
        <tr class="userline">
          @if($submitions->currentPage() == 1)
                            <td>{{$index+1}}</td>
                        @else
                             <td>{{($submitions->currentPage()-1)*10 + $index+1}}</td>
                        @endif
        <td><h4>{{$submition->title}}</h4></td>
        <td>{{$submition->user->username}}</td>
        <td><a href="mailto:{{$submition->user->email}}">{{$submition->user->email}}</a></td>
        <td><iframe width="100%" height="60" scrolling="no" frameborder="no"src="http://w.soundcloud.com/player/?url={{$submition->link}}&auto_play=false&color=e45f56&theme_color=00FF00"></iframe></td>
        <td>
           @if($submition->comp->subm_end_date < \Carbon\Carbon::now())
                ---
           @else
            {!! Form::open (['method' => 'PATCH' ,'url' => 'comp/song/delete/'.$submition->id])!!}
                {!! Form::submit('Dzēst', ['class' => 'delete']) !!}
            {!! Form::close() !!}
            @endif
        </td>
        </tr>
    @endforeach
    </table>
    </div>
  {!! $submitions->appends(Request::except('page'))->render() !!}
    </div>
</article>
@stop