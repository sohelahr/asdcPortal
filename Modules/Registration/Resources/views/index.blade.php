@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Registrations</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Registrations</li>
	@endcomponent
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
	            <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="dislay datatable" id="registrations">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 30px">No</th>
                                        <th>Reg Number</th>
                                        <th>Student Name</th>
                                        <th>Course Name</th>
                                        <th>Course Timing</th>
                                        <th>Registered On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot class="bg-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Reg Number</th>
                                        <th>Student Name</th>
                                        <th>Course Name</th>
                                        <th>Course Timing</th>
                                        <th>Registered On</th>
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
    
    $(document).ready( function () {
    $('#registrations').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        searching: true,
        "autoWidth": false,
        "responsive": true,
        ajax: {    
            "url": "{{route('all_registrations')}}",
            "dataType": "json",
            "type": "POST",
            "data":{ _token: "{{csrf_token()}}"}
        },
         columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        },{
            className: 'text-center',
            'targets':[6]
        }],
        columns:[
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'registration_no', name: 'registration_no'},
            {data: 'student_name',render:function(data,type,row){
                 if(type === "display"){
                        return "<a href='userprofile/admin/"+row.student_id+"/viewfromother' target='_blank'>"+data+"</a>"
                }
            },
             name: 'student_name'},
            {data: 'course_name',name:"course_name"},
            {data: 'course_slot',name:"course_slot"},
            {data: 'date',name:"date"},
            {data:'action',render:function(data,type,row){
                    if(data === true){
                        if(row.status == 1){
                            return "<a class='text-success' href='admission/create/"+row.id+"'>Admit</a>"
                        }
                        else if(row.status == 2){
                            return "<span class='text-warning' href=''>Admitted</span>"
                        }
                        else{
                            return "<span class='text-danger' href=''>Cancelled</span>"
                        }
                    }
                    else{
                        return ;
                    }
            },name:'action',orderable:false}
        ]
    });
} );
</script>
@endsection