@extends ('layouts.admin-default')

@section ('page_title', 'Users - View '. $userShow->username)

@section ('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fa fa-user"></i> {{ $userShow->username }}</h3>
        @include ('layouts.admin-warnings')
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/admin/users/">Users</a>
			</li>
			<li class="breadcrumb-item active">
				{{ $userShow->username }}
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 col-lg-6">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-cog fa-fw"></i> Options
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-sm-6">
						@if ($userShow->isAdmin)
							{{ Form::open(array('url'=>'/admin/users/' . $userShow->id . '/admin')) }}
								{{ Form::hidden('_method', 'DELETE') }}
								<button type="submit" class="btn btn-block btn-danger">Remove Admin</button>
							{{ Form::close() }}
						@else
							{{ Form::open(array('url'=>'/admin/users/' . $userShow->id . '/admin')) }}
								<button type="submit" class="btn btn-block btn-success">Make Admin</button>
							{{ Form::close() }}
						@endif
						<small>This will add or remove access to this admin panel. This means they can access everything! BE CAREFUL!</small>
					</div>

				</div>
				<br>
				<h4>Danger Zone</h4>
				<hr>
				<div class="row">
					<div class="col-12 col-sm-6 mb-4">
							{{ Form::open(array('url'=>'/admin/users/' . $userShow->id, 'onsubmit' => 'return ConfirmDelete()')) }}
								{{ Form::hidden('_method', 'DELETE') }}
								<button type="submit" class="btn btn-block btn-danger">Delete</button>
							{{ Form::close() }}

					</div>



				</div>
			</div>
		</div>

	</div>
</div>

@endsection
