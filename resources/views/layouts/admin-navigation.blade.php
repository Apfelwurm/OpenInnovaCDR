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
            <li class="nav-item {{ Request::is('admin/reports') ? 'active' : '' }}">
				<a class="nav-link" href="/admin/reports"><i class="fas fa-newspaper fa-fw"></i> Reports</a>
			</li>
            <li class="nav-item {{ Request::is('admin/organisationunits') ? 'active' : '' }}">
				<a class="nav-link" href="/admin/organisationunits"><i class="fa fa-building fa-fw"></i> Organisation Units</a>
			</li>
            <li class="nav-item {{ Request::is('admin/callers') ? 'active' : '' }}">
				<a class="nav-link" href="/admin/callers"><i class="fas fa-phone fa-fw"></i> Callers</a>
			</li>
            <li class="nav-item {{ Request::is('admin/callerprefixes') ? 'active' : '' }}">
				<a class="nav-link" href="/admin/callerprefixes"><i class="fas fa-prescription fa-fw"></i> Caller Prefixes</a>
			</li>
            <li class="nav-item {{ Request::is('admin/numberfiltersettings') ? 'active' : '' }}">
				<a class="nav-link" href="/admin/numberfiltersettings"><i class="fas fa-filter fa-fw"></i> Number Filter Settings</a>
			</li>
            <li class="nav-item {{ Request::is('admin/users') ? 'active' : '' }}">
				<a class="nav-link" href="/admin/users"><i class="fa fa-user fa-fw"></i> User Management</a>
			</li>
            <li class="nav-item {{ Request::is('admin/settings') ? 'active' : '' }}">
				<a class="nav-link" href="/admin/settings"><i class="fas fa-cog fa-fw"></i> Settings</a>
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
