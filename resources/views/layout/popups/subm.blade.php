<div id="submit-box" class="submit-popup">
    <a href="#" class="close">x</a>
    <h3>Iesniegt dziesmu:</h3>
    {!! Form::open(['method' => 'POST','url' => '/submit/'.$comp->id]) !!}
        {!! Form::label('title' , 'Nosaukums') !!}
        {!! Form::text('title') !!}
        {!! Form::label('link' , 'Soundcloud adrese' ) !!}
        {!! Form::text('link' , null , ['class' => 'scLink' , 'data-id' => $comp->id ]) !!}
        <div class="scprev" data-id="{{$comp->id}}"></div>
        {!! Form::submit('Iesūtit' , ['class'=> 'submitbtn']) !!}
    {!! Form::close() !!}
</div>
