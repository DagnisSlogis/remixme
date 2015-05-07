@extends('layout.main')
@section('content')
@include('userpanel.comps.layout.submenu')
<article>
   <div id="full">
    <div class="admin">
    <h3>{{$header}}</h3>
    <table>
      <tr class="titlerow">
        <td>#</td>
        <td>Nosaukums</td>
        <td>Aktīvs</td>
        <td>Komentāri</td>
        <td>Balsošana</td>
        <td>Status</td>
        <td>Beidzās</td>
        <td>Iesūtīts</td>
        <td>Labot</td>
        <td>Dzēst</td>
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
        <td>{{count($comp->comments)}}</td>
        @if($comp->voting_type == 'b')
            <td>Balsošana</td>
        @else
            <td>Žūrija</td>
        @endif
        @if($comp->subm_end_date >= \Carbon\Carbon::now())
            <td><span class="iesutisana">Iesūtīšna</span></td>
        @elseif($comp->subm_end_date < \Carbon\Carbon::now() && $comp->comp_end_date >= \Carbon\Carbon::now())
            <td><span class="balsosana">Balsošana</span></td>
        @else
            <td><span class="beidzies">Beidzies</span></td>
        @endif
                <td>{{$comp->comp_end_date->format('d.m.Y.')}}</td>
                <td>{{count($comp->submitions->active)}}</td>
                <td><a href="/adminpanel/{{$comp->id}}/edit" class="change" >Labot</a></td>
                <td>
                    {!! Form::open (['method' => 'PATCH' ,'url' => '/adminpanel/comps/delete/'.$comp->id])!!}
                        {!! Form::submit('Dzēst', ['class' => 'delete']) !!}
                    {!! Form::close() !!}
                </td>
        </tr>
    @endforeach
    </table>
    </div>
  {!! $comps->appends(Request::except('page'))->render() !!}
    </div>
</article>
@stop