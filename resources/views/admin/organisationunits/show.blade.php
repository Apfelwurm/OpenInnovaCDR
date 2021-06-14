@extends ('layouts.admin-default')

@section ('page_title', 'Users - View '. $organisationUnit->name)

@section ('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom">{{ $organisationUnit->name }}</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/admin/organisationunits/">Organisation Units                </a>
			</li>
			<li class="breadcrumb-item active">
				{{ $organisationUnit->name }}
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 col-lg-8">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-users fa-fw"></i> Assign Callers
			</div>
			<div class="card-body">
				<div class="row">

				</div>

			</div>
		</div>

	</div>
    <div class="col-sm-12 col-lg-4">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-users fa-fw"></i> Edit Organisation Unit
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/organisationunits/'.$organisationUnit->id)) }}
					<div class="form-group">
						{{ Form::label('name','Name',array('id'=>'','class'=>'')) }}
						{{ Form::text('name', $organisationUnit->name ,array('id'=>'name','class'=>'form-control')) }}
					</div>
					<button type="submit" class="btn btn-success btn-block">Submit</button>
				{{ Form::close() }}
			</div>
		</div>

	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-lg-8">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-users fa-fw"></i> Assigned Callers
			</div>
			<div class="card-body">
				<div class="row">

				</div>

			</div>
		</div>

	</div>
</div>

@endsection
