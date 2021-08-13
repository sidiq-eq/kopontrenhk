<?php 
date_default_timezone_set("Asia/Bangkok");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-title" content="Rolos Chicken">

	<link rel="shortcut icon" href="{{asset('img/icons/icon-48x48.png')}}" />
	<link href="{{asset('/fontawesome/css/all.css')}}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/zf/dt-1.10.24/r-2.2.7/sb-1.0.1/sp-1.2.2/datatables.min.css"/>
	@yield('head')
	<link rel="shortcut icon" href="{{url('kopontren.jpg')}}">
	<link rel="shortcut icon" href="{{url('/asset/add-to-homescreen-master/style/addtohomescreen.css')}}">
	<link rel="shortcut icon" href="{{url('/asset/add-to-homescreen-master/src/addtohomescreen.min')}}">
	<title>@yield('title')</title>

	<link href="{{asset('asset/css/app.css')}}" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="{{url('/')}}">
          <span class="align-middle">Kopontren HK</span>
        </a>

				<ul class="sidebar-nav">

					<li class="sidebar-header">
						Absensi
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{url('/')}}">
							<i class="fab fa-wpforms"></i> <span class="align-middle">Form Absen</span>
            			</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{url('/cek')}}">
							<i class="fas fa-clipboard-check"></i> <span class="align-middle">Cek Absen</span>
            			</a>
					</li>

					<li class="sidebar-header">
						Informasi & Lain-lain
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{url('/info')}}">
							<i class="fas fa-info-circle"></i> <span class="align-middle">Informasi</span>
            			</a>
					</li>
					<li class="sidebar-header">
						System
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{url('/login')}}">
							<i class="fas fa-chevron-right"></i> <span class="align-middle">Login System</span>
            			</a>
					</li>
					
					
				</ul>

				
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle d-flex">
          <i class="hamburger align-self-center"></i>
        </a>

				<form class="d-none d-sm-inline-block">
					<div class="input-group input-group-navbar">
						<input type="text" class="form-control" placeholder="Search…" aria-label="Search">
						<button class="btn" type="button">
              <i class="align-middle" data-feather="search"></i>
            </button>
					</div>
				</form>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						{{-- <li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">4</span>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Update completed</div>
												<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
												<div class="text-muted small mt-1">30m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-warning" data-feather="bell"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-primary" data-feather="home"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Login from 192.186.1.8</div>
												<div class="text-muted small mt-1">5h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-success" data-feather="user-plus"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="text-muted small mt-1">Christina accepted your request.</div>
												<div class="text-muted small mt-1">14h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li> --}}
						
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
								<i class="fa fa-user"></i> <span class="text-dark">User</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle mr-1" data-feather="user"></i> Profile</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Login</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			@yield('main')
			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col text-left">
							<p class="mb-0">
								<a href="{{url('/')}}" class="text-muted"><strong>Kopontren HK</strong> create by sidiq</a> &copy;
							</p>
						</div>
						
					</div>
				</div>
			</footer>
		</div>
	</div>
	@yield('modal')
	<script src="{{asset('asset/js/app.js')}}"></script>
	<script src="{{asset('asset/js/jquery.min.js')}}"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap.min.js"></script>

	@yield('script')
</body>

</html>