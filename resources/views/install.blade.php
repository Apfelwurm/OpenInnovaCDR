@extends ('layouts.default')

@section ('content')

<div class="container">
	<div class="row">
		<div class="col-12 col-sm-12 col-md-12">
			<div class="pb-2 mt-4 mb-4 border-bottom">
				<h1>Hello & Welcome</h1>
			</div>
			<p>Before you can start we need do a litte setup...</p>
			<p>Please Fill out the form below. Once this is done you will be redirected to the Admin Panel.</p>
			{{ Form::open(array('url'=>'/install' )) }}
	            {{ csrf_field() }}
				<h2>Step 1: Create Admin User</h2>
				<hr>
                <div class="row">
                	<div class="col-sm-12 col-md-6">
		                <div class="row">

		                    <div class="col-12">
				                <div class="form-group @error('username') is-invalid @enderror">
				                    {{ Form::label('username','Username',array('id'=>'','class'=>'')) }}
				                    <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required autocomplete="username">
				                </div>
			                    <div class="form-group @error('password1') is-invalid @enderror">
			                        {{ Form::label('password1','Password',array('id'=>'','class'=>'')) }}
			                         <input id="password1" type="password" class="form-control" name="password1" required autocomplete="new-password">
			                    </div>
			                    <div class="form-group @error('password2') is-invalid @enderror">
			                        {{ Form::label('password2','Confirm Password',array('id'=>'','class'=>'')) }}
			                        <input id="password2" type="password" class="form-control" name="password2" required autocomplete="new-password">
			                    </div>
			                    <input id="url" type="hidden" class="form-control" name="url">
			                </div>
			            </div>
			        </div>
                	<div class="col-sm-12 col-md-6">
						<p>Once Installed you can add more admins via the admin panel</p>
                	</div>
	            </div>

		        <h2>Step 2: Confirm settings in the Admin Panel</h2>
		        <hr>
				<div class="row">
					<div class="col-12 col-md-6">
						<button type="submit" class="btn btn-lg btn-block btn-success">Confirm</button>
					</div>
					<div class="col-12 col-md-6">
				        <p>Once Submitted you will be redirected to the Admin Panel where you can changed more settings.</p>
				    </div>
				</div>
	       {{ Form::close() }}
		</div>
	</div>
</div>

@endsection
