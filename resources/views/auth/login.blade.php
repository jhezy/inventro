<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<title>Login &mdash; {{ config('app.name') }}</title>

	<!-- Bootstrap & FontAwesome -->
	<link rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('assets/fontawesome/css/all.css') }}">

	<style>
		body {
			font-family: 'Inter', sans-serif;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			background: url("../assets/img/unsplash/bg.jpg") center/cover no-repeat;
			position: relative;
		}

		.login-wrapper {
			width: 100%;
			max-width: 420px;
			background: rgba(255, 255, 255, 0.15);
			backdrop-filter: blur(5px);
			border-radius: 20px;
			padding: 40px 30px;
			box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
			color: #fff;
		}

		.login-wrapper h4 {
			font-weight: 700;
			margin-bottom: 10px;
		}

		.login-wrapper p {
			font-size: 14px;
			color: rgba(255, 255, 255, 0.8);
		}

		.form-control {
			border-radius: 12px;
			border: none;
			padding: 12px 16px;
			background: rgba(255, 255, 255, 0.2);
			color: #fff;
		}

		.form-control::placeholder {
			color: rgba(255, 255, 255, 0.7);
		}

		.form-control:focus {
			box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.3);
			background: rgba(255, 255, 255, 0.25);
		}

		.input-group-text {
			background: rgba(255, 255, 255, 0.2);
			border: none;
			color: #fff;
			border-radius: 0 12px 12px 0;
		}

		.btn-login {
			width: 48%;
			border-radius: 12px;
			padding: 12px;
			font-weight: 600;
			border: none;
			transition: all 0.3s ease;
		}

		.btn-login:hover {
			background: #f0f0f0;
		}

		.footer-text {
			font-size: 13px;
			text-align: center;
			margin-top: 20px;
			color: rgba(255, 255, 255, 0.8);
		}

		.d-flex-gap {
			display: flex;
			gap: 10px;
		}

		.forgot-password {
			font-size: 13px;
			color: rgba(255, 255, 255, 0.8);
			display: block;
			margin-top: 5px;
			text-decoration: underline;
		}
	</style>
</head>

<body>
	<div class="login-wrapper d-flex flex-column align-items-center justify-content-center text-center">
		<!-- Logo -->
		<img src="{{ asset('assets/img/swg.png') }}" alt="Logo"
			class="rounded mb-3"
			style="height: 100px; width: auto; object-fit: contain;">

		<!-- Judul -->
		<h4 class="mb-4 text-white">Selamat Datang</h4>

		@include('utilities.alert')

		<form method="POST" action="{{ route('login') }}" class="needs-validation w-100" novalidate style="max-width: 350px;">
			@csrf
			<div class="mb-3">
				<input id="email" type="email"
					class="form-control @error('email') is-invalid @enderror"
					name="email" placeholder="Email..." value="{{ old('email') }}" required autofocus>
				@error('email')
				<div class="invalid-feedback d-block text-light">{{ $message }}</div>
				@enderror
			</div>

			<div class="mb-3">
				<div class="input-group">
					<input id="password" type="password"
						class="form-control @error('password') is-invalid @enderror"
						name="password" placeholder="Password..." required>
					<span class="input-group-text" id="toggle-password" style="cursor:pointer;">
						<i class="fas fa-eye"></i>
					</span>
				</div>
				@error('password')
				<div class="invalid-feedback d-block text-light">{{ $message }}</div>
				@enderror
				<a href="{{ route('password.reset') }}" class="forgot-password d-block mt-2 text-light">Lupa Password?</a>
			</div>

			<div class="d-flex flex-column gap-2 mb-3">
				<button type="submit" class="btn btn-success px-4 w-100 mb-2">Masuk</button>
				<button type="reset" class="btn btn-secondary px-4 w-100">Reset</button>
			</div>

		</form>

		<div class="footer-text mt-4 text-light small">
			&copy; {{ date('Y') }} {{ config('app.name') }}
		</div>
	</div>

	<!-- JS -->
	<script src="{{ url('assets/js/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
	<script>
		// Toggle show/hide password
		const togglePassword = document.getElementById('toggle-password');
		const passwordInput = document.getElementById('password');

		togglePassword.addEventListener('click', function() {
			const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
			passwordInput.setAttribute('type', type);
			this.querySelector('i').classList.toggle('fa-eye');
			this.querySelector('i').classList.toggle('fa-eye-slash');
		});
	</script>
</body>

</html>