@extends ('layouts.admin-default')

@section ('page_title', 'Users - View '. $numberFilterSetting->priority)

@section ('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fas fa-newspaper"></i> {{ $numberFilterSetting->priority }}</h3>
        @include ('layouts.admin-warnings')
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/admin/numberfiltersettings/">Number Filter Settings                </a>
			</li>
			<li class="breadcrumb-item active">
				{{ $numberFilterSetting->priority }}
			</li>
		</ol>
	</div>
</div>

<div class="row">
    <div class="col-sm-12 col-lg-4">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-users fa-fw"></i> Edit Number Filter Setting
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/numberfiltersettings/'.$numberFilterSetting->id)) }}

                <div class="form-group">
                    {{ Form::label('priority','Proirity',array('id'=>'','class'=>'')) }}
                            <select class="form-control @error('priority') is-invalid @enderror" name="priority" id="priority" aria-describedby="priority" value="{{ old('priority', $numberFilterSetting->priority) }}">
                                @foreach (App\Models\NumberFilterSetting::getNextPrioritiesAndOwn($numberFilterSetting) as $priority)
                                    <option value="{{ $priority }}" {{ ( $priority == old('priority', $numberFilterSetting->priority)) ? 'selected' : '' }}>
                                        {{ $priority }}
                                    </option>
                                @endforeach
                            </select>
                </div>
                <div class="form-group">
                    {{ Form::label('direction','Direction',array('id'=>'','class'=>'')) }}
                            <select class="form-control @error('direction') is-invalid @enderror" name="direction" id="direction" aria-describedby="direction" value="{{ old('direction', $numberFilterSetting->direction) }}">
                                @foreach (App\Models\NumberFilterSetting::getAvailableDirections() as $direction)
                                    <option value="{{ $direction }}" {{ ( $direction == old('direction', $numberFilterSetting->direction)) ? 'selected' : '' }}>
                                        {{ $direction }}
                                    </option>
                                @endforeach
                            </select>
                </div>
                <div class="form-group">
                    {{ Form::label('filter','Filter',array('id'=>'','class'=>'')) }}
                    {{ Form::text('filter', $numberFilterSetting->filter ,array('id'=>'filter','class'=>'form-control')) }}
                </div>
                 <div class="form-group">
                    {{ Form::label('cost','Cost',array('id'=>'','class'=>'')) }} <small>(for example 0.36)</small>
                    {{ Form::number('cost', $numberFilterSetting->cost ,array('id'=>'cost','class'=>'form-control','step'=>'any')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('cost_multiplier','Cost Multiplier',array('id'=>'','class'=>'')) }}
                            <select class="form-control @error('cost_multiplier') is-invalid @enderror" name="cost_multiplier" id="cost_multiplier" aria-describedby="cost_multiplier" value="{{ old('cost_multiplier', $numberFilterSetting->cost_multiplier) }}">
                                @foreach (App\Models\NumberFilterSetting::getAvailableCostMultipliers() as $cost_multiplier)
                                    <option value="{{ $cost_multiplier }}" {{ ( $cost_multiplier == old('priority', $numberFilterSetting->cost_multiplier)) ? 'selected' : '' }}>
                                        {{ $cost_multiplier }}
                                    </option>
                                @endforeach
                            </select>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        {{ Form::checkbox('ignore_on_timereport', null, $numberFilterSetting->ignore_on_timereport, array('id'=>'ignore_on_timereport')) }} ignore detected calls in time reports
                    </label>

                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        {{ Form::checkbox('ignore_on_costreport', null, $numberFilterSetting->ignore_on_costreport, array('id'=>'ignore_on_costreport')) }} ignore detected calls in cost reports
                    </label>
                </div>





					<button type="submit" class="btn btn-success btn-block">Submit</button>
				{{ Form::close() }}
			</div>
		</div>

	</div>
</div>

@endsection
