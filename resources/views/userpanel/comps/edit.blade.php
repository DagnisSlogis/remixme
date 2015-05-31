@extends('layout.main')
@section('content')
<article>
	<div id="comprow">
        <div id="register">
            <div class="centerblock">
                <h3>Labot konkursu: {{$comp->title}}</h3>
                @if (Session::has('flash_message'))
                    <div class="alert">{{Session::get('flash_message')}}</div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert">
                        <strong>Ups!</strong> Jūsu ievadītie dati neatbilst prasītajam formātam.<br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                    </div>
                @endif
                {!! Form::model($comp , ['method' => 'PATCH', 'url' => '/comp/'.$comp->id ,'files' => true , 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::label('title' , 'Konkursa nosaukums') !!} <span class="needed">*</span>
                        {!! Form::text('title' ) !!}
                        <div class="one-line small-form">
                        {!! Form::label('preview_type' , 'Dziema atrodama') !!} <span class="needed">*</span>
                        {!! Form::select('preview_type', array('y' => 'Youtube', 's' => 'Soundcload')) !!}
                        </div>
                        <div class="one-line medium-form">
                        {!! Form::label('preview_link' , 'Adrese') !!} <span class="needed">*</span>
                        {!! Form::text('preview_link') !!}
                        </div>
                        <div class="clear"></div>
                        {!! Form::label('description' , 'Apraksts') !!} <span class="needed">*</span>
                        {!! Form::textarea('description') !!}

                        {!! Form::label('rules' , 'Noteikumi') !!} <span class="needed">*</span>
                        {!! Form::textarea('rules') !!}

                        {!! Form::label('prizes' , 'Balvas') !!} <span class="needed">*</span>
                        {!! Form::textarea('prizes' ) !!}

                        {!! Form::label('header_img' , 'Konkursa galvene') !!} <span class="needed">*</span>
                        <div id="headerPreview"></div>
                        {!! Form::file('header_img' , ['id' => 'headerFile']) !!}
                        {!! Form::label('song_title' , 'Dziesmas nosaukums') !!} <span class="needed">*</span>
                        {!! Form::text('song_title' ) !!}
                        <div class="one-line">
                        {!! Form::label('genre' , 'Žanrs') !!}
                        {!! Form::text('genre' ) !!}
                        </div>
                        <div class="one-line">
                        {!! Form::label('bpm' , 'Temps') !!}
                        {!! Form::text('bpm' ) !!}
                        </div>
                        <div class="clear"></div>
                        {!! Form::label('stem_link' , 'Remiksa daļu lejupielādes adrese') !!} <span class="needed">*</span>
                        {!! Form::text('stem_link' ) !!}

                        {!! Form::label('url' , 'Konkursa mājaslapa') !!}
                        {!! Form::text('url' ) !!}
                        <div class="one-line">
                        {!! Form::label('facebook' , 'Facebook adrese') !!}
                        {!! Form::text('facebook' ) !!}
                        </div>
                        <div class="one-line">
                        {!! Form::label('twitter' , 'Twitter adrese') !!}
                        {!! Form::text('twitter' ) !!}
                        </div>
                        <div class="clear"></div>
                        <p class="neededinput"><span class="needed">*</span> - Aizpildāmi obligāti</p>
                        {!! Form::submit('Labot' , ['class'=> 'btnadd']) !!}
                    {!! Form::close() !!}
                </div>
        </div>
	</div>
	<div id="sidebarrow">
	    @include('layout.sidebar')
	</div>
</article>
@stop