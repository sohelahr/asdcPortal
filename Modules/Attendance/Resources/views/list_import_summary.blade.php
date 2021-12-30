@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Import Summaries
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{url('attendance')}}">Attendance</a></li>
            <li class="breadcrumb-item active" aria-current="page">Import Summaries</li>
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
               <table id="import_sumarry_table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>                            
                            <th>Total Record</th>
                            <th>Success Record</th>
                            <th>Failed Record</th>
                            <th>Status</th>
                            <th>Error Logs</th>
                            <th>Imported At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>                            
                            <th>Total Record</th>
                            <th>Success Record</th>
                            <th>Failed Record</th>
                            <th>Status</th>
                            <th>Error Logs</th>
                            <th>Imported At</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
@endsection
@section('jcontent')
    <script>
        @if(\Illuminate\ Support\ Facades\ Session::has('published'))
            $.toast({
                heading: 'Publish',
                text: 'Attendance was successfully published',
                position: 'top-right',
                icon: 'success',
                loader: true, // Change it to false to disable loader
                loaderBg: '#9EC600' // To change the background
            })

        @elseif(\Illuminate\ Support\ Facades\ Session::has('error'))
            $.toast({
                heading: 'Danger',
                text: 'Something Went Wrong ',
                position: 'top-right',
                icon: 'danger',
                loader: true, // Change it to false to disable loader
                loaderBg: '#9EC600' // To change the background
            })
        @endif
        var site_path = '{{url('/')}}';
    $(function () {
        loadDatatable();
    });
    function loadDatatable()
    {
        table = $('#import_sumarry_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            "autoWidth": false,
            "responsive": true,
            "searching":false,
            //bStateSave: true,
            ajax: {
                "url": '{{url("/attendance/import_summaries/data")}}',
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
                {data:  "id", "orderable": false, name: 'id'},
                {data: 'total_record', name: 'total_record',"orderable": false},
                {data: 'success_record', name: 'success_record',"orderable": false},
                {data: 'failed_record', name: 'failed_record',"orderable": false},
                {data:   "status",
                    render: function ( data, type, row ) {
                        if ( type === 'display' )
                        {
                            if(data === "0")
                            {
                                return '<span title="InActive" class="badge badge-info">Pending</span>';
                            }
                            else if(data === "1")
                            {
                                return '<span title="Active" class="badge badge-success"> Fully Succeed</span>';
                            }
                            else if(data === "2")
                            {
                                return '<span title="Active" class="badge badge-warning"> Partially Succeed</span>';
                            }
                            else
                            {
                                return '<span title="Blocked" class="badge badge-danger">Failed</span>';
                            }
                        }
                        //return data;
                    },
                    "orderable": false,
                    name: 'status'
                },
                {data:  'error_log',
                    render: function ( data, type, row ) {
                        if ( type === 'display' )
                        {
                            return '<a class="nav-link" href="'+site_path+'/attendance/import_summaries/logs/'+row.id+'">View Error Logs</a>';
                        }
                        //return data;
                    },
                    "orderable": false,
                    name:"error_log"},
                {data: 'created_at', name: 'created_at',"orderable": false},
                {data:   "action",
                    render: function ( data, type, row ) {
                        if ( type === 'display' )
                        {
                            var html_content = '';

                            html_content += '<a class="btn btn-info btn-sm" href="'+site_path+'/attendance/import_summaries/download/'+btoa(row.original_file)+'/original" title="Download Original Record"><i class="fas fa-file-excel"></i></a>&nbsp;';

                            if(row.success_record != '0')
                            {
                                html_content += '<a class="btn btn-success btn-sm" href="'+site_path+'/attendance/import_summaries/download/'+btoa(row.success_transaction_file)+'/success" title="Download Success Record"><i class="fas fa-file-excel"></i></a>&nbsp;';
                            }
                            
                            if(row.failed_record != '0')
                            {
                                html_content += '<a class="btn btn-danger btn-sm" href="'+site_path+'/attendance/import_summaries/download/'+btoa(row.failed_transaction_file)+'/failed" title="Download Failed Record"><i class="fas fa-file-excel"></i></a>&nbsp;';
                            }
                            
                            return html_content;
                        }
                        //return data;
                    },
                    "orderable": false,
                    name: 'action'
                },
            ]
        });
    }

    </script>
@endsection