@extends('layout.main')
@section('content')
@include('userpanel.comps.layout.submenu')
<article>
   <div id="full">
    <div class="admin">
    <h3>Balsošana</h3>
    @if (Session::has('flash_message'))
        <div class="alert alert-success">{{Session::get('flash_message')}}</div>
        @endif
    <table>
      <tr class="titlerow">
        <td>#</td>
        <td>Nosaukums</td>
        <td>Piedalās</td>
        <td>Beigsies</td>
        <td>Apstiprināt</td>
      </tr>
   @foreach($votings as $index => $voting)
        <tr class="userline">
          @if($votings->currentPage() == 1)
                            <td>{{$index+1}}</td>
                        @else
                             <td>{{($votings->currentPage()-1)*10 + $index+1}}</td>
                        @endif
        <td><a href="/show/{{$voting->id}}" >{{$voting->title}}</a></td>
        <td><a href="/comp/submitions/{{$voting->id}}">{{$voting->entrycount()}}</a></td>
         @if($voting->voting->show_date <= \Carbon\Carbon::now())
            <td><span class="beidzies">Beidzies</span></td>
            <td>
                {!! Form::open (['method' => 'GET' ,'url' => '/comp/voting/accept/'.$voting->id])!!}
                     {!! Form::submit('Apstiprināt', ['class' => 'accept']) !!}
                {!! Form::close() !!}
            </td>
        @else
            @if($voting->entrycount() == 0 && $voting->subm_end_date < \Carbon\Carbon::now())
                        <td>{{$voting->comp_end_date->diffForHumans()}}</td>
                        <td>{!! Form::open (['method' => 'GET' ,'url' => '/comp/voting/accept/'.$voting->id])!!}
                                                 {!! Form::submit('Apstiprināt', ['class' => 'accept']) !!}
                                            {!! Form::close() !!}</td>
            @else
            <td>{{$voting->comp_end_date->diffForHumans()}}</td>
                        <td>---</td>
            @endif
        @endif
        </tr>
    @endforeach
    </table>
    </div>
  {!! $votings->appends(Request::except('page'))->render() !!}
    </div>
</article>
@stop