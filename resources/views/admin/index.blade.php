@extends ('layouts.admin-default')

@section ('page_title', 'Admin')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom"><i class="fa fa-dashboard"></i> Dashboard</h3>
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
				<i class="fa fa-users fa-fw"></i> Unassigned Callers
			</div>
			<div class="card-body">
				<div class="row">



                    <table class="table table-striped table-hover table-responsive ">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Name</th>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $unassignedCallers->links() }}

				</div>

			</div>
		</div>

	</div>
	</div>



@endsection
