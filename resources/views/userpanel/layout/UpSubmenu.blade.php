<div id="submenu">
     <ul>
     	<li class="title">PROFILS: </li>
     	<li class="compnavl"><a href="/userpanel/comps">Mani konkursi</a></li>
     	<li class="compnavl
    	@if((Request::is('userpanel/favorite')))
            activesub
        @endif
     	"><a href="/userpanel/favorite">Favorīti</a></li>
     	<li class="compnavl
     	@if((Request::is('userpanel/mysongs')))
            activesub
         @endif
     	"><a href="/userpanel/mysongs">Manas Dziesmas</a></li>
     	<li class="compnavl
       	@if((Request::is('userpanel/profile/edit')))
           activesub
        @endif
     	"><a href="/userpanel/profile/edit">Labot Profilu</a></li>
     </ul>
</div>