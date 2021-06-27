<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Telephone bill from {{ $pdfData->report->startdate }} to {{ $pdfData->report->enddate }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  </head>
  <body>
    <table class="table table-bordered">
    <thead>
      <tr class="table-danger">
        <td>Name</td>
        <td>Amount</td>
      </tr>
      </thead>
      <tbody>
        @foreach ($pdfData->reportdata as $data)
        <tr>
            <td>{{ $data->name }}</td>
            <td>{{ $data->amount }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>