@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Registrations
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrations</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        
        <div class="card-body">
            
            <div class="table-responsive">
                         <table class="table table-hover" id="registrations">
                    <thead>
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
                    <tbody>
                    </tbody>
                     <tfoot>
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
                    if(data === true)
                        return "<a class='badge badge-success badge-pill' href='admission/create/"+row.id+"'>Admit</a>"
                    else
                        return "<a class='badge badge-danger badge-pill ml-2'  href='#'><i class='fa fa-frown'></i></a>"

            },name:'action'}
        ]
    });
} );
</script>
@endsection