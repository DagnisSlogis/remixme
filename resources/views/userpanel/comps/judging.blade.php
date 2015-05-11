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
        <td>Beidzies</td>
        <td>Vērtēt</td>
      </tr>
   @foreach($judgings as $index => $judging)
        <tr class="userline">
        <td>{{$index+1}}</td>
        <td>{{$judging->title}}</td>
        <td>{{$judging->subm_end_date}}</td>
        <td>
                    {!! Form::open (['method' => 'PATCH' ,'url' => '/comps/delete/'.$judging->id])!!}
                        {!! Form::submit('Vērtēt', ['class' => 'delete']) !!}
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