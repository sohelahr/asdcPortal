@extends('layouts.admin.app')
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Import Summaries</h3>
		@endslot
            <li class="breadcrumb-item" aria-current="page"><a href="{{url('attendance')}}">Attendance</a></li>
            <li class="breadcrumb-item active" aria-current="page">Import Summaries</li>    
    @endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div id="admissions-by-batches-loader" class="d-none">
                    <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                        <div> 
                            <div class="loader-box">
                                <div class="loader-7"></div>
                            </div>              
                        </div>  
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="import_sumarry_table" class="display datatables">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No.</th>                            
                                    <th>Total Records</th>
                                    <th>Success Records</th>
                                    <th>Failed Records</th>
                                    <th>Status</th>
                                    <th>Error Logs</th>
                                    <th>Imported On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot class="bg-primary">
                                <tr>
                                    <th>No.</th>                            
                                    <th>Total Records</th>
                                    <th>Success Records</th>
                                    <th>Failed Records</th>
                                    <th>Status</th>
                                    <th>Error Logs</th>
                                    <th>Imported On</th>
                                    <th>Action</th>
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
        function Notify(title,msg,status){
            $.notify({
                    title:title,
                    message:msg
                },
                {
                    type:status,
                    allow_dismiss:true,
                    newest_on_top:false ,
                    mouse_over:true,
                    showProgressbar:false,
                    spacing:10,
                    timer:2000,
                    placement:{
                        from:'top',
                        align:'center'
                    },
                    offset:{
                        x:30,
                        y:30
                    },
                    delay:1000 ,
                    z_index:10000,
                    animate:{
                        enter:'animated pulse',
                        exit:'animated bounce'
                    }
            });
        }
        @if(\Illuminate\ Support\ Facades\ Session::has('published'))
            Notify('Publish','Attendance was successfully published','success')
        @elseif(\Illuminate\ Support\ Facades\ Session::has('error'))
            Notify('Danger','Something went wrong','danger')
        @endif
        var site_path = '{{url("/")}}';
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
                'class':'text-center',
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
                                return '<span title="InActive" class="text-info">Pending</span>';
                            }
                            else if(data === "1")
                            {
                                return '<span title="Active" class="text-success">Succeeded</span>';
                            }
                            else if(data === "2")
                            {
                                return '<span title="Active" class="txt-secondary"> Partially Succeeded</span>';
                            }
                            else
                            {
                                return '<span title="Blocked" class="text-danger">Failed</span>';
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
                            return '<a class="nav-link" href="'+site_path+'/attendance/import_summaries/logs/'+row.id+'">View Logs</a>';
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

                            html_content += '<a class="badge badge-info" href="'+site_path+'/attendance/import_summaries/download/'+btoa(row.original_file)+'/original" title="Original Records"><i class="fa fa-file-excel-o"></i></a>&nbsp;';

                            if(row.success_record != '0')
                            {
                                html_content += '<a class="badge badge-success" href="'+site_path+'/attendance/import_summaries/download/'+btoa(row.success_transaction_file)+'/success" title="Success Records"><i class="fa fa-file-excel-o"></i></a>&nbsp;';
                            }
                            
                            if(row.failed_record != '0')
                            {
                                html_content += '<a class="badge badge-danger" href="'+site_path+'/attendance/import_summaries/download/'+btoa(row.failed_transaction_file)+'/failed" title="Failed Records"><i class="fa fa-file-excel-o"></i></a>&nbsp;';
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