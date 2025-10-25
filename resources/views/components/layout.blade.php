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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
	<link rel="stylesheet" href="{{ url('assets/fontawesome/css/all.css') }}" />


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

	navbar .nav-link i.fa-bell {
		vertical-align: middle;
	}

	/* === NOTIFIKASI RESPONSIF & RAPI === */
	.nav-item.dropdown .dropdown-menu.notif-dropdown {
		max-width: 95vw;
		width: 250px;
		max-height: 80vh;
		overflow: hidden;
		border-radius: 12px;
		box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
		border: none;
		font-size: 0.95rem;
	}

	@media (max-width: 768px) {
		.nav-item.dropdown .dropdown-menu.notif-dropdown {
			position: fixed !important;
			right: 10px !important;
			left: 10px !important;
			top: 70px !important;
			width: auto !important;
			max-height: 75vh;
			z-index: 1055;
		}
	}

	.dropdown-header.notif-header {
		background: #f8f9fa;
		padding: 12px 16px;
		border-bottom: 1px solid #e5e7eb;
		font-weight: 600;
		color: #111827;
	}

	.notif-list {
		max-height: calc(80vh - 60px);
		overflow-y: auto;
		scrollbar-width: thin;
		scrollbar-color: #ccc transparent;
	}

	.notif-list::-webkit-scrollbar {
		width: 6px;
	}

	.notif-list::-webkit-scrollbar-thumb {
		background-color: #ccc;
		border-radius: 10px;
	}

	.notif-list::-webkit-scrollbar-thumb:hover {
		background-color: #999;
	}

	/* Indikator titik merah */
	.notif-indicator {
		position: absolute;
		top: 8px;
		right: 10px;
		width: 10px;
		height: 10px;
		background: red;
		border-radius: 50%;
	}
</style>


