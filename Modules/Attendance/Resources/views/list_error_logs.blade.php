@extends('layouts.admin.app')
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Error Logs</h3>
		@endslot
            <li class="breadcrumb-item" aria-current="page"><a href="{{url('attendance')}}">Attendance</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{url('attendance/import_summaries')}}">Import Summaries</a></li>
            <li class="breadcrumb-item active" aria-current="page">Error Logs</li>   
    @endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="import_logs_table" class="display datatables">
                            <thead class="bg-primary">
                            <tr>
                                <th>Roll No</th>
                                <th>Name</th>
                                <th>Error Message</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tfoot class="bg-primary">
                            <tr>
                                <th>Roll No</th>
                                <th>Name</th>
                                <th>Error Message</th>
                                <th>Date</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
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
            "pageLength": 50,
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