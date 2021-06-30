@if (App\Libraries\Helpers::isReportRunning())
    <p class="alert alert-warning alert-dismissible fade show">
        <b>Currently a report is running!</b> The editing features are disabled while the report runs, the CDRs will be received normally
    </p>
@endif

@if (config('app.debug'))
    <p class="alert alert-warning alert-dismissible fade show">
        App is in debug mode, please consider reading the documentation again carefully if you plan to run this in production!
    </p>
@endif



