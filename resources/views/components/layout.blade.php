<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport" />
	<title>{{ $title }} &mdash; {{ config('app.name') }}</title>

	<!-- General CSS Files -->
	<link rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ url('assets/fontawesome/css/all.css') }}" />

	<!-- CSS Libraries -->
	<link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.bootstrap4.css" />

	<!-- Template CSS -->
	<link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
	<link rel="stylesheet" href="{{ url('assets/css/components.css') }}" />

	<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/css/tom-select.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/css/tom-select.bootstrap4.min.css" />
</head>

<style>
	/* Global background */
	body {
		background: #f4f6f9;
		/* abu soft modern */
		font-family: 'Inter', sans-serif;
		color: #333;
	}

	/* Navbar */
	.main-navbar {
		background: #ffffff !important;
		padding: 10px 16px;
		/* border-bottom: 1px solid #e5e7eb; */
	}

	.navbar .nav-link {
		color: #374151 !important;
	}

	.navbar .nav-link:hover {
		color: #2b2d83 !important;
	}

	/* Sidebar Modern */
	.main-sidebar {
		background: linear-gradient(180deg, #ffffff, #f9fafb);
		box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
		width: 240px;
		/* transition: all 0.3s ease; */
	}

	.sidebar-brand {
		padding: 20px;
		text-align: center;
		font-weight: 700;
		font-size: 1.2rem;
		color: #2b2d83;
		letter-spacing: 0.5px;
		/* border-bottom: 1px solid #e5e7eb; */

	}

	.sidebar-menu {
		padding: 15px 10px;
	}

	.sidebar-menu li {
		margin-bottom: 6px;
	}

	.sidebar-menu li a {
		display: flex;
		align-items: center;
		border-radius: 10px;
		padding: 10px 14px;
		font-size: 14px;
		font-weight: 500;
		color: #374151;
		/* transition: all 0.3s ease; */
	}

	.sidebar-menu li a i {
		font-size: 16px;
		width: 22px;
		text-align: center;
		margin-right: 10px;
		color: #6b7280;
		/* transition: color 0.3s ease; */
	}

	.sidebar-menu li a:hover {
		background: #f3f4f6;
		color: #2b2d83;
		/* transform: translateX(4px); */
	}

	.sidebar-menu li a:hover i {
		color: #2b2d83;
	}

	.sidebar-menu li.active>a {
		background: #0dcaf0 !important;
		color: #fff !important;
		font-weight: 600;
		margin: 10px;
		width: 220px;
		/* box-shadow: 0 3px 10px rgba(43, 45, 131, 0.3); */
	}

	.sidebar-menu li.active>a i {
		color: #fff;
	}

	/* Section header */
	.section-header {
		background: #ffffff;
		padding: 15px 20px;
		margin-bottom: 20px;
		border-radius: 10px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
	}

	/* Card */
	.card {
		border-radius: 12px;
		border: none;
		box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
	}

	.card-header {
		background: transparent;
		border-bottom: 1px solid #e5e7eb;
		font-weight: 600;
		color: #111827;
	}

	/* Buttons */
	.btn-primary {
		background: #2b2d83;
		border: none;
	}

	.btn-primary:hover {
		background: #1f236b;
	}

	.btn-warning {
		background: #facc15;
		border: none;
		color: #000;
	}

	.btn-warning:hover {
		background: #eab308;
	}

	/* Dropdown */
	.dropdown-menu {
		border-radius: 10px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
	}
</style>


<body>
	<div id="app">
		<div class="main-wrapper">
			<div class="navbar"></div>
			<nav class="navbar navbar-expand-lg main-navbar bg-white shadow-sm">
				<form class="form-inline mr-auto">
					<ul class="navbar-nav mr-3">
						<li>
							<a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
								<i class="fas fa-bars"></i>
							</a>
						</li>
					</ul>
				</form>

				<ul class="navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"
							class="nav-link dropdown-toggle nav-link-lg d-flex align-items-center">
							<img alt="image"
								src="../assets/img/avatar/avatar-1.png"
								class="rounded-circle mr-2"
								style="width:32px; height:32px;" />
							<span class="d-none text-dark d-lg-inline">Halo, {{ auth()->user()->name }}</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="dropdown-title small">
								Akun sejak: {{ auth()->user()->diffForHumanDate(auth()->user()->created_at) }}
							</div>

							@can('mengatur profile')
							<a href="{{ route('profile.index') }}" class="dropdown-item has-icon">
								<i class="fas fa-cog"></i> Pengaturan Profil
							</a>
							@endcan

							<div class="dropdown-divider"></div>
							<form id="logout-form" action="{{ route('logout') }}" method="POST">
								@csrf
								<button type="submit" class="dropdown-item has-icon text-danger">
									<i class="fas fa-sign-out-alt"></i> Logout
								</button>
							</form>
						</div>
					</li>
				</ul>
			</nav>

			<div class="main-sidebar "
				<aside id="sidebar-wrapper ">
				<div class="sidebar-brand mb-3">
					<!-- <a href="{{ route('home') }}">{{ config('app.name') }}</a> -->
					<a href="{{ route('home') }}">Inventory</a>
				</div>
				<div class="sidebar-brand sidebar-brand-sm mb-3">
					<!-- <a href="{{ route('home') }}">{{ substr(config('app.name'), 0, 2) }}</a> -->
					<a href="{{ route('home') }}">Inventory</a>
				</div>

				<ul class="sidebar-menu">
					<!-- <li class="menu-header">Dashboard</li> -->
					<li class="nav-item{{ request()->routeIs('home') ? ' active' : '' }}">
						<a href="{{ route('home') }}" class="nav-link">
							<i class="fas fa-house"></i> <span>Dashboard</span>
						</a>
					</li>

					<!-- <li class="menu-header">Manajemen</li> -->
					@can('lihat barang')
					<li class="nav-item{{ request()->routeIs('barang.index') ? ' active' : '' }}">
						<a href="{{ route('barang.index') }}" class="nav-link">
							<i class="fas fa-boxes-stacked"></i> <span>Data Barang</span>
						</a>
					</li>
					@endcan

					@can('lihat perolehan')
					<li class="nav-item{{ request()->routeIs('perolehan.index') ? ' active' : '' }}">
						<a href="{{ route('perolehan.index') }}" class="nav-link">
							<i class="far fa-handshake"></i> <span>Data Bantuan</span>
						</a>
					</li>
					@endcan

					@can('lihat ruangan')
					<li class="nav-item{{ request()->routeIs('ruangan.index') ? ' active' : '' }}">
						<a href="{{ route('ruangan.index') }}" class="nav-link">
							<i class="fas fa-school"></i> <span>Data Ruangan</span>
						</a>
					</li>
					@endcan

					@can('lihat pengguna')
					<li class="nav-item{{ request()->routeIs('pengguna.index') ? ' active' : '' }}">
						<a href="{{ route('pengguna.index') }}" class="nav-link">
							<i class="fas fa-users"></i> <span>Data Pengguna</span>
						</a>
					</li>
					@endcan

					<!-- <li class="menu-header">Pengaturan</li> -->
					@can('mengatur profile')
					<li class="nav-item{{ request()->routeIs('profile.index') ? ' active' : '' }}">
						<a href="{{ route('profile.index') }}" class="nav-link">
							<i class="fas fa-cog"></i> <span>Pengaturan Profil</span>
						</a>
					</li>
					@endcan

					@can('lihat peran dan hak akses')
					<li class="nav-item{{ request()->routeIs('peran-dan-hak-akses.index') ? ' active' : '' }}">
						<a href="{{ route('peran-dan-hak-akses.index') }}" class="nav-link">
							<i class="fas fa-user-shield"></i> <span>Peran & Hak Akses</span>
						</a>
					</li>
					@endcan
				</ul>
				</aside>
			</div>


			<!-- Main Content -->
			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>{{ $page_heading }}</h1>
					</div>

					{{ $slot }}
				</section>
			</div>
		</div>
	</div>

	<!-- General JS Scripts -->
	<script src="{{ url('assets/js/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ url('assets/js/popper.min.js') }}"></script>
	<script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ url('assets/js/jquery.nicescroll.min.js') }}"></script>
	<script src="{{ url('assets/js/moment.min.js') }}"></script>
	<script src="{{ url('assets/js/stisla.js') }}"></script>

	<!-- JS Libraies -->
	<script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
	<script src="https://cdn.datatables.net/2.0.6/js/dataTables.bootstrap4.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

	<!-- Template JS File -->
	<script src="{{ url('assets/js/scripts.js') }}"></script>
	<script src="{{ url('assets/js/custom.js') }}"></script>

	<!-- Page Specific JS File -->
	<script src="{{ url('assets/js/page/index-0.js') }}"></script>

	<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>

	<script src="{{ asset('js/scripts.js') }}"></script>

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

	<script>
		$(document).ready(function() {
			bsCustomFileInput.init();

			$(".delete-button").click(function(e) {
				e.preventDefault();
				Swal.fire({
					title: "Hapus?",
					text: "Data tidak akan bisa dikembalikan!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Ya",
					cancelButtonText: "Batal",
					reverseButtons: true,
				}).then((result) => {
					if (result.value) {
						$(this).parent().submit();
					}
				});
			});

			$(".logout").click(function(e) {
				e.preventDefault();
				Swal.fire({
					title: "Keluar?",
					text: "Anda akan keluar dari aplikasi!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Ya",
					cancelButtonText: "Batal",
					reverseButtons: true,
				}).then((result) => {
					if (result.value) {
						$(this).parent().submit();
					}
				});
			});
		});
	</script>
	@stack('modal')
	@stack('js')
</body>

</html>