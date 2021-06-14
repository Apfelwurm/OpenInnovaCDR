<nav class="navbar navbar-dark custom-header navbar-expand-md fixed-top" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<!-- <div class="navbar-header"> -->
		<button type="button" class="navbar-toggler" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand ml-3" href="/">OpenInnovaCDR Admin</a>
	<!-- </div> -->
	<!-- Top Menu Items -->

	<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="navbar-nav side-nav pl-2">
			<li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
				<a class="nav-link" href="/admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
			</li>
            <li class="nav-item {{ Request::is('admin/users') ? 'active' : '' }}">
				<a class="nav-link" href="/admin/users"><i class="fa fa-user fa-fw"></i> Users</a>
			</li>
		</ul>
	</div>
	<!-- /.navbar-collapse -->

	<ul class="nav ml-auto top-nav">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ $user->username }}</a>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
			</div>
		</li>
	</ul>
</nav>
