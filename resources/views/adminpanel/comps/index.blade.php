@extends('layout.main')
@section('content')
@include('adminpanel.comps.layout.submenu')
<article>
   <div id="full">
    <div class="admin">
    <h3>Pašlaik notiek</h3>
    @if (Session::has('flash_message'))
    <div class="alert alert-success">{{Session::get('flash_message')}}</div>
    @endif
    <table>
      <tr class="titlerow">
        <td>#</td>
        <td>Nosaukums</td>
        <td>Izveidojis</td>
        <td>Balsošana</td>
        <td>Iesūta līdz</td>
        <td>Beidzās</td>
        <td>Iesūtīts</td>
        <td>Labot</td>
        <td>Dzēst</td>
      </tr>
   @foreach($comps as $index => $comp)
        <tr class="userline">
        <td>{{$index+1}}</td>
        <td>{{$comp->title}}</td>
        <td>{{$comp->user->username}}</td>
        @if($comp->voting_type == 'b')
            <td>Balsošana</td>
            @else
                <td>Žūrija</td>
        @endif
        <td>{{$comp->subm_end_date->format('d.m.Y.')}}</td>
        <td>{{$comp->comp_end_date->format('d.m.Y.')}}</td>
        <td>10</td>
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