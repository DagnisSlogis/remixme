 <div id="submenu">
     <ul>
        <li class="title">LABOT LIETOTĀJU: </li>
        <li class="compnavl"><a href="/adminpanel/users">Visi lietotāji</a></li>
         {!! Form::open(['url' => '/adminpanel/user/find', 'method' => 'GET' , 'class' => 'searchform']) !!}
                {!! Form::text('s') !!}
                {!! Form::submit('Meklēt') !!}
            {!! Form::close() !!}
     </ul>
 </div>