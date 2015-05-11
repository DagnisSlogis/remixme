@extends('......layout.main')
@section('content')
 <div id="submenu">
 <ul>
 	<li class="title">LABOT LIETOTĀJU: </li>
 	<li class="compnavl"><a href="/adminpanel/users">Visi Lietotāji</a></li>
    <li>
    {!! Form::open(['url' => '/adminpanel/user/find', 'method' => 'GET' , 'class' => 'searchform']) !!}
        {!! Form::text('s') !!}
        {!! Form::submit('Meklēt') !!}
    {!! Form::close() !!}
    </li>
 </ul>
 </div>
 <article>
    <div id="full">
    <div class="admin">
    <h3>Visi lietotāji</h3>
    @if (Session::has('flash_message'))
    <div class="alert alert-success">{{Session::get('flash_message')}}</div>
    @endif
    <table>
      <tr class="titlerow">
        <td>#</td>
        <td>Lietotājvārds</td>
        <td>E-pasts</td>
        <td>Reģistrēts</td>
        <td>Status</td>
        <td>Facebook adrese</td>
        <td>Labot</td>
        <td>Dzēst</td>
      </tr>
   @foreach($users as $user)
   @if($user->status != '3')
       <tr class="userline">
        <td><img src="{{$user->profile_img}}"/> </td>
        <td>{{$user->username}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->created_at}}</td>
        @if($user->status == '1')
            <td>Lietotājs</td>
            @elseif($user->status == '2')
                <td>Administrātors</td>
         @endif
        <td>{{$user->facebook}}</td>
        <td><a href="/adminpanel/user/{{$user->id}}/edit" class="change" >Labot</a></td>
        <td>
        {!! Form::open (['method' => 'PATCH' ,'url' => '/adminpanel/user/delete/'.$user->id ])!!}
        {!! Form::submit('Dzēst', ['class' => 'delete']) !!}
        {!! Form::close() !!}</td>

        </tr>
    @endif
    @endforeach
    </table>
    </div>
  {!! $users->appends(Request::except('page'))->render() !!}
    </div>
 </article>
 @stop