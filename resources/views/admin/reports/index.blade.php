@extends ('layouts.admin-default')

@section ('page_title', 'Organisation Units')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fas fa-newspaper"></i> Reports</h3>
        @include ('layouts.admin-warnings')
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">
				Reports
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-12 col-sm-8">
        <div class="row">
            <div class="col-12 col-sm-12">

                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-newspaper fa-fw"></i> Report Templates
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Type</th>
                                    <th>Output format</th>
                                    <th>Schedule</th>
                                    <th>Timespan</th>
                                    <th>Start date</th>
                                    <th>Edit</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportTemplates as $reportTemplate)
                                    <tr>


                                        <td>
                                            {{ $reportTemplate->id }}
                                        </td>
                                        <td>
                                            {{ $reportTemplate->type }}
                                        </td>
                                        <td>
                                            {{ $reportTemplate->output_format }}
                                        </td>
                                        <td>
                                            {{ $reportTemplate->schedule }}
                                        </td>
                                        <td>
                                            {{ $reportTemplate->timespan }}
                                        </td>
                                        <td>
                                            {{ $reportTemplate->startdate }}
                                        </td>

                                        <td>
                                            <a href="/admin/reports/templates/{{ $reportTemplate->id }}">
                                                <button class="btn btn-primary btn-sm btn-block">Edit</button>
                                            </a>
                                        </td>
                                        <td>
                                            {{ Form::open(array('url'=>'/admin/reports/templates/' . $reportTemplate->id . '/delete' ,'method' => 'delete', 'onsubmit' => 'return ConfirmDelete()')) }}

                                            <button type="submit" class="btn btn-danger btn-sm btn-block">Remove</button>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $reportTemplates->links() }}
                    </div>
                </div>



            </div>

        </div>
        <div class="row">
            <div class="col-12 col-sm-12">

                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-newspaper fa-fw"></i> Reports
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Status</th>
                                    <th>Cause</th>
                                    <th>Start date</th>
                                    <th>End date</th>
                                    <th>From template</th>
                                    <th>Show</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>

                                        <td>
                                            {{ $report->Id }}
                                        </td>
                                        <td>
                                            @if ($report->status == "queued")
                                            <i class="far fa-clock fa-1x" style="color:black"></i> Queued
                                            @endif
                                            @if ($report->status == "running")
                                            <i class="fas fa-play fa-1x" style="color:orange"></i> Running
                                            @endif
                                            @if ($report->status == "finished")
                                            <i class="fa fa-check-circle-o fa-1x" style="color:green"></i> Finished
                                            @endif
                                            @if ($report->status == "error")
                                            <i class="fa fa-times-circle-o fa-1x" style="color:red"></i> Error
                                            @endif
                                        </td>
                                        <td>
                                            {{ $report->cause }}
                                        </td>
                                        <td>
                                            {{ $report->startdate }}
                                        </td>
                                        <td>
                                            {{ $report->enddate }}
                                        </td>
                                        <td>
                                            @if ($report->report_template_id)
                                            {{ $report->report_template_id }}
                                            @else
                                            Deleted
                                            @endif

                                        </td>



                                        <td>
                                            <a href="/admin/reports/{{ $report->id }}">
                                                <button class="btn btn-primary btn-sm btn-block">Show</button>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $reports->links() }}
                    </div>
                </div>



            </div>

        </div>
	</div>
    <div class="col-12 col-sm-4">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-plus fa-fw"></i> Create Report Template
			</div>
			<div class="card-body">
				{{ Form::open(array('url'=>'/admin/reports/templates/add')) }}

                    <div class="form-group">
                        {{ Form::label('type','Proirity',array('id'=>'','class'=>'')) }}
                                <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" aria-describedby="type" value="{{ old('type', App\Models\ReportTemplate::getAvailableTypes()[0]) }}">
                                    @foreach (App\Models\ReportTemplate::getAvailableTypes() as $type)
                                        <option value="{{ $type }}" {{ ( $type == old('type', App\Models\ReportTemplate::getAvailableTypes()[0])) ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                    </div>
                    <div class="form-group">
                        {{ Form::label('output_format','Output format',array('id'=>'','class'=>'')) }}
                                <select class="form-control @error('output_format') is-invalid @enderror" name="output_format" id="output_format" aria-describedby="output_format" value="{{ old('output_format', App\Models\ReportTemplate::getAvailableOutputFormats()[0]) }}">
                                    @foreach (App\Models\ReportTemplate::getAvailableOutputFormats() as $output_format)
                                        <option value="{{ $output_format }}" {{ ( $output_format == old('output_format', App\Models\ReportTemplate::getAvailableOutputFormats()[0])) ? 'selected' : '' }}>
                                            {{ $output_format }}
                                        </option>
                                    @endforeach
                                </select>
                    </div>

                    <div class="form-group">
                        {{ Form::label('schedule','Schedule',array('id'=>'','class'=>'')) }}
                                <select class="form-control @error('schedule') is-invalid @enderror" name="schedule" id="schedule" aria-describedby="schedule" value="{{ old('schedule', App\Models\ReportTemplate::getAvailableSchedules()[0]) }}">
                                    @foreach (App\Models\ReportTemplate::getAvailableSchedules() as $schedule)
                                        <option value="{{ $schedule }}" {{ ( $schedule == old('schedule', App\Models\ReportTemplate::getAvailableSchedules()[0])) ? 'selected' : '' }}>
                                            {{ $schedule }}
                                        </option>
                                    @endforeach
                                </select>
                    </div>

                    <div class="form-group">
                        {{ Form::label('timespan','Timespan',array('id'=>'','class'=>'')) }}
                                <select class="form-control @error('timespan') is-invalid @enderror" name="timespan" id="timespan" aria-describedby="timespan" value="{{ old('timespan', App\Models\ReportTemplate::getAvailableTimespans()[0]) }}">
                                    @foreach (App\Models\ReportTemplate::getAvailableTimespans() as $timespan)
                                        <option value="{{ $timespan }}" {{ ( $timespan == old('timespan', App\Models\ReportTemplate::getAvailableTimespans()[0])) ? 'selected' : '' }}>
                                            {{ $timespan }}
                                        </option>
                                    @endforeach
                                </select>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 form-group">
                            {{ Form::label('start_date','Start Date',array('id'=>'','class'=>'')) }}
                            {{ Form::text('start_date', '',array('id'=>'start_date','class'=>'form-control')) }}
                        </div>
                        <div class="col-lg-6 col-sm-12 form-group">
                            {{ Form::label('start_time','Start  Time',array('id'=>'','class'=>'')) }}
                            {{ Form::text('start_time', '16:00',array('id'=>'start_time','class'=>'form-control')) }}
                        </div>
                    </div>


					<button type="submit" class="btn btn-success btn-block">Submit</button>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<!-- JavaScript-->
<script type="text/javascript">
	jQuery( function() {
		jQuery( "#start_date" ).datepicker();
	});
</script>

@endsection