<body>
	<div id="app">
		<div class="main-wrapper">
			<div class="navbar"></div>
			{{-- Navbar --}}
			<nav class="navbar navbar-expand-lg main-navbar bg-white shadow-sm px-4">
				<div class="container-fluid d-flex justify-content-between align-items-center">
					{{-- TOMBOL SIDEBAR / MENU --}}
					<div class="d-flex align-items-center">
						<a href="#" data-bs-toggle="collapse" data-bs-target="#sidebar" class="nav-link nav-link-lg">
							<i class="fas fa-bars"></i>
						</a>
					</div>

					{{-- BAGIAN KANAN: NOTIFIKASI + USER --}}
					<ul class="navbar-nav d-flex flex-row align-items-center ms-auto gap-3">

						{{-- 🔔 NOTIFIKASI (Responsif) --}}
						@hasanyrole('administrator|kepsek')
						<li class="nav-item dropdown">
							<a href="#" data-bs-toggle="dropdown" class="nav-link position-relative">
								<i class="fas fa-bell fa-xl {{ isset($notifOn) && $notifOn ? 'text-warning' : 'text-secondary' }}"></i>
								@if(isset($notifOn) && $notifOn)
								<span class="notif-indicator"></span>
								@endif
							</a>

							<div class="dropdown-menu dropdown-menu-end notif-dropdown">
								<div class="dropdown-header notif-header d-flex justify-content-between align-items-center">
									<span>Notifikasi</span>
									<a href="{{ route('notifications.markAllRead') }}" class="small text-primary">Tandai semua dibaca</a>
								</div>

								<div class="notif-list list-group list-group-flush">
									@forelse($notifications->where('is_read', 0) ?? [] as $notif)
									<a href="{{ route('notifications.read', $notif->id) }}"
										class="list-group-item list-group-item-action border-0 py-3 px-4
       {{ $notif->is_read ? '' : 'bg-light' }}">
										<div class="d-flex align-items-start">
											<div class="me-3 text-primary mt-1">
												<i class="fas fa-info-circle"></i>
											</div>
											<div class="flex-fill">
												<div class="fw-semibold">{{ $notif->title }}</div>
												<div class="small text-muted text-wrap">{{ $notif->message }}</div>
												<div class="small text-muted">
													{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
												</div>
											</div>
										</div>
									</a>
									@empty
									<div class="list-group-item text-center text-muted small py-3">
										Tidak ada notifikasi
									</div>
									@endforelse
								</div>

							</div>
						</li>
						@endhasanyrole



						{{-- 👤 USER DROPDOWN --}}
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
								<img src="{{ asset('assets/img/avatar/avatar-1.png') }}" alt="avatar"
									class="rounded-circle me-2" width="32" height="32">
								<span class="d-none d-lg-inline text-dark fw-semibold">{{ auth()->user()->name }}</span>
							</a>
							<ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
								<li class="dropdown-header small">
									Akun sejak: {{ auth()->user()->created_at->format('d-m-Y') }}
								</li>
								@can('mengatur profile')
								<li>
									<a class="dropdown-item" href="{{ route('profile.index') }}">
										<i class="fas fa-cog"></i> Pengaturan Profil
									</a>
								</li>
								@endcan
								<li>
									<hr class="dropdown-divider">
								</li>
								<li>
									<form action="{{ route('logout') }}" method="POST">
										@csrf
										<button type="submit" class="dropdown-item text-danger">
											<i class="fas fa-sign-out-alt"></i> Logout
										</button>
									</form>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>






			<div class="main-sidebar "
				<aside id="sidebar-wrapper ">
				<!-- <div class="sidebar-brand mb-3">

					<a href="{{ route('home') }}">{{ config('app.name') }}</a>
					<a href="{{ route('home') }}">Inventory</a>
				</div> -->
				<div class="sidebar-brand sidebar-brand-sm mb-3 d-flex align-items-center gap-2">
					<a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
						<!-- Logo -->
						<img src="{{ asset('assets/img/swg.png') }}" alt="Logo"
							class="rounded m-2" style="width: 32px; height: 32px; object-fit: cover;">

						<!-- Nama -->
						<a href="{{ route('home') }}">Inventory</a>
					</a>
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

					@can('lihat kategori')
					<li class="nav-item{{ request()->routeIs('kategori.index') ? ' active' : '' }}">
						<a href="{{ route('kategori.index') }}" class="nav-link">
							<i class="fas fa-tags"></i> <span>Kategori Barang</span>
						</a>
					</li>
					@endcan

					@can('lihat penyusutan')
					<li class="nav-item{{ request()->routeIs('penyusutan.index') ? ' active' : '' }}">
						<a href="{{ route('penyusutan.index') }}" class="nav-link">
							<i class="fas fa-boxes-stacked"></i> <span>Data Penyusutan</span>
						</a>
					</li>
					@endcan

					@can('lihat rab')
					<li class="nav-item{{ request()->routeIs('rab.index') ? ' active' : '' }}">
						<a href="{{ route('rab.index') }}" class="nav-link">
							<i class="fas fa-file-invoice-dollar"></i> <span>Data RAB</span>
						</a>
					</li>
					@endcan



					@can('lihat peminjaman')
					<li class="nav-item{{ request()->routeIs('peminjaman.index') ? ' active' : '' }}">
						<a href="{{ route('peminjaman.index') }}" class="nav-link">
							<i class="fas fa-hand-holding"></i> <span>Data Peminjaman</span>
						</a>
					</li>

					@endcan

					@can('lihat barang keluar')
					<li class="nav-item{{ request()->routeIs('barang-keluar.index') ? ' active' : '' }}">
						<a href="{{ route('barang-keluar.index') }}" class="nav-link">
							<i class="fas fa-truck-loading"></i> <span>Barang Keluar</span>
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

					<!-- @can('approve peminjaman')
					<li class="nav-item{{ request()->routeIs('peminjaman.approval') ? ' active' : '' }}">
						<a href="{{ route('peminjaman.approval') }}" class="nav-link">
							<i class="fas fa-user-check"></i> <span>Approval Peminjaman</span>
						</a>
					</li>
					@endcan -->



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
	<!-- <script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script> -->
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>