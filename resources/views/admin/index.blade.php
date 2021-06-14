@extends ('layouts.admin-default')

@section ('page_title', 'Admin')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom">Dashboard</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">
				<i class="fa fa-dashboard"></i> Dashboard
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="card panel-blue mb-3">
			<div class="card-header">
				<div class="row">
					<div class="col-3">
						<i class="fas fa-comments fa-5x"></i>
					</div>
					<div class="col-9 text-right">
						<div>New Comments!</div>
					</div>
				</div>
			</div>
			<a href="/admin/news">
				<div class="card-footer">
					<span class="float-left">View Details</span>
					<span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>



@endsection
