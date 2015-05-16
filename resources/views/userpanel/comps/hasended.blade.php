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
        <td>Aktīvs</td>
        <td>Komentāri</td>
        <td>Balsošana</td>
        <td>Status</td>
        <td>Beidzās</td>
        <td>Uzvarētāji</td>

      </tr>
   @foreach($comps as $index => $comp)
        <tr class="userline">
        <td>{{$index+1}}</td>
        <td><a href="/show/{{$comp->id}}" >{{$comp->title}}</a></td>
        @if($comp->status == 'a')
            <td><span class="beidzies">Nē</span></td>
        @else
            <td><span class="iesutisana">Jā</span></td>
        @endif
        <td>{{$comp->commentcount()}}</td>
        @if($comp->voting_type == 'b')
            <td>Balsošana</td>
        @else
            <td>Žūrija</td>
        @endif
            <td><span class="beidzies">Beidzies</span></td>
                <td>{{$comp->comp_end_date->format('d.m.Y.')}}</td>
                <td><a href="/comp/submitions/{{$comp->id}}"> {{$comp->winnercount()}}</a></td>

        </tr>
    @endforeach
    </table>
    </div>
  {!! $comps->appends(Request::except('page'))->render() !!}
    </div>
</article>
@stop