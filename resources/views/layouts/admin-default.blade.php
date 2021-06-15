<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>OpenInnovaCDR - Admin</title>

		<!-- Admin CSS -->
		<link href="/css/admin.css" rel="stylesheet">
		<link href="/css/jquery-ui.min.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
				<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
				<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Jquery Core JavaScript -->
		<script src="/js/vendor.js"></script>


		<script>
			function ConfirmDelete()
			{
				var x = confirm("Are you sure you want to delete?");
				if (x)
					return true;
				else
					return false;
			}
            function ConfirmUnassign()
			{
				var x = confirm("Are you sure you want to remove the assignment?");
				if (x)
					return true;
				else
					return false;
			}
			function ConfirmSubmit()
			{
				var x = confirm("Are you sure you want to submit?");
				if (x)
					return true;
				else
					return false;
			}
	        jQuery(document).ready(function() {
	            jQuery('.wysiwyg-editor').summernote({
	              height:300,
	            });
	            jQuery('.wysiwyg-editor-small').summernote({
	              height:150,
	            });
	        });
		</script>

	</head>
	<body>
		<div id="wrapper">
			@include ('layouts.admin-navigation')
			<div id="page-wrapper">
				<div class="container-fluid">

					@yield('content')

					<div class="alert-fixed">
						@foreach (['danger', 'warning', 'success', 'info'] as $msg)
							@if (Session::has('alert-' . $msg))
								<p class="alert  alert-{{ $msg }} alert-dismissible fade show">
									<b>{{ Session::get('alert-' . $msg) }}</b> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								</p>
							@endif
						@endforeach
					</div>
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
				</div>
			</div>
		</div>
	</body>
</html>
