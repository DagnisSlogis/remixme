@extends('layout.main')
@section('content')
@include('adminpanel.comps.layout.submenu')
<article>
   <div id="full">
    <div class="admin">
    <h3>Neapstiprinātie konkursi</h3>
    @if (Session::has('flash_message'))
    <div class="alert alert-success">{{Session::get('flash_message')}}</div>
    @endif
    <table>
      <tr class="titlerow">
        <td>#</td>
        <td>Nosaukums</td>
        <td>Izveidojis</td>
        <td>Iesūta līdz</td>
        <td>Beidzās</td>
        <td>Vairāk</td>
        <td>Apstiprināt</td>
        <td>Noraidīt</td>
      </tr>
   @foreach($comps as $index => $comp)
        <tr class="userline">
          @if($comps->currentPage() == 1)
                            <td>{{$index+1}}</td>
                        @else
                             <td>{{($comps->currentPage()-1)*10 + $index+1}}</td>
                        @endif
        <td><a href="/show/{{$comp->id}}" >{{$comp->title}}</a></td>
        <td><h4>{{$comp->user->username}}</h4></td>
        <td>{{$comp->subm_end_date->format('d.m.Y.')}}</td>
        <td>{{$comp->comp_end_date->format('d.m.Y.')}}</td>
        <td><a href="/show/{{$comp->id}}" class="change" >Vairāk</a></td>
        <td>
            {!! Form::open (['method' => 'PATCH' ,'url' => '/adminpanel/comps/accept/'.$comp->id])!!}
                 {!! Form::submit('Apstiprināt', ['class' => 'accept']) !!}
            {!! Form::close() !!}
        </td>
        <td>
            {!! Form::open (['method' => 'PATCH' ,'url' => '/comps/delete/'.$comp->id])!!}
                {!! Form::submit('Noraidīt', ['class' => 'delete']) !!}
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