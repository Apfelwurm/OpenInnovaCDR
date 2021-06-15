@extends ('layouts.admin-default')

@section ('page_title', 'Caller - View '. $caller->name)

@section ('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom">{{ $caller->name }}</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/admin/callers/">Callers                </a>
			</li>
			<li class="breadcrumb-item active">
				{{ $caller->name }}
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 col-lg-8">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-users fa-fw"></i> Assign Caller
			</div>
			<div class="card-body">
				<div class="row">
                    <div class="col-sm-12 col-lg-4">
                    @if ($caller->organisationUnit != null)
                    Caller is assigned to:
                        <a href="/admin/organisationunits/{{ $caller->organisationUnit->id }}"> {{ $caller->organisationUnit->name }}</a>
                        <div>
                            {{ Form::open(array('url'=>'/admin/callers/' . $caller->id . '/unassign' , 'onsubmit' => 'return ConfirmUnassign()')) }}

                                                <button type="submit" class="btn btn-danger btn-sm btn-block">Unassign</button>
                                                {{ Form::close() }}
                        </div>

                    @else
                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Assign</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($organisationUnits as $organisationUnit)
                                <tr>
                                    <td>
                                        {{ $organisationUnit->name }}
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
                    {{ $organisationUnits->links() }}

                    @endif
                    </div>
				</div>


			</div>
		</div>

	</div>
    <div class="col-sm-12 col-lg-4">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-users fa-fw"></i> Edit Caller
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/callers/'.$caller->id)) }}
					<div class="form-group">
						{{ Form::label('name','Name',array('id'=>'','class'=>'')) }}
						{{ Form::text('name', $caller->name ,array('id'=>'name','class'=>'form-control')) }}
					</div>
                    <div class="form-group">
						{{ Form::label('number','Number',array('id'=>'','class'=>'')) }}
						{{ Form::number('number', $caller->number ,array('id'=>'number','class'=>'form-control')) }}
					</div>
					<button type="submit" class="btn btn-success btn-block">Submit</button>
				{{ Form::close() }}
			</div>
		</div>

	</div>
</div>


@endsection
