<!-- Šajā blade failā tiek attēlots lietotāja pašreizējais profils -->
<div class="profilebody">
    <h3>Profils</h3>
    <img src="{{$user->profile_img}}"/>
    <h4>{{$user->username}}</h4>
    @if($user->status == 1)
        <span class="user">Lietotājs</span>
    @else
        <span class="administrator">Adminsitrators</span>
    @endif
    <h5>{{$user->email}}</h5>
    @if($user->facebook)
        <a href="http://{{$user->facebook}}">Facebook</a>
    @endif
</div>
