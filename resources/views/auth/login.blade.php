<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<title>Login &mdash; {{ config('app.name') }}</title>

	<!-- Bootstrap -->
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
			/* backdrop-filter: liquid; */
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

		.btn-login {
			width: 100%;
			border-radius: 12px;
			padding: 12px;
			font-weight: 600;
			/* background: #fff; */
			/* color: #2575fc; */
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
	</style>
</head>

<body>
	<div class="login-wrapper">
		<h4 class="text-center mb-5">Selamat Datang </h4>
		<!-- <p>Masuk ke <b>Inventaris Barang Sekolah</b></p> -->

		@include('utilities.alert')

		<form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
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
				<input id="password" type="password"
					class="form-control @error('password') is-invalid @enderror"
					name="password" placeholder="Password..." required>
				@error('password')
				<div class="invalid-feedback d-block text-light">{{ $message }}</div>
				@enderror
			</div>

			<button type="submit" class="btn-login btn-success">Login</button>
		</form>

		<div class="footer-text">
			&copy; {{ date('Y') }} {{ config('app.name') }}
		</div>
	</div>

	<!-- JS -->
	<script src="{{ url('assets/js/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>