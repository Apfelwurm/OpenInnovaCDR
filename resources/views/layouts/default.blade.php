<!DOCTYPE html>
<html lang="en" class="full-height">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700&display=swap' rel='stylesheet' type='text/css' />
		<link href="/css/app.css?v={{ Helpers::getCssVersion() }}" rel=stylesheet />


		<title>OpenInnovaCDR</title>


		@yield ('prefetch')
	</head>
	<body class="full-height">

		@include ('layouts.navigation')

		<div class="container" style="margin-top:50px;"></div>

		@yield ('content')
		<div class="alert-fixed">
			@foreach (['danger', 'warning', 'success', 'info'] as $msg)
				@if (Session::has('alert-' . $msg))
					<p class="alert  alert-{{ $msg }} alert-dismissible fade show">
						<b>{{ Session::get('alert-' . $msg) }}</b> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					</p>
				@endif
			@endforeach
		</div>

		<script src="/js/vendor.js"></script>
		<script>
			jQuery(function () {
				jQuery('[data-toggle="tooltip"]').tooltip();
			});
		</script>
		<br>

		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="d-none d-md-block">

					</div>
					<div class="col-lg-4 d-none d-lg-block">

					</div>
					<div class="col-lg-8 col-sm-12 col-md-12 text-center">

					</div>
					<div class="col-lg-12 text-center">
						<p>Powered By <a href="https://github.com/Apfelwurm/OpenInnovaCDR">OpenInnovaCDR</a></p>
					</div>
				</div>
			</div>
		</footer>
		@if ($errors->any())
		<div class="alert alert-fixed alert-danger alert-dismissible fade show" role="alert">
			<h4 mt-0>Errors occured</h4>
			<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach

			</ul>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif

		@yield ('scripts')
	</body>
</html>
