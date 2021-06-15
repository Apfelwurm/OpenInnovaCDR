@extends ('layouts.admin-default')

@section ('page_title', 'Organisation Units')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fa fa-filter"></i> Number Filter Settings</h3>
        @include ('layouts.admin-warnings')
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">
				Number Filter Settings
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-12 col-sm-8">

		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-filter fa-fw"></i> Number Filter Settings
			</div>
			<div class="card-body">
				<table class="table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Priority</th>
							<th>Direction</th>
							<th>Filter</th>
							<th>Cost</th>
							<th>Cost multiplier</th>
							<th>Ignore calls on timereport</th>
							<th>Ignore calls on costreport</th>
							<th>Edit</th>
							<th>Remove</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($numberFilterSettings as $numberFilterSetting)
							<tr>


								<td>
									{{ $numberFilterSetting->priority }}
								</td>
								<td>
                                    @if ($numberFilterSetting->direction == "sender")
                                    <i class="fa fa-shipping-fast fa-1x" style="color:Blue"></i> Sender
                                    @endif
                                    @if ($numberFilterSetting->direction == "receiver")
                                    <i class="fa fa-envelope-open-text fa-1x" style="color:orange"></i> Receiver
                                    @endif
								</td>
								<td>
									{{ $numberFilterSetting->filter }}
								</td>
								<td>
									{{ $numberFilterSetting->cost }}
								</td>
								<td>
									{{ $numberFilterSetting->cost_multiplier }}
								</td>
								<td>
                                    @if ($numberFilterSetting->ignore_on_timereport)
                                    <i class="fa fa-times-circle-o fa-1x" style="color:red"></i> Yes
                                    @else
                                    <i class="fa fa-check-circle-o fa-1x" style="color:green"></i> No
                                    @endif
								</td>
								<td>
                                    @if ($numberFilterSetting->ignore_on_costreport)
                                    <i class="fa fa-times-circle-o fa-1x" style="color:red"></i> Yes
                                    @else
                                    <i class="fa fa-check-circle-o fa-1x" style="color:green"></i> No
                                    @endif
								</td>
								<td>
									<a href="/admin/numberfiltersettings/{{ $numberFilterSetting->id }}">
										<button class="btn btn-primary btn-sm btn-block">Edit</button>
									</a>
								</td>
                                <td>
                                    {{ Form::open(array('url'=>'/admin/numberfiltersettings/' . $numberFilterSetting->id . '/delete' ,'method' => 'delete', 'onsubmit' => 'return ConfirmDelete()')) }}

                                    <button type="submit" class="btn btn-danger btn-sm btn-block">Remove</button>
                                    {{ Form::close() }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{{ $numberFilterSettings->links() }}
			</div>
		</div>

	</div>
    <div class="col-12 col-sm-4">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-plus fa-fw"></i> Create Number Filter Setting
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/numberfiltersettings/add')) }}

                    <div class="form-group">
                        {{ Form::label('priority','Proirity',array('id'=>'','class'=>'')) }}
                                <select class="form-control @error('priority') is-invalid @enderror" name="priority" id="priority" aria-describedby="priority" value="{{ old('priority', App\Models\NumberFilterSetting::getNextPriority()) }}">
                                    @foreach (App\Models\NumberFilterSetting::getNextPriorities() as $priority)
                                        <option value="{{ $priority }}" {{ ( $priority == old('priority', App\Models\NumberFilterSetting::getNextPriority())) ? 'selected' : '' }}>
                                            {{ $priority }}
                                        </option>
                                    @endforeach
                                </select>
                    </div>
                    <div class="form-group">
                        {{ Form::label('direction','Direction',array('id'=>'','class'=>'')) }}
                                <select class="form-control @error('direction') is-invalid @enderror" name="direction" id="direction" aria-describedby="direction" value="{{ old('direction', App\Models\NumberFilterSetting::getAvailableDirections()[0]) }}">
                                    @foreach (App\Models\NumberFilterSetting::getAvailableDirections() as $direction)
                                        <option value="{{ $direction }}" {{ ( $direction == old('direction', App\Models\NumberFilterSetting::getAvailableDirections()[0])) ? 'selected' : '' }}>
                                            {{ $direction }}
                                        </option>
                                    @endforeach
                                </select>
                    </div>
                    <div class="form-group">
						{{ Form::label('filter','Filter',array('id'=>'','class'=>'')) }}
						{{ Form::text('filter', NULL ,array('id'=>'filter','class'=>'form-control')) }}
					</div>
                     <div class="form-group">
						{{ Form::label('cost','Cost',array('id'=>'','class'=>'')) }} <small>(for example 0.36)</small>
						{{ Form::number('cost', NULL ,array('id'=>'cost','class'=>'form-control','step'=>'any')) }}
					</div>
                    <div class="form-group">
                        {{ Form::label('cost_multiplier','Cost Multiplier',array('id'=>'','class'=>'')) }}
                                <select class="form-control @error('cost_multiplier') is-invalid @enderror" name="cost_multiplier" id="cost_multiplier" aria-describedby="cost_multiplier" value="{{ old('cost_multiplier', App\Models\NumberFilterSetting::getAvailableCostMultipliers()[0]) }}">
                                    @foreach (App\Models\NumberFilterSetting::getAvailableCostMultipliers() as $cost_multiplier)
                                        <option value="{{ $cost_multiplier }}" {{ ( $cost_multiplier == old('priority', App\Models\NumberFilterSetting::getAvailableCostMultipliers()[0])) ? 'selected' : '' }}>
                                            {{ $cost_multiplier }}
                                        </option>
                                    @endforeach
                                </select>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            {{ Form::checkbox('ignore_on_timereport', null, false, array('id'=>'ignore_on_timereport')) }} ignore detected calls in time reports
                        </label>

                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            {{ Form::checkbox('ignore_on_costreport', null, false, array('id'=>'ignore_on_costreport')) }} ignore detected calls in cost reports
                        </label>
                    </div>




					<button type="submit" class="btn btn-success btn-block">Submit</button>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

@endsection
