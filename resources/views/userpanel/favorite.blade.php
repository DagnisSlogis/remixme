@extends('layout.main')
@section('content')
@include('userpanel.layout.UpSubmenu')
<article>
<div id="full">
    <div class="admin">
    <h3>Favorīti</h3>
    @if(count($favorites) > 0 )
        <table>
          <tr class="titlerow">
            <td>#</td>
            <td>Konkursa nosaukums</td>
            <td>Piedalās</td>
            <td>Status</td>
            <td>Konkurss beigsies</td>
            <td>Dzēst</td>
          </tr>
       @foreach($favorites as $index => $favorite)
           <tr class="userline">
            <td>{{$index+1}}</td>
            <td>{{$favorite->comp->title}}</td>
            <td>10</td>
            @if($favorite->comp->subm_end_date >= \Carbon\Carbon::now())
                <td><span class="iesutisana">Remiksu iesūtīšna</span></td>
            @elseif($favorite->comp->subm_end_date < \Carbon\Carbon::now() && $favorite->comp->comp_end_date >= \Carbon\Carbon::now())
                <td><span class="balsosana">Notiek balsošana</span></td>
            @else
                <td><span class="beidzies">Konkurss ir beidzies</span></td>
            @endif
            @if($favorite->comp->comp_end_date >= \Carbon\Carbon::now())
                <td>{{$favorite->comp->comp_end_date->diffForHumans()}}</td>
            @else
                <td>---</td>
            @endif
            <td>
                    {!! Form::open (['method' => 'PATCH' ,'url' => '/userpanel/favorite/delete/'.$favorite->id ])!!}
                    {!! Form::submit('Dzēst', ['class' => 'delete']) !!}
                    {!! Form::close() !!}</td>
            </tr>
        @endforeach
        </table>
    @else
        <p>Nav neviena favorīt konkursa</p>
    @endif
    </div>
      {!! $favorites->appends(Request::except('page'))->render() !!}
    </div>
</article>
@stop