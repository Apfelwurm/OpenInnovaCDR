@extends ('layouts.admin-default')

@section ('page_title', 'Users - View '. $reportTemplate->id)

@section ('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom">{{ $reportTemplate->id }}</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/admin/reports/templates/">Report Template</a>
			</li>
			<li class="breadcrumb-item active">
				{{ $reportTemplate->id }}
			</li>
		</ol>
	</div>
</div>

<div class="row">
    <div class="col-sm-12 col-lg-4">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-users fa-fw"></i> Edit Report Template
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/reports/templates/'.$reportTemplate->id)) }}

                <div class="form-group">
                    {{ Form::label('type','Proirity',array('id'=>'','class'=>'')) }}
                            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" aria-describedby="type" value="{{ old('type', $reportTemplate->type) }}">
                                @foreach (App\Models\ReportTemplate::getAvailableTypes() as $type)
                                    <option value="{{ $type }}" {{ ( $type == old('type', $reportTemplate->type)) ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                </div>
                <div class="form-group">
                    {{ Form::label('output_format','Output format',array('id'=>'','class'=>'')) }}
                            <select class="form-control @error('output_format') is-invalid @enderror" name="output_format" id="output_format" aria-describedby="output_format" value="{{ old('output_format', $reportTemplate->output_format) }}">
                                @foreach (App\Models\ReportTemplate::getAvailableOutputFormats() as $output_format)
                                    <option value="{{ $output_format }}" {{ ( $output_format == old('output_format', $reportTemplate->output_format)) ? 'selected' : '' }}>
                                        {{ $output_format }}
                                    </option>
                                @endforeach
                            </select>
                </div>

                <div class="form-group">
                    {{ Form::label('schedule','Schedule',array('id'=>'','class'=>'')) }}
                            <select class="form-control @error('schedule') is-invalid @enderror" name="schedule" id="schedule" aria-describedby="schedule" value="{{ old('schedule', $reportTemplate->schedule) }}">
                                @foreach (App\Models\ReportTemplate::getAvailableSchedules() as $schedule)
                                    <option value="{{ $schedule }}" {{ ( $schedule == old('schedule', $reportTemplate->schedule)) ? 'selected' : '' }}>
                                        {{ $schedule }}
                                    </option>
                                @endforeach
                            </select>
                </div>

                <div class="form-group">
                    {{ Form::label('timespan','Timespan',array('id'=>'','class'=>'')) }}
                            <select class="form-control @error('timespan') is-invalid @enderror" name="timespan" id="timespan" aria-describedby="timespan" value="{{ old('timespan', $reportTemplate->timespan) }}">
                                @foreach (App\Models\ReportTemplate::getAvailableTimespans() as $timespan)
                                    <option value="{{ $timespan }}" {{ ( $timespan == old('timespan', $reportTemplate->timespan)) ? 'selected' : '' }}>
                                        {{ $timespan }}
                                    </option>
                                @endforeach
                            </select>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 form-group">

                            {{ Form::label('start_date','Start Date',array('id'=>'','class'=>'')) }}
                            {{ Form::text('start_date', date('m/d/Y', strtotime($reportTemplate->startdate)),array('id'=>'start_date','class'=>'form-control')) }}
                    </div>
                    <div class="col-md-6 col-sm-12 form-group">
                            {{ Form::label('start_time','Start Time',array('id'=>'','class'=>'')) }}
                            {{ Form::text('start_time', date('H:i', strtotime($reportTemplate->startdate)),array('id'=>'start_time','class'=>'form-control')) }}
                    </div>
                </div>





					<button type="submit" class="btn btn-success btn-block">Submit</button>
				{{ Form::close() }}
			</div>
		</div>

	</div>
</div>

@endsection
