<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title> @yield('title') | GPS HRMS</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="" />
<meta name="author" content="" />

<link href="{{asset('/assets/css/vendor.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/css/app.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/css/style.css')}}" rel="stylesheet" />
<meta name="csrf-token" content="{{csrf_token()}}"/>

</head>
<body>

<div id="app" class="app">
	<div id="header" class="app-header">
		<div class="mobile-toggler">
			<button type="button" class="menu-toggler" data-toggle="sidebar-mobile">
				<span class="bar"></span>
				<span class="bar"></span>
			</button>
		</div>


		<div class="brand">
			<div class="desktop-toggler">
				<button type="button" class="menu-toggler" data-toggle="sidebar-minify">
					<span class="bar"></span>
					<span class="bar"></span>
				</button>
			</div>
			<a href="#" class="brand-logo">
				<img src="assets/img/logo.png" alt=""  />
			</a>
		</div>


		<div class="menu">
			<div class="menu-search" style="display: flex;">
				
			</div>
				{{-- <form class="menu-search" method="POST" name="header_search_form">
				<div class="menu-search-icon"><i class="fa fa-search"></i></div>
				<div class="menu-search-input">
				<input type="text" class="form-control" placeholder="Search menu..." />
				</div>
				</form> --}}
			<div class="menu-item dropdown">
				<a href="#" data-bs-toggle="dropdown" data-display="static" class="menu-link">
					<div class="menu-icon"><i class="fa fa-bell nav-icon"></i></div>
					<div class="menu-label">3</div>
				</a>
				<div class="dropdown-menu dropdown-menu-right dropdown-notification">
					<h6 class="dropdown-header text-dark mb-1">Notifications</h6>
					<a href="#" class="dropdown-notification-item">
						<div class="dropdown-notification-icon">
							<i class="fa fa-receipt fa-lg fa-fw text-success"></i>
						</div>
						<div class="dropdown-notification-info">
							<div class="title">Your store has a new order for 2 items totaling $1,299.00</div>
							<div class="time">just now</div>
						</div>
						<div class="dropdown-notification-arrow">
							<i class="fa fa-chevron-right"></i>
						</div>
					</a>
					<a href="#" class="dropdown-notification-item">
						<div class="dropdown-notification-icon">
							<i class="far fa-user-circle fa-lg fa-fw text-muted"></i>
						</div>
						<div class="dropdown-notification-info">
							<div class="title">3 new customer account is created</div>
							<div class="time">2 minutes ago</div>
						</div>
						<div class="dropdown-notification-arrow">
							<i class="fa fa-chevron-right"></i>
						</div>
					</a>
					<a href="#" class="dropdown-notification-item">
						<div class="dropdown-notification-icon">
							<img src="assets/img/icon/android.svg" alt="" width="26" />
						</div>
						<div class="dropdown-notification-info">
							<div class="title">Your android application has been approved</div>
							<div class="time">5 minutes ago</div>
						</div>
						<div class="dropdown-notification-arrow">
							<i class="fa fa-chevron-right"></i>
						</div>
					</a>
					<a href="#" class="dropdown-notification-item">
						<div class="dropdown-notification-icon">
							<img src="assets/img/icon/paypal.svg" alt="" width="26" />
						</div>
						<div class="dropdown-notification-info">
							<div class="title">Paypal payment method has been enabled for your store</div>
							<div class="time">10 minutes ago</div>
						</div>
						<div class="dropdown-notification-arrow">
							<i class="fa fa-chevron-right"></i>
						</div>
					</a>
					<div class="p-2 text-center mb-n1">
						<a href="#" class="text-dark text-opacity-50 text-decoration-none">See all</a>
					</div>
				</div>
			</div>
			<div class="menu-item dropdown">
				<a href="#" data-bs-toggle="dropdown" data-display="static" class="menu-link">
					<div class="menu-img online">
						<img src="{{asset('/assets/uploads/profiles/')}}/{{Auth::User()->profile}}" alt="" class="ms-100 mh-100 rounded-circle" />
					</div>
					<div class="menu-text"><span class="__cf_email__">{{Auth::User()->first_name}} {{Auth::User()->last_name}}</span></div>
				</a>
				<div class="dropdown-menu dropdown-menu-right me-lg-3">
					<a class="dropdown-item d-flex align-items-center" href="#">Edit Profile <i class="fa fa-user-circle fa-fw ms-auto text-dark text-opacity-50"></i></a>
					<a class="dropdown-item d-flex align-items-center" href="#">Inbox <i class="fa fa-envelope fa-fw ms-auto text-dark text-opacity-50"></i></a>
					<a class="dropdown-item d-flex align-items-center" href="#">Calendar <i class="fa fa-calendar-alt fa-fw ms-auto text-dark text-opacity-50"></i></a>
					<a class="dropdown-item d-flex align-items-center" href="#">Setting <i class="fa fa-wrench fa-fw ms-auto text-dark text-opacity-50"></i></a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item d-flex align-items-center" href="{{route('logout')}}">Log Out <i class="fa fa-toggle-off fa-fw ms-auto text-dark text-opacity-50"></i></a>
				</div>
			</div>
		</div>
	</div>	
	<div id="sidebar" class="app-sidebar">
		<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
			<div class="menu">
				<div class="menu-header">Navigation</div>
				<div class="menu-item active">
					<a href="{{route('dashboard.index')}}" class="menu-link">
						<span class="menu-icon"><i class="fa fa-laptop"></i></span>
						<span class="menu-text">Dashboard</span>
					</a>
				</div>

				<div class="menu-item active">
					<a href="{{route('dashboard.users.index')}}" class="menu-link">
						<span class="menu-icon"><i class="fa fa-users"></i></span>
						<span class="menu-text">Users</span>
					</a>
				</div>

				<div class="menu-item active">
					<a href="{{route('posts.index')}}" class="menu-link">
						<span class="menu-icon"><i class="fa-solid fa-image"></i></span>
						<span class="menu-text">Image Attendance</span>
					</a>
				</div>

				<div class="menu-item active">
					<a href="{{route('outlet.index')}}" class="menu-link">
						<span class="menu-icon"><i class="fa-solid fa-building"></i></span>
						<span class="menu-text">Outlet</span>
					</a>
				</div>

				<div class="menu-item active">
					<a href="{{route('useroutlet.index')}}" class="menu-link">
						<span class="menu-icon"><i class="fa-solid fa-person"></i></span>
						<span class="menu-text">User Outlet</span>
					</a>
				</div>

			</div>
		</div>
		<button class="app-sidebar-mobile-backdrop" data-dismiss="sidebar-mobile"></button>
	</div>
	<div id="content" class="app-content">
		@yield('content')
	</div>
</div>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<!-- <script src="{{asset('/assets/js/vendor.min.js')}}"></script> -->

<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0-rc.1/dist/js.cookie.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js" integrity="sha512-cJMgI2OtiquRH4L9u+WQW+mz828vmdp9ljOcm/vKTQ7+ydQUktrPVewlykMgozPP+NUBbHdeifE6iJ6UVjNw5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{asset('/assets/js/app.min.js')}}"></script>
@yield('script')
</body>
</html>
