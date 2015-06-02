@extends('layout.main')
@section('content')
@include('adminpanel.comps.layout.submenu')
<article>
   <div id="full">
       <div class="admin">
           <h3>{{$header}}</h3>
           @if(count($comps) > 0 )
               @if (Session::has('flash_message'))
                    <div class="alert alert-success">{{Session::get('flash_message')}}</div>
               @endif
               @foreach($comps as $index => $comp)
                    <table>
                        <tr class="titlerow">
                            <td>#</td>
                            <td>Nosaukums</td>
                            <td>Aktīvs</td>
                            <td>Komentāri</td>
                            <td>Balsošana</td>
                            <td>Status</td>
                            <td>Beidzās</td>
                        </tr>
                        <tr class="userline">
                        @if($comps->currentPage() == 1)
                            <td>{{$index+1}}</td>
                        @else
                            <td>{{($comps->currentPage()-1)*10 + $index+1}}</td>
                        @endif
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
                        </tr>
                        <table>
                            <tr class="wintitlerow">
                                <td>Vieta</td>
                                <td>Autors</td>
                                <td>Nosaukums</td>
                                <td>E-pasts</td>
                                <td>Dziesma</td>
                            </tr>
                            @foreach($comp->voting->winners as $winner)
                            <tr class="winnerline">
                                <td>{{$winner->place}}</td>
                                <td><h4>{{$winner->submition->user->username}}</h4></td>
                                <td>{{$winner->submition->title}}</td>
                                <td><a href="mailto:{{$winner->submition->user->email}}">{{$winner->submition->user->email}}</a></td>
                                <td><iframe width="100%" height="60" scrolling="no" frameborder="no"src="http://w.soundcloud.com/player/?url={{$winner->submition->link}}&auto_play=false&color=e45f56&theme_color=00FF00"></iframe></td>
                            </tr>
                            @endforeach
                        </table>
                    </table>
               @endforeach
           @else
                <p class="noentry">Neviens konkurss nav beidzies!</p>
           @endif
       </div>
    {!! $comps->appends(Request::except('page'))->render() !!}
    </div>
</article>
@stop