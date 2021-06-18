@extends ('layouts.admin-default')

@section ('page_title', 'Users - View '. $organisationUnit->name)

@section ('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fa fa-building"></i> {{ $organisationUnit->name }}</h3>
        @include ('layouts.admin-warnings')
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
                <div class="row">
                    <div class="col-sm-8">
				        <i class="fa fa-phone fa-fw"></i> Assign Callers
                    </div>
                    <div class="col-sm-4">
                    {{ $unassignedCallers->links('vendor.pagination.default') }}
                    </div>

                </div>
			</div>

			<div class="card-body">
				<div class="row">



                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Name</th>
                                <th>Assign</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unassignedCallers as $caller)
                                <tr>
                                    <td>
                                        {{ $caller->number }}
                                    </td>
                                    <td>
                                        {{ $caller->name }}
                                    </td>

                                    <td>
                                        {{ Form::open(array('url'=>'/admin/callers/' . $caller->id . '/assign/' . $organisationUnit->id )) }}

                                        <button type="submit" class="btn btn-primary btn-sm btn-block">Assign</button>
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $unassignedCallers->links('vendor.pagination.default') }}

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
                <div class="row">
                    <div class="col-sm-8">
				        <i class="fa fa-phone fa-fw"></i> Assigned Callers
                    </div>
                    <div class="col-sm-4">
                        {{ $assignedCallers->links('vendor.pagination.default') }}
                    </div>

                </div>
			</div>

			<div class="card-body">
				<div class="row">
                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Name</th>
                                <th>Unassign</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignedCallers as $caller)
                                <tr>
                                    <td>
                                        {{ $caller->number }}
                                    </td>
                                    <td>
                                        {{ $caller->name }}
                                    </td>
                                    <td>
                                        {{ Form::open(array('url'=>'/admin/callers/' . $caller->id . '/unassign' , 'onsubmit' => 'return ConfirmUnassign()')) }}

                                        <button type="submit" class="btn btn-danger btn-sm btn-block">Unassign</button>
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $assignedCallers->links('vendor.pagination.default') }}
				</div>

			</div>
		</div>

	</div>
</div>

@endsection
