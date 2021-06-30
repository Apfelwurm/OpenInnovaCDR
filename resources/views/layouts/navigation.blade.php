<nav class="navbar navbar-expand-md navbar-dark fixed-top custom-header">
	<div class="container">
		<button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#topbar-navigation" aria-expanded="false">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="/">OpenInnovaCDR
		</a>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="topbar-navigation">
			<ul class="navbar-nav ml-auto">
				@if (Auth::check())
					{{-- @include ('layouts._partials.user-navigation') --}}
				@endif
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
