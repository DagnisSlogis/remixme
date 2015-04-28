@if (Session::has('success_message'))
<div class="modalDialog">
	<div>
		<h2 class="success_message">Veiksmīgi!</h2>
		<p>{{Session::get('success_message')}}</p>
		<a class="closeModal" href="#"><button class="simplebtn">Aizvērt</button></a>
	</div>
</div>
@endif
@if (Session::has('error_message'))
<div class="modalDialog">
	<div>
		<h2 class="error_message">Kļūda</h2>
		<p>{{Session::get('error_message')}}</p>
		<a class="closeModal" href="#"><button class="simplebtn">Aizvērt</button></a>
	</div>
</div>
@endif