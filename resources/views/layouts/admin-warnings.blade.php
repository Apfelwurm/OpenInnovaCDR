@if (App\Libraries\Helpers::isReportRunning())
    <p class="alert alert-warning alert-dismissible fade show">
        <b>Currently a report is running!</b> The editing features are disabled while the report runs, the CDRs will be received normally
    </p>
@endif
