@extends ('layouts.admin-default')

@section ('page_title', 'Users')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fa fa-users"></i> Users</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">
				Users
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-12 col-sm-8">

		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-users fa-fw"></i> Users
			</div>
			<div class="card-body">
				<table class="table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>User</th>
							<th>Admin</th>
							<th>Edit</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
							<tr>
								<td>
									{{ $user->username }}
								</td>
								<td>
									@if ($user->isAdmin)
										Yes
									@else
										No
									@endif
								</td>
								<td>
									<a href="/admin/users/{{ $user->id }}">
										<button class="btn btn-primary btn-sm btn-block">Edit</button>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{{ $users->links() }}
			</div>
		</div>

	</div>
    <div class="col-12 col-sm-4">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-plus fa-fw"></i> Create User
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/users/add')) }}
					<div class="form-group">
						{{ Form::label('username','Username',array('id'=>'','class'=>'')) }}
						{{ Form::text('username', NULL ,array('id'=>'username','class'=>'form-control')) }}
					</div>
					<div class="form-group">
						{{ Form::label('password1','Password',array('id'=>'','class'=>'')) }}
                        {{ Form::password('password1',array('id'=>'password1','class' => 'form-control')) }}

					</div>
                    <div class="form-group">
						{{ Form::label('password2','Password repeat',array('id'=>'','class'=>'')) }}
                        {{ Form::password('password2',array('id'=>'password2','class' => 'form-control')) }}

					</div>

					{{ Form::label('options','Options',array('id'=>'','class'=>'')) }}

					<div class="row mt-3">
						<div class="col-lg-6 col-sm-12 form-group">
							<div class="form-check">
								<label class="form-check-label">
									{{ Form::checkbox('isAdmin', null, false, array('id'=>'isAdmin')) }} Make user Admin?
								</label>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-success btn-block">Submit</button>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

@endsection
