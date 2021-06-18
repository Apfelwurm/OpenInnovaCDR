@extends ('layouts.admin-default')

@section ('page_title', 'Organisation Units')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fa fa-building"></i> Organisation Units</h3>
        @include ('layouts.admin-warnings')
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">
				Organisation Units
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-12 col-sm-8">

		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-building fa-fw"></i> Organisation Units
			</div>
			<div class="card-body">
				{{ $organisationUnits->links('vendor.pagination.default') }}
				<table class="table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Name</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($organisationUnits as $organisationUnit)
							<tr>
								<td>
									{{ $organisationUnit->name }}
								</td>
								<td>
									<a href="/admin/organisationunits/{{ $organisationUnit->id }}">
										<button class="btn btn-primary btn-sm btn-block">Edit</button>
									</a>
								</td>
                                <td>
                                    {{ Form::open(array('url'=>'/admin/organisationunits/' . $organisationUnit->id . '/delete' ,'method' => 'delete', 'onsubmit' => 'return ConfirmDelete()')) }}

                                    <button type="submit" class="btn btn-danger btn-sm btn-block">Remove</button>
                                    {{ Form::close() }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{{ $organisationUnits->links('vendor.pagination.default') }}
			</div>
		</div>

	</div>
    <div class="col-12 col-sm-4">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-plus fa-fw"></i> Create Organisation Units
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/organisationunits/add')) }}
					<div class="form-group">
						{{ Form::label('name','Name',array('id'=>'','class'=>'')) }}
						{{ Form::text('name', NULL ,array('id'=>'name','class'=>'form-control')) }}
					</div>
					<button type="submit" class="btn btn-success btn-block">Submit</button>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

@endsection
