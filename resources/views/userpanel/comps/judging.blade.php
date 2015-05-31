@extends('layout.main')
@section('content')
@include('userpanel.comps.layout.submenu')
<article>
   <div id="full">
        <div class="admin">
            <h3>Vērtēšana</h3>
            @if (Session::has('flash_message'))
                <div class="alert alert-success">{{Session::get('flash_message')}}</div>
            @endif
            <table>
                <tr class="titlerow">
                    <td>#</td>
                    <td>Nosaukums</td>
                    <td>Piedalās</td>
                    <td>Beidzies</td>
                    <td>Vērtēt</td>
                </tr>
                @foreach($judgings as $index => $judging)
                    <tr class="userline">
                        @if($judgings->currentPage() == 1)
                            <td>{{$index+1}}</td>
                        @else
                            <td>{{($judgings->currentPage()-1)*10 + $index+1}}</td>
                        @endif
                        <td><a href="/show/{{$judging->id}}" >{{$judging->title}}</a></td>
                        <td><a href="/comp/submitions/{{$judging->id}}">{{$judging->entrycount()}} dziesmas</a></td>
                        <td>{{$judging->subm_end_date->format('d.m.Y.')}}</td>
                        <td>
                            {!! Form::open (['method' => 'GET' ,'url' => '/comp/judge/'.$judging->id])!!}
                            {!! Form::submit('Vērtēt', ['class' => 'accept']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
      {!! $judgings->appends(Request::except('page'))->render() !!}
    </div>
</article>
@stop