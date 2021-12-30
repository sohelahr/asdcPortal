@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Import Error Logs
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{url('attendance')}}">Attendance</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{url('attendance/import_summaries')}}">Import Summaries</a></li>
            <li class="breadcrumb-item active" aria-current="page">Import Error Logs</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div id="admissions-by-batches-loader" class="d-none">
            <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                <div class="bar-loader">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>    
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="import_logs_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Date of Attendance</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Date of Attendance</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('jcontent')
    <script>
       var site_path = '{{url('/')}}';
    $(function () {
        loadDatatable();
    });
    function loadDatatable()
    {
        table = $('#import_logs_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            "autoWidth": false,
            "responsive": true,
            'searching':false,
            //bStateSave: true,
            ajax: {
                "url": '{{url("attendance/import_summaries/logs/$id/data")}}',
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
                //"complete": afterRequestComplete
            },
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            columns: [
                {data:  "roll_no", "orderable": false, name: 'roll_no'},
                {data: 'name', name: 'name',"orderable": false},
                {data: 'reason', name: 'reason',"orderable": false},
                {data: 'attendance_date', name: 'attendance_date',"orderable": false}, 
            ]
        });
    }

    </script>
@endsection