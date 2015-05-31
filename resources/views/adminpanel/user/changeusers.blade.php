@extends('......layout.main')
@section('content')
@include('adminpanel.user.layout.submenu')
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
                            <td><h4>{{$user->username}}</h4></td>
                            <td class="email"><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                            <td>{{$user->created_at->format('d.m.Y.')}}</td>
                            @if($user->status == '1')
                                <td><span class="balsosana">Lietotājs</span></td>
                            @elseif($user->status == '2')
                                <td><span class="beidzies">Administrātors</span></td>
                            @endif
                            <td><a href="{{$user->facebook}}">{{$user->facebook}}</a></td>
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