@extends ('layouts.admin-default')

@section ('page_title', 'Caller Prefixes')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fa fa-prescription"></i> Caller Prefixes</h3>
        @include ('layouts.admin-warnings')
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">
				Caller Prefixes
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-12 col-sm-8">

		<div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-8">
				        <i class="fa fa-prescription fa-fw"></i> Caller Prefixes
                    </div>
                    <div class="col-sm-4">
                        {{ $callerPrefixes->links('vendor.pagination.default') }}
                    </div>

                </div>
			</div>
			<div class="card-body">
				<table class="table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Prefix</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($callerPrefixes as $callerPrefix)
							<tr>
								<td>
									{{ $callerPrefix->prefix }}
								</td>
								<td>
									<a href="/admin/callerprefixes/{{ $callerPrefix->id }}">
										<button class="btn btn-primary btn-sm btn-block">Edit</button>
									</a>
								</td>
                                <td>
                                    {{ Form::open(array('url'=>'/admin/callerprefixes/' . $callerPrefix->id . '/delete' ,'method' => 'delete', 'onsubmit' => 'return ConfirmDelete()')) }}

                                    <button type="submit" class="btn btn-danger btn-sm btn-block">Remove</button>
                                    {{ Form::close() }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{{ $callerPrefixes->links('vendor.pagination.default') }}
			</div>
		</div>

	</div>
    <div class="col-12 col-sm-4">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-plus fa-fw"></i> Create Caller Prefix
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/callerprefixes/add')) }}
					<div class="form-group">
						{{ Form::label('prefix','Prefix',array('id'=>'','class'=>'')) }}
						{{ Form::text('prefix', NULL ,array('id'=>'prefix','class'=>'form-control')) }}
					</div>
					<button type="submit" class="btn btn-success btn-block">Submit</button>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

@endsection
