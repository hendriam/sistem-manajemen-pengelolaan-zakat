<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-teal elevation-4">
	<!-- Brand Logo -->
	<a href="{{ route('dashboard') }}" class="brand-link bg-dark">
		<img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
		<span class="brand-text font-weight-light">SMPZ</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image" />
			</div>
			<div class="info">
				<a href="{{ route('profile') }}" class="d-block">{{ auth()->user()->name }}</a>
			</div>
		</div>
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
						<i class="nav-icon fas fa-hotel"></i>
						<p>Dashboard</p>
					</a>
				</li>

				@if (auth()->user()->role == "admin")
				<li class="nav-header">Master</li>
				<li class="nav-item">
					<a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
						<i class="fas fa-user-friends nav-icon"></i>
						<p>User</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="{{ route('muzakkis.index') }}" class="nav-link {{ request()->routeIs('muzakkis.*') ? 'active' : '' }}">
						<i class="fas fa-user-tag nav-icon"></i>
						<p>Muzakki</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="{{ route('mustahiks.index') }}" class="nav-link {{ request()->routeIs('mustahiks.*') ? 'active' : '' }}">
						<i class="fas fa-users icon"></i>
						<p>Mustahik</p>
					</a>
				</li>

				<li class="nav-header">Transaksi</li>
				<li class="nav-item">
					<a href="{{ route('zakat-transactions.index') }}" class="nav-link {{ request()->routeIs('zakat-transactions.*') ? 'active' : '' }}">
						<i class="fas fa-envelope-open-text nav-icon"></i>
						<p>Bayar Zakat</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="{{ route('distributions.index') }}" class="nav-link {{ request()->routeIs('distributions.*') ? 'active' : '' }}">
						<i class="fas fa-envelope-open-text nav-icon"></i>
						<p>Penyaluran Zakat</p>
					</a>
				</li>
				@endif
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>