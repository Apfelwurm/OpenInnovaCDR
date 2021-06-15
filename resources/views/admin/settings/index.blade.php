@extends ('layouts.admin-default')

@section ('page_title', 'Settings')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fas fa-cog"></i> Settings</h3>
        @include ('layouts.admin-warnings')
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">
				Settings
			</li>
		</ol>
	</div>
</div>


<div class="row">
	<div class="col-lg-6 col-12">
		<!-- Main -->
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-cog fa-fw"></i> Systemwide Settings
			</div>
			<div class="card-body">
                {{ Form::open(array('url'=>'/admin/settings/', 'onsubmit' => 'return ConfirmSubmit()')) }}

                <table class="table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Setting</th>
							<th>Value</th>
						</tr>
					</thead>
					<tbody>

						@foreach ($settings as $key=>$setting)
							@if (
								$setting->setting != 'installed'
							)
								<tr>
										<td>
											{{ ucwords(str_replace("_"," ",$setting->setting)) }}<br>
											@if ($setting->description != null)
												<small>{{ $setting->description }}</small>
											@endif
										</td>
										<td>
                                            @if ($setting->type == "STRING")
											{{ Form::text($setting->setting, $setting->value ,array('id'=>$setting->setting . $key,'class'=>'form-control')) }}
                                            @endif
                                            @if ($setting->type == "INT")
											{{ Form::number($setting->setting, $setting->value ,array('id'=>$setting->setting . $key,'class'=>'form-control')) }}
                                            @endif
                                            @if ($setting->type == "BOOL")
                                            {{ Form::checkbox($setting->setting, null, $setting->value, array('id'=>$setting->setting)) }}
                                            @endif

										</td>
								</tr>
							@endif
						@endforeach


					</tbody>
				</table>
                <button type="submit" class="btn btn-success btn-sm btn-block">Update</button>
                {{ Form::close() }}
			</div>
		</div>
	</div>


</div>

@endsection
