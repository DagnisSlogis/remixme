@extends('layout.main')
@section('content')
@include('userpanel.layout.UpSubmenu')
<article>
    <div id="full">
        <div class="admin">
            <h3>Jaunumi</h3>
                <table>
                    <tr class="titlerow">
                        <td>#</td>
                        <td>Jaunums</td>
                        <td>Konkurss</td>
                        <td>Noticis</td>
                    </tr>
                    @foreach($notifications as $index => $notification)
                        <tr class="userline">
                            @if($notifications->currentPage() == 1)
                                <td>{{$index+1}}</td>
                            @else
                                <td>{{($notifications->currentPage()-1)*10 + $index+1}}</td>
                            @endif
                            <td>{{$notification->subject}}</td>
                            <td><a href="/show/{{$notification->comp->id}}">{{$notification->title}}</a></td>
                            @if($notification->show_date)
                                <td>{{$notification->show_date->diffForHumans()}}</td>
                            @else
                                <td>{{$notification->created_at->diffForHumans()}}</td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
          {!! $notifications->appends(Request::except('page'))->render() !!}
        </div>
</article>
@stop