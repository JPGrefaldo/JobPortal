
	@if (session('register-success'))
	<div class="alert-success" role="alert">
		<strong> Thanks! </strong> {{ session('success') }}
	</div>
	@endif


	@if (session('profile-saved'))
	<div class="alert-success" role="alert">
		<strong> Success </strong> {{ session('profile-saved') }}
	</div>
	@endif