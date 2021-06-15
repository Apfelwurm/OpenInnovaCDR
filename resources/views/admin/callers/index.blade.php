@extends ('layouts.admin-default')

@section ('page_title', 'Callers')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fa fa-phone"></i> Callers</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">
				Callers
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-12 col-sm-8">

		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-phone fa-fw"></i> Callers
			</div>
			<div class="card-body">
				<table class="table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Number</th>
							<th>Name</th>
							<th>OU</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($callers as $caller)
							<tr>
								<td>
									{{ $caller->number }}
								</td>
                                <td>
									{{ $caller->name }}
								</td>
                                 <td>
                                    @if ($caller->organisationUnit != null)
									    {{ $caller->organisationUnit->name }}
                                    @endif
								</td>
								<td>
									<a href="/admin/callers/{{ $caller->id }}">
										<button class="btn btn-primary btn-sm btn-block">Edit</button>
									</a>
								</td>
                                <td>
                                    {{ Form::open(array('url'=>'/admin/callers/' . $caller->id . '/delete' ,'method' => 'delete', 'onsubmit' => 'return ConfirmDelete()')) }}

                                    <button type="submit" class="btn btn-danger btn-sm btn-block">Remove</button>
                                    {{ Form::close() }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{{ $callers->links() }}
			</div>
		</div>

	</div>
    <div class="col-12 col-sm-4">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-plus fa-fw"></i> Create Callers
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/callers/add')) }}
					<div class="form-group">
						{{ Form::label('name','Name',array('id'=>'','class'=>'')) }}
						{{ Form::text('name', NULL ,array('id'=>'name','class'=>'form-control')) }}
					</div>
                    <div class="form-group">
						{{ Form::label('number','Number',array('id'=>'','class'=>'')) }}
						{{ Form::number('number', NULL ,array('id'=>'number','class'=>'form-control')) }}
					</div>
					<button type="submit" class="btn btn-success btn-block">Submit</button>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

@endsection
