
	@if (session('register-success'))
	<div class="alert-success" role="alert">
		<strong> Thanks! </strong> {{ session('success') }}
	</div>
	@endif
