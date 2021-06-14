@extends ('layouts.admin-default')

@section ('page_title', 'Admin')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom">Dashboard</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">
				<i class="fa fa-dashboard"></i> Dashboard
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-users fa-fw"></i> Unassigned Callers
			</div>
			<div class="card-body">
				<div class="row">



                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unassignedCallers as $caller)
                                <tr>
                                    <td>
                                        {{ $caller->name }}
                                    </td>
                                    <td>
                                        {{ $caller->number }}
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
