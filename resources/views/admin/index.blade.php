@extends ('layouts.admin-default')

@section ('page_title', 'Admin')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fa fa-dashboard"></i> Dashboard</h3>
        @include ('layouts.admin-warnings')
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">
				Dashboard
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-md-auto">
		<div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-8">
				        <i class="fa fa-list-ul fa-fw"></i> Statistics
                    </div>
                    <div class="col-sm-4">
                    </div>

                </div>
			</div>

			<div class="card-body">
				<div class="row">

                    <table class="table table-striped table-hover table-responsive ">
                        
                        <tbody>
                                <tr>
                                    <td>
                                    Total CDR entrys
                                    </td>
                                    <td>
                                        {{ App\Models\PhoneCall::all()->count() }}
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                    Total Callers
                                    </td>
                                    <td>
                                        {{ App\Models\Caller::all()->count() }}
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                    Total Organisation Units
                                    </td>
                                    <td>
                                        {{ App\Models\OrganisationUnit::all()->count() }}
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                    Total Number Filter Settings
                                    </td>
                                    <td>
                                        {{ App\Models\NumberFilterSetting::all()->count() }}
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                    Total Caller Prefixes
                                    </td>
                                    <td>
                                        {{ App\Models\CallerPrefix::all()->count() }}
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                    Total Report Templates
                                    </td>
                                    <td>
                                        {{ App\Models\ReportTemplate::all()->count() }}
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                    Total Reports
                                    </td>
                                    <td>
                                        {{ App\Models\Report::all()->count() }}
                                    </td>                                    
                                </tr>
                        </tbody>
                    </table>
                    

				</div>

			</div>
		</div>

	</div>
    <div class="col-md-auto">
		<div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-8">
				        <i class="fa fa-phone fa-fw"></i> Unassigned Callers
                    </div>
                    <div class="col-sm-4">
                        {{ $unassignedCallers->links('vendor.pagination.default') }}
                    </div>

                </div>
			</div>

			<div class="card-body">
				<div class="row">

                    <table class="table table-striped table-hover table-responsive ">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Name</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unassignedCallers as $caller)
                                <tr>
                                    <td>
                                        {{ $caller->number }}
                                    </td>
                                    <td>
                                        {{ $caller->name }}
                                    </td>
                                    <td>
                                        <a href="/admin/callers/{{ $caller->id }}">
                                            <button class="btn btn-primary btn-sm btn-block">Edit</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $unassignedCallers->links('vendor.pagination.default') }}

				</div>

			</div>
		</div>

	</div>
    <div class="col-md-auto">
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-8">
				        <i class="fa fa-newspaper fa-fw"></i> Last Reports
                    </div>
                    <div class="col-sm-4">
                        {{ $reports->links('vendor.pagination.default') }}
                    </div>

                </div>
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
                {{ $reports->links('vendor.pagination.default') }}
            </div>
        </div>

	</div>
	</div>



@endsection
