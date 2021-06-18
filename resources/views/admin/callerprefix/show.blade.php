@extends ('layouts.admin-default')

@section ('page_title', 'Users - View '. $callerPrefix->prefix)

@section ('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fa fa-prescription"></i> {{ $callerPrefix->prefix }}</h3>
        @include ('layouts.admin-warnings')
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/admin/callerprefixes/">Caller Prefixes                </a>
			</li>
			<li class="breadcrumb-item active">
				{{ $callerPrefix->prefix }}
			</li>
		</ol>
	</div>
</div>

<div class="row">

    <div class="col-sm-12 col-lg-4">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-prescription fa-fw"></i> Edit Caller Prefix
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/callerprefixes/'.$callerPrefix->id)) }}
					<div class="form-group">
						{{ Form::label('prefix','Prefix',array('id'=>'','class'=>'')) }}
						{{ Form::text('prefix', $callerPrefix->prefix ,array('id'=>'prefix','class'=>'form-control')) }}
					</div>
					<button type="submit" class="btn btn-success btn-block">Submit</button>
				{{ Form::close() }}
			</div>
		</div>

	</div>
</div>


@endsection
