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



                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Number</th>
                                <th>Assign</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unassignedCallers as $caller)
                                <tr>
                                    <td>
                                        {{ $caller->name }}
                                    </td>
                                    <td>
                                        {{ $caller->number }}
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
                    {{ $unassignedCallers->links() }}

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
                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Number</th>
                                <th>Unassign</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignedCallers as $caller)
                                <tr>
                                    <td>
                                        {{ $caller->name }}
                                    </td>
                                    <td>
                                        {{ $caller->number }}
                                    </td>
                                    <td>
                                        {{ Form::open(array('url'=>'/admin/callers/' . $caller->id . '/unassign' , 'onsubmit' => 'return ConfirmDelete()')) }}

                                        <button type="submit" class="btn btn-danger btn-sm btn-block">Unassign</button>
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $assignedCallers->links() }}
				</div>

			</div>
		</div>

	</div>
</div>

@endsection
